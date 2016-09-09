<?php

/* ========================================================================
 * $Id: body_sidebar.php 2921 2016-09-05 10:26:28Z onez $
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
<body class="hold-transition <?=$this->style?><?if($this->boxed)echo' layout-boxed'?> sidebar-mini <?=$miniwin?'miniwin':''?>">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?=$this->title_mini?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?=$this->title?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
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
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
<?=$this->sidebar_top?>
<?if(onez()->exists('account') && $options['dbinfo']){?>
<div class="user-panel">
  <div class="pull-left image">
    <img src="<?=onez('account')->user()->avatar()?>" class="img-circle" alt="User Image">
  </div>
  <div class="pull-left info">
    <p><?=onez('account')->user()->info('nickname')?></p>
    <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
  </div>
</div>
<?}else{?>
<?}?>
<?
if(file_exists(getcwd().'/www/search.php')){
  $search_url=onez()->href('search');
  list(,$search_url)=explode('?',$search_url);
  parse_str($search_url,$info);
  ?>
<form method="get" class="sidebar-form">
<?foreach($info as $k=>$v){?>
<input type="hidden" name="<?=$k?>" value="<?=$v?>" />
<?}?>
  <div class="input-group">
    <input type="text" name="q" class="form-control" placeholder="查找后台功能">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
  </div>
</form>
<script type="text/javascript">
$(function(){
  $('.sidebar-form').unbind('submit').bind('submit',function(){
    var q=$(this).find('input[name="q"]').val();
    if(q.length<1){
      return false;
    }
  });
});
</script>
<?}?>
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
<?
$this->showmenu($this->menu);
?>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
