<?php

/* ========================================================================
 * $Id: cache.php 2836 2016-09-07 14:51:24Z onez $
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


!defined('IN_ONEZ') && exit('Access Denied');
/**
* 本地与服务器缓存
*/
class onezphp_cache extends onezphp{
  function __construct(){
    
  }
  /**
  * 读写当前访客的cookie
  * @param mixed $key
  * @param mixed $value
  * 
  * @return
  */
  function cookie($key,$value=false,$once=0){
    if($value===false){
      $cookie=onez()->cookie($key);
      if(empty($cookie))return'';
      $value=onez()->strcode($cookie,'DECODE');
      $value=unserialize($value);
      return $value;
    }else{
      $value=onez()->strcode(serialize($value),'ENCODE');
      onez()->cookie($key,$value,$once?0:86400*365*10);
    }
  }
  /**
  * 读取+写入缓存共用函数
  * @param mixed $key
  * @param mixed $value
  * 
  * @return
  */
  function info($key,$value=false){
    if($value===false){
      return $this->get($key);
    }else{
      $this->set($key,$value);
      return $this;
    }
  }
  /**
  * 写入缓存
  * @param mixed $key
  * @param mixed $value
  * 
  * @return
  */
  function set($key,$value){
    onez()->write($this->file($key),"<?php\n!defined('IN_ONEZ') && exit('Access Denied');\n?>".serialize($value));
    if(!file_exists($this->file($key))){
      exit('没有读写权限: '.ONEZ_ROOT.'/cache/appcaches');
    }
    return $this;
  }
  /**
  * 读取缓存
  * @param mixed $key
  * 
  * @return
  */
  function get($key){
    $value=onez()->read($this->file($key));
    if($value){
      $value=substr($value,strpos($value,'?>')+2);
      return unserialize($value);
    }else{
      return array();
    }
  }
  /**
  * 键值对应的缓存文件地址
  * @param mixed $key
  * 
  * @return
  */
  function file($key){
    return ONEZ_ROOT.'/cache/appcaches/'.$key.'.php';
  }
  /**
  * 按键值查找指定缓存目录下的文件
  * @param mixed $s
  * 
  * @return
  */
  function find($s){
    $glob=glob(ONEZ_ROOT.'/cache/appcaches/'.$s);
    !$glob && $glob=array();
    return $glob;
  }
  function remove($key){
    if(file_exists($this->file($key))){
      @unlink($this->file($key));
    }
  }
  /**
  * 读取网站全局变量
  * @param mixed $key
  * 
  * @return
  */
  function option($key,$must=1){
    global $G;
    if(!$G['options']){
      $G['options']=$this->get('options');
    }
    $value=$G['options'][$key];
    if($must && !$value){
      exit('请正确设置网站参数['.$key.']');
    }
    return $value;
  }
  /**
  * 追加网站全局变量
  * @param mixed $key
  * 
  * @return
  */
  function option_set($arr){
    global $G;
    if(!$arr || !is_array($arr)){
      return $this;
    }
    $G['options']=$this->get('options');
    if($G['options'] && !is_array($G['options'])){
      exit('options有误');
    }
    foreach($arr as $k=>$v){
      $G['options'][$k]=$v;
    }
    $this->set('options',$G['options']);
    return $this;
  }
}