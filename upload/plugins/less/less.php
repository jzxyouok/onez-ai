<?php

/* ========================================================================
 * $Id: less.php 498 2016-09-04 16:51:16Z onez $
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
class onezphp_less extends onezphp{
  function __construct(){
    
  }
  function head($return=0){
    $html.='<script src="'.$this->url.'/js/less.min.js"></script>';
    if($return){
      return $html;
    }else{
      echo $html;
    }
  }
  function tocss($lessFile){
    if(!$this->less){
      include_once(dirname(__FILE__).'/lib/lessc.inc.php');
      $this->less = new lessc();
    }
    return $this->less->compileFile($lessFile);
  }
}