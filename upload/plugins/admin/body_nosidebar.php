<?php

/* ========================================================================
 * $Id: body_nosidebar.php 993 2016-09-05 10:26:28Z onez $
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
global $G;
?>
<body class="hold-transition <?=$this->style?><?if($this->boxed)echo' layout-boxed'?> layout-top-nav sidebar-mini <?=$miniwin?'miniwin':''?>">
<div class="wrapper">

  <header class="main-header">
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <div class="navbar-header">
        <a href="" class="navbar-brand"><?=$this->title?></a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars"></i>
        </button>
      </div>
      <?if($this->menu_top_left){?>
      <div class="collapse navbar-collapse pull-left">
        <?=$this->menu_top_left?>
      </div>
      <?}?>
      <div class="navbar-custom-menu">
        <?=$this->menu_top_right?>
      </div>
    </nav>
  </header>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  