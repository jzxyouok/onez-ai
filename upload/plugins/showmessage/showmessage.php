<?php

/* ========================================================================
 * $Id: showmessage.php 1008 2016-09-05 16:12:36Z onez $
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
class onezphp_showmessage extends onezphp{
  function __construct(){
    
  }
  function error($text,$goto=''){
    $this->show('error',array('message'=>$text,'goto'=>$goto));
  }
  function success($text,$goto=''){
    $this->show('success',array('message'=>$text,'goto'=>$goto));
  }
  function show($status,$array){
    global $G;
    ob_clean();
    if(isset($this->is_ajax)){
      $is_ajax=(int)$this->is_ajax;
    }else{
      $is_ajax=(int)onez()->gp('is_ajax');
    }
    if($is_ajax){
      onez()->output($array);
    }else{
      if(isset($this->no_frame)){
        $no_frame=(int)$this->no_frame;
      }else{
        $no_frame=(int)onez()->gp('no_frame');
      }
      $G['title']='系统提示';
      onez('admin')->header();
      if($status=='success'){
        include(dirname(__FILE__).'/php/success.php');
      }else{
        include(dirname(__FILE__).'/php/error.php');
      }
      onez('admin')->footer();
    }
    exit();
  }
}