<?php

/* ========================================================================
 * $Id: bootstrap.php 1053 2016-09-06 01:01:12Z onez $
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
class onezphp_bootstrap extends onezphp{
  function __construct(){
    
  }
  function head($return=0){
    global $G;
    $html.='<link rel="stylesheet" href="'.$this->url.'/css/bootstrap.min.css">';
    $html.='<!--[if lte IE 6]>
  <link rel="stylesheet" type="text/css" href="'.$this->url.'/css/bootstrap-ie6.min.css">
  <link rel="stylesheet" type="text/css" href="'.$this->url.'/css/ie.css">
  <![endif]-->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->';
    $html.='<script src="'.$this->url.'/js/bootstrap.js"></script>';
    $G['footer'].='<!--[if lte IE 6]>
  <script type="text/javascript" src="'.$this->url.'/js/bootstrap-ie.js"></script>
  <![endif]-->';
    if($return){
      return $html;
    }else{
      echo $html;
    }
  }
  function rightmenu(){
    echo'<script src="'.$this->url.'/js/bootstrap-contextmenu.js"></script>';
  }
}