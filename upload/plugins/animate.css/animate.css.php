<?php

/* ========================================================================
 * $Id: animate.css.php 538 2016-09-08 09:58:06Z onez $
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
class onezphp_animate_css extends onezphp{
  function __construct(){
    
  }
  function init(){
    $this->head();
    return $this;
  }
  function head($return=0){
    $html=array();
    $html[]=onez('ui')->css($this->url.'/css/animate.min.css');
    $html[]=onez('ui')->js($this->url.'/js/jquery.animate.js');
    if($return){
      return implode("\n",$html);
    }else{
      echo implode("\n",$html);
    }
  }
  function css(){
    return $this->url.'/css/animate.min.css';
  }
}