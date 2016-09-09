<?php

/* ========================================================================
 * $Id: filesave.php 1361 2016-09-06 00:00:39Z onez $
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
class onezphp_filesave extends onezphp{
  function __construct(){
  }
  function upload($file,$data){
    
    $item=onez('cache')->get('options');
    if(!$item['upyun_bucket']){
      #本地存储
      $file='/cache/uploads/'.date('Y/m/d').'/'.uniqid().'.jpg';
      onez()->write(ONEZ_ROOT.$file,$data);
      return onez()->homepage().$file;
    }
    if(!$this->info){
      $this->info=array(
        'bucket'=>$item['upyun_bucket'],
        'username'=>$item['upyun_username'],
        'password'=>$item['upyun_password'],
        'domain'=>$item['upyun_domain'],
      );
    }
    $file='/xl'.$file;
    $process=curl_init('http://v0.api.upyun.com/'.$this->info['bucket'].$file);
    curl_setopt($process,CURLOPT_POST,1);
    curl_setopt($process,CURLOPT_POSTFIELDS,$data);
    curl_setopt($process,CURLOPT_USERPWD,$this->info['username'].':'.$this->info['password']);
    curl_setopt($process,CURLOPT_HTTPHEADER,array('Expect:','Mkdir: true'));
    curl_setopt($process,CURLOPT_HEADER,0);
    curl_setopt($process,CURLOPT_TIMEOUT,60);
    curl_setopt($process,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($process,CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($process,CURLOPT_HEADER,0);
    $result=curl_exec($process);
    curl_close($process);
    return 'http://'.$this->info['domain'].$file;
  }
}