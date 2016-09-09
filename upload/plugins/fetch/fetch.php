<?php

/* ========================================================================
 * $Id: fetch.php 2947 2016-09-05 10:23:16Z onez $
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
define('ONEZ_APPID','10000003');
define('ONEZ_APPKEY','fe0244157c478476459a3debb8401d83');
class onezphp_fetch extends onezphp{
  function __construct(){
    
  }
  function get($token){
    global $G;
    $classFile=ONEZ_ROOT.ONEZ_NODE_PATH.'/'.$token.'/'.$token.'.php';
    if(!file_exists($classFile)){
      $post=array(
        'token'=>$token,
      );
      set_time_limit(0);
      $onez_appid=onez('cache')->option('onez_appid',0);
      $onez_appkey=onez('cache')->option('onez_appkey',0);
      if(!$onez_appid || !$onez_appkey){
        $onez_appid=$G['onez_appid'];
        $onez_appkey=$G['onez_appkey'];
      }
      if(!$onez_appid || !$onez_appkey){
        if(defined('ONEZ_APPID') && defined('ONEZ_APPKEY')){
          $onez_appid=ONEZ_APPID;
          $onez_appkey=ONEZ_APPKEY;
        }
      }
      if(!$onez_appid || !$onez_appkey){
        $onez_appid=onez('cache')->option('onez_appid');
        $onez_appkey=onez('cache')->option('onez_appkey');
      }
      
      $mydata=onez()->post('http://xl.onez.cn/api/fetch.php',http_build_query($post),array(
        'timeout'=>600,
        'headers'=>array(
          'Authorization: '.$onez_appid.' '.md5($onez_appkey),
        )
      ));
      if(strpos($mydata,'onez')===0){
        $mydata=substr($mydata,4);
        $mydata=gzuncompress($mydata);
        $pos=0;
        $nFileCount = substr($mydata, $pos, 16) ;
        $pos += 16 ;

        $size = substr($mydata, $pos, 16) ;
        $pos += 16 ;

        $info = substr($mydata, $pos, $size-1) ;
        $pos += $size ;

        $info_array = explode("\n", $info) ;

        $c_file = 0 ;
        $c_dir = 0 ;
        
        $files=array();
        $isok=0;
        foreach($info_array as $str_row){
          list($filename, $attr) = explode("|", $str_row);
          if ( substr($attr,0,6)=="[/dir]"){
            continue;
          }
          if(substr($attr,0,5)=="[dir]"){
            //$files[]=array('dir',$filename);
          }else{
            $files[$filename]=substr($mydata, $pos, $attr);
            $pos += $attr ;
          }
        }
        $mainFile=$token.'.php';
        !$files[$mainFile] && onez('showmessage')->error('[1004]插件源有误');
        foreach($files as $filename=>$data){
          $file=ONEZ_ROOT.ONEZ_NODE_PATH.'/'.$token.'/'.$filename;
          onez()->write($file,$data);
        }
      }else{
        $json=json_decode($mydata,1);
        
        if(onez()->exists('showmessage',0)){
          if($json['errno']){
            onez('showmessage')->error('['.$json['errno'].']'.$json['error']);
          }else{
            onez('showmessage')->error('[1005]读取插件代码有误');
          }
        }else{
          if($json['errno']){
            exit("[{$json['errno']}]:{$json['error']}");
          }else{
            exit("[1005]:读取插件代码有误");
          }
        }
      }
    }
  }
}