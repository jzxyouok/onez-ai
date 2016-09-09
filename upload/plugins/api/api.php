<?php

/* ========================================================================
 * $Id: api.php 786 2016-09-06 00:23:42Z onez $
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
class onezphp_api extends onezphp{
  function __construct(){
    
  }
  function request($method,$option=array()){
    global $G;
    set_time_limit(0);
    $post=array(
      'method'=>$method,
      'option'=>serialize($option),
    );
    $onez_appid=onez('cache')->option('onez_appid',0);
    $onez_appkey=onez('cache')->option('onez_appkey',0);
    if(!$onez_appid || !$onez_appkey){
      $onez_appid=$G['onez_appid'];
      $onez_appkey=$G['onez_appkey'];
    }
    $mydata=onez()->post('http://xl.onez.cn/api/request.php',http_build_query($post),array(
      'timeout'=>600,
      'headers'=>array(
        'Authorization: '.$G['onez_appid'].' '.md5($G['onez_appkey']),
      )
    ));
    return json_decode($mydata,1);
  }
}