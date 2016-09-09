<?php

/* ========================================================================
 * $Id: dialog.php 917 2016-09-07 14:14:46Z onez $
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
class onezphp_dialog extends onezphp{
  var $heads=array();
  function __construct(){
    
  }
  function init(){
    return $this;
  }
  function header(){
    global $G;
    #初始化界面引擎
    onez('ui')->init();
    
    $G['footer'].=onez('ui')->js($this->url.'/js/dialog.js');
    onez('ui')->heads[]=onez('ui')->less($this->path.'/less/dialog.less');
    #显示头部
    onez('ui')->heads=array_merge(onez('ui')->heads,$this->heads);
    onez('ui')->header();
    return $this;
  }
  function header_add($head){
    $this->heads[]=$head;
    return $this;
  }
  function footer(){
    onez('ui')->footer();
    return $this;
  }
  function click($url,$width=1000,$height=640){
    global $G;
    if($this->times(1)){
      $G['footer'].=onez('ui')->js($this->url.'/js/click.js');
    }
    return "onez.dialog_open('$url','$width','$height')";
  }
}