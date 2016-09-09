<?php

/* ========================================================================
 * $Id: onezphp.php 16312 2016-09-04 16:20:56Z onez $
 * http://ai.onez.cn/
 * Email: www@onez.cn
 * QQ: 6200103
 * ========================================================================
 * Copyright 2016-2016 佳蓝科技.
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ======================================================================== */


error_reporting(E_ERROR | E_WARNING | E_PARSE);
define('IN_ONEZ', TRUE);
define('ONEZ_ROOT', dirname(dirname(__FILE__)));
define('ONEZ_VERSION', '1.0');
define('ONEZ_NODE_PATH', '/plugins');
define('ONEZ_MYNODE_PATH', '/myplugins');
ob_start();
if(function_exists(session_cache_limiter))session_cache_limiter('private, must-revalidate');

class onezphp{
  var $vars=array();
  function __call($name,$arguments){
  }
  /**
  * 加载一个插件
  * 
  * @param string $token 插件标识
  * @param int $id 实例标识，用于重复生成类
  * 
  * @return class
  */
  function load($token,$id=0){
    global $G;
    !$token && onez('error')->system('1001','标识描述错误');
    $token=$this->getToken($token);
    $key="$token-$id";
    if($id!==-1){
      if($G[$key]){
        return $G[$key];
      }
    }else{
      $G['num-'.$token]++;
      $key=$token.'-'.$G['num-'.$token];
    }
    $AUTOFETCH=1;
    $classFile=onez()->exists($token);
    if($classFile===false){
      if(onez()->exists('fetch',0)){
        onez('fetch')->get($token);
        $classFile=onez()->exists($token);
      }
    }
    if($classFile===false){
      if(!onez()->exists('error',0)){
        exit('插件不存在['.$token.']');
      }
      onez('error')->system('1002','插件不存在');
    }
    include_once($classFile);
    $clsName="onezphp_$token";
    $clsName=str_replace('.','_',$clsName);
    if(!class_exists($clsName)){
      onez('error')->system('1003','插件类名有误');
    }
    !$this->token && $this->token='onez';
    $onez=new $clsName($id);
    $onez->id=$id;
    $onez->token=$token;
    $onez->key=$key;
    $onez->up=$this->token;
    $onez->cToken=$this->token.'-'.$token;
    $onez->path=dirname($classFile);
    $onez->url=onez()->homepage().substr($onez->path,strlen(ONEZ_ROOT));
    
    $onez->tags=array();
    $onez->config=array();
    $G['nodes'][$token]++;
    if(file_exists($onez->path.'/lib/config.php')){
      $onez->config=include($onez->path.'/lib/config.php');
    }
    $G[$key]=$onez;
    return $onez;
  }
  function g($key){
    global $G;
    return $G[$key];
  }
  function view($method){
    $url=onez()->homepage().'/lib/onezphp.php?_view=/'.$this->token.'/'.$method;
    if($this->id!=0){
      $url.='&_viewid='.$this->id;
    }
    return $url;
  }
  function www($method=false){
    if($method===false){
      onez()->start($this->path);
    }else{
      return $this->view('www&mod='.str_replace('?','&',$method));
    }
  }
  function autoview($method,$show=0){
    if($show==1){
      $curMethod=onez()->gp('_method');
      parse_str($curMethod?$curMethod:$method,$info);
      $method=key($info);
      unset($info[$method]);
      if(method_exists($this,$method)){
        $this->myargs=array_keys($info);
        foreach($info as $k=>$v){
          $_REQUEST[$k]=$_GET[$k]=$v;
        }
        call_user_func_array(array($this,$method),$info);
      }
      return;
    }
    $get=$_GET;
    if($this->myargs){
      foreach($this->myargs as $k){
        unset($get[$k]);
      }
    }
    $get['_method']=$method;
    return $_SERVER['PHP_SELF'].'?'.http_build_query($get);
  }
  function set($key,$value){
    $this->vars[$key]=$value;
    return $this;
  }
  function get($key,$def=false){
    $value=$this->vars[$key];
    if($def!==false && !isset($this->vars[$key])){
      return $def;
    }
    return $value;
  }
  function times($times=1){
    if($this->_times>=$times){
      return false;
    }
    $this->_times++;
    return true;
  }
}
/**
* sss
*/
class onezphp_onezphp extends onezphp{
  /**
  * 读取远程网址代码
  * 
  * @param string $url 请求的网址
  * @param mixed $fields 需要post的参数
  * @param array $options 附加选项
  * 
  * @return mixed 直接返回目标输出的内容
  */
  function post($url,$fields='',$options=null){
    global $G;
    if(!function_exists('curl_init')){
      return onez()->mypost($url,$fields,$options);
    }
    global $G;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if(strpos($url,'https://')!==false){
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
    }
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.0.19) Gecko/2010031422 Firefox/3.0.19');
    curl_setopt($ch, CURLOPT_TIMEOUT, $options['timeout'] ? $options['timeout'] : 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, $options['header']);
    $options['headers'] && curl_setopt($ch, CURLOPT_HTTPHEADER, $options['headers']);
    if($options['cookie']){
      if(file_exists($options['cookie'])){
        curl_setopt($ch, CURLOPT_COOKIEJAR, $options['cookie']);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $options['cookie']);
      }else{
        curl_setopt($ch, CURLOPT_COOKIE, $options['cookie']);
      }
    }
    curl_setopt($ch, CURLOPT_REFERER,$options['baseurl'] ? $options['baseurl'] : $url);
    if($fields){
      curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
      curl_setopt($ch, CURLOPT_POST,1);
    }
    $output = curl_exec($ch);
    $G['error_post']=curl_error($ch);
    curl_close($ch);
    return $output;
  }
  /**
  * 规范token
  * @param undefined $token
  * 
  * @return
  */
  function getToken($token){
    $token=preg_replace('/[^0-9a-zA-Z_\.]+/i','_',$token);
    return $token;
  }
  /**
  * 判断插件是否存在
  * @param undefined $token
  * 
  * @return
  */
  function exists($token,$canRewrite=1){
    $token=$this->getToken($token);
    
    $PATH=ONEZ_ROOT.ONEZ_MYNODE_PATH;
    $classFile=$PATH.'/'.$token.'/'.$token.'.php';
    if(file_exists($classFile)){
      return $classFile;
    }
    
    $PATH=ONEZ_ROOT.ONEZ_NODE_PATH;
    $classFile=$PATH.'/'.$token.'/'.$token.'.php';
    if($canRewrite && function_exists('_plugin_rewrite')){
      _plugin_rewrite($token,$classFile);
    }
    
    if(!file_exists($classFile)){
      return false;
    }
    return $classFile;
  }
  /**
  * 读取本地文件数据
  * 
  * @param string $filename 文件名
  * @param string $method 默认rb
  * 
  * @return mixed 文件数据
  */
  function read($filename,$method="rb"){
    if(!file_exists($filename)){
      return;
    }
    if($handle=@fopen($filename,$method)){
      flock($handle,LOCK_SH);
      $filedata=fread($handle,filesize($filename));
      fclose($handle);
    }
    return $filedata;
  }
  /**
  * 写入本地文件
  * 
  * @param string $filename 文件名
  * @param mixed $data 文件内容
  * @param string $method 写入方式,a+为追加
  * @param boolean $iflock
  * 
  * @return
  */
  function write($filename,$data,$method="rb+",$iflock=1){
    $this->mkdirs(dirname($filename));
    touch($filename);
    $handle=fopen($filename,$method);
    if($iflock){
      flock($handle,LOCK_EX);
    }
    fwrite($handle,$data);
    if($method=="rb+") ftruncate($handle,strlen($data));
    fclose($handle);
  }
  /**
  * 强行跳转网址
  * 
  * @param string $url 要跳转的网址
  * 
  * @return
  */
  function location($url){
    header("location:$url");
    exit();
  }
  /**
   * 创建多级目录
   * 
   * @param string $dir 要创建的完整路径
   * 
   * @return
   */
  function mkdirs($dir){
    if(!is_dir($dir)){
      $this->mkdirs(dirname($dir));
      mkdir($dir,0777);
    }
    return;
  }
  /**
  * 编码转换
  * 
  * @param string $from 当前编码
  * @param string $to 目标编码
  * @param string $string 字符串
  * 
  * @return string
  */
  function iconv($from,$to,$string){
    if(function_exists('mb_convert_encoding')){
      return mb_convert_encoding($string,$to,$from);
    }else{
      return iconv($from,$to,$string);
    }
  }
  
  /**
  * 加解密字符串
  * 
  * @param string $string 字符串
  * @param string $action ENCODE加密,DECODE解密
  * @param string $rndKey 密钥
  * 
  * @return mixed
  */
  function strcode($string,$action='ENCODE',$rndKey='onez'){
    global $G;
    $G['rndKey'] && $rndKey=$G['rndKey'];
    $action != 'ENCODE' && $string = base64_decode($string);
    $code = '';
    $key  = substr(md5($rndKey),8,18);
    $keylen = strlen($key); $strlen = strlen($string);
    for ($i=0;$i<$strlen;$i++) {
      $k		= $i % $keylen;
      $code  .= $string[$i] ^ $key[$k];
    }
    return ($action!='DECODE' ? base64_encode($code) : $code);
  }
  /**
  * 读写cookie信息
  * 
  * @param string $var 键
  * @param string $value 值(null时为读取，其他为写入)
  * @param int $life
  * @param boolean $prefix
  * 
  * @return
  */
  function cookie($var, $value=null,$life=0,$prefix=1) {
    global $G,$_COOKIE;
    $time=time();
    !$G['cookiepre'] && $G['cookiepre']='onez_cn_';
    if($value==null){
      return $_COOKIE[$G['cookiepre'].$var] ? $_COOKIE[$G['cookiepre'].$var] : $_COOKIE[',_'.$G['cookiepre'].$var];
    }elseif($value=='del'){
      $value='';
      $life=-20;
    }
    $cookiedomain=$G['cookiedomain'];
    $cookiepath='/';
    setcookie(($prefix ? $G['cookiepre'] : '').$var, $value,
      $life ? $time + $life : 0, $cookiepath,
      $cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
  }
  /**
  * 读取用户get或post的信息
  * 
  * @param string $keys 键
  * @param string $method 方法:G get,P post
  * @param boolean $cvtype 是否为数字
  * 
  * @return string
  */
  function gp($keys,$cvtype=1,$method=null){
    global $G;
    if($method=='G'){
      $value=$_GET[$keys];
    }elseif($method=='P'){
      $value=$_POST[$keys];
    }else{
      $value=$_REQUEST[$keys];
    }
    $G['gp_'.$keys]=$value;
    if (!empty($cvtype) || $cvtype==2) {
      $value = $this->charcv($value,$cvtype==2,true);
    }
    $value=='undefined' && $value='';
    return $value;
  }
  /**
  * 读取变量
  * 
  * @param mixed $mixed 字符串
  * @param boolean $isint 是否为数字
  * @param boolean $istrim 是否去除空格
  * 
  * @return
  */
  function charcv($mixed,$isint=false,$istrim=false) {
    if (is_array($mixed)) {
      foreach ($mixed as $key => $value) {
        $mixed[$key] = $this->charcv($value,$isint,$istrim);
      }
    } elseif ($isint) {
      $mixed = (int)$mixed;
    } elseif (!is_numeric($mixed) && ($istrim ? $mixed = trim($mixed) : $mixed) && $mixed) {
      $mixed = str_replace(array("\0","%00","\r"),'',$mixed);
      $mixed = preg_replace(
        array('/[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]/','/&(?!(#[0-9]+|[a-z]+);)/is'),
        array('','&amp;'),
        $mixed
      );
      $mixed = str_replace(array("%3C",'<'),'&lt;',$mixed);
      $mixed = str_replace(array("%3E",'>'),'&gt;',$mixed);
      $mixed = str_replace('&amp;','&',$mixed);
      $mixed = str_replace(array('"',"'","\t",'  '),array('&quot;','&#39;','    ','&nbsp;&nbsp;'),$mixed);
    }
    return $mixed;
  }
  function stripslashes($string, $force = 0) {
    if(is_array($string)) {
      foreach($string as $key => $val) {
        $string[$key] = $this->stripslashes($val, $force);
      }
    } else {
      $string = stripslashes($string);
    }
    return $string;
  }
  /**
  * 截取utf-8格式的部分字符串
  * 
  * @param string $str
  * @param int $start
  * @param int $length
  * @param string $charset
  * @param boolean $suffix
  * 
  * @return string
  */
  function substr($str, $start=0, $length, $charset="utf-8", $suffix=true){
    if(function_exists("mb_substr")){
      if(mb_strlen($str, $charset) <= $length) return $str;
      $slice = mb_substr($str, $start, $length, $charset);
    }else{
      $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
      $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
      $re['gbk&']     = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
      $re['big5']     = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
      preg_match_all($re[$charset], $str, $match);
      if(count($match[0]) <= $length) return $str;
      $slice = join("",array_slice($match[0], $start, $length));
    }
    if($suffix) return $slice."…";
    return $slice;
  }
  /**
  * 获取utf-8字符串的长度
  * 
  * @param string $string
  * 
  * @return string
  */
  function strlen($string = null) {
    preg_match_all("/[0-9]{1}/",$string,$arrNum);  
    preg_match_all("/[a-zA-Z]{1}/",$string,$arrAl);  
    preg_match_all("/./us",$string,$arrCh); 
    return count($arrNum[0]+$arrAl[0]+$arrCh[0]);
  }
  /**
  * 获取当前用户的IP地址
  * 
  * @return
  */
  function ip(){
    global $G;
    if($G['onlineip']){
      return $G['onlineip'];
    }
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
      $onlineip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
      $onlineip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
      $onlineip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
      $onlineip = $_SERVER['REMOTE_ADDR'];
    }
    $onlineip = preg_replace("/^([\d\.]+).*/", "\\1", $onlineip);
    $G['onlineip']=$onlineip;
    return $onlineip;
  }
  /**
  * 自动获取当前程序根目录网址
  * 
  * @return
  */
  function homepage(){
    global $G;
    #分析当前网址
    if(!$G['homepage']){
      !$_SERVER['REQUEST_SCHEME'] && $_SERVER['REQUEST_SCHEME']='http';
      $homepage=$_SERVER['REQUEST_SCHEME'].'://';
      $homepage.=$_SERVER['HTTP_HOST'];
      $_SERVER['SERVER_PORT']!='80' && $homepage.=':'.$_SERVER['SERVER_PORT'];
      $key=substr(ONEZ_ROOT,strlen($_SERVER['DOCUMENT_ROOT']));
      $key=str_replace('\\','/',$key);
      $homepage.=$key;
      $G['homepage']=$homepage;
    }
    return $G['homepage'];
  }
  /**
  * 自动获取当前网址
  * 
  * @return
  */
  function cururl($add=false,$del=false){
    $get=$_REQUEST;
    $o=explode('/',onez()->homepage());
    if($add){
      foreach($add as $k=>$v){
        $get[$k]=$v;
      }
    }
    if($del){
      foreach($del as $k){
        unset($get[$k]);
      }
    }
    return implode('/',array_slice($o,0,3)).$_SERVER['PHP_SELF'].'?'.http_build_query($get);
  }
  function thisurl(){
    $url=$_SERVER['PHP_SELF'];
    if($_GET){
      $url.='?'.http_build_query($_GET);
    }
    return $url;
  }
  function start($root=false){
    global $G;
    $mod=onez()->gp('mod');
    (!$mod || $mod=='/') && $mod='index.php';
    $mod=preg_replace('/[\.\/]+\//i','/',$mod);
    $mod=trim($mod,'/');
    
    if(!$root){
      $root=getcwd();
    }
    $modFile=$root.'/www/'.$mod;
    if(file_exists($modFile)){
      
      $path='/';
      $inits=array('/');
      foreach(explode('/',substr(dirname($modFile),strlen(ONEZ_ROOT))) as $v){
        $v=trim($v);
        if($v && $v!='.'){
          $path.=$v.'/';
          $inits[]=$path;
        }
      }
      
      foreach($inits as $v){
        $initFile=ONEZ_ROOT.$v.'init.php';
        if(file_exists($initFile)){
          include_once($initFile);
        }
      }
      
      include($modFile);
      exit();
    }else{
      echo 'MOD"'.$mod.'"不存在';
    }
    return false;
  }
  function href($href){
    return '?mod='.str_replace('?','&',$href);
  }
  function output($A){
    echo json_encode($A);
    exit();
  }
  function ok($text,$url){
    $A=array(
      'status'=>'success',
      'message'=>$text?$text:'操作成功',
      'goto'=>$url,
    );
    echo json_encode($A);
    exit();
  }
  function error($text){
    $A=array(
      'error'=>$text,
    );
    echo json_encode($A);
    exit();
  }
}
function onez($token='onezphp',$id=0){
  if($token=='onezphp'){
    return new onezphp_onezphp;
  }
  return onez()->load($token,$id);
}

#强制编码
header('Content-Type:text/html;charset=utf-8');
#全局配置文件
$conFile=ONEZ_ROOT.'/config/global.php';
if(file_exists($conFile)){
  include($conFile);
}
if(isset($_REQUEST['_view'])){
  $view=onez()->gp('_view');
  $id=(int)onez()->gp('_viewid');
  list($token,$method)=explode('/',trim($view,'/'));
  if(method_exists(onez($token),$method)){
    call_user_func_array(array(onez($token,$id),$method),array());
  }
}