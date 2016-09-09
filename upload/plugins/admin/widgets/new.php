<?php

/* ========================================================================
 * $Id: new.php 578 2016-09-05 10:26:28Z onez $
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
class onezphp_admin_widgets_new extends onezphp_admin_widgets{
  var $attrs=array();
  function __construct(){
    
  }
  function attr($key,$value){
    $this->attrs[$key]=$value;
    return $this;
  }
  function code(){
    $name=$this->get('tag');
    if(!$name){
      $name='div';
    }
    $A='<'.$name;
    foreach($this->attrs as $k=>$v){
      $A.=' '.$k.'="'.$v.'"';
    }
    $A.='>';
    $B='</'.$name.'>';
    if($this->code){
      return $A.$this->code.$B;
    }else{
      return $A.$this->html.$B;
    }
  }
}