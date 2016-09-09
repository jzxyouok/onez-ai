<?php

/* ========================================================================
 * $Id: header.php 3556 2016-09-05 12:46:30Z onez $
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
$options=onez('cache')->get('options');
if($G['userid']){
  if(onez()->exists('account')){
    $avatar=onez('account')->user()->avatar();
    $nickname=onez('account')->user()->info('nickname');
    $gradename=onez('account')->user()->info('gradename');
  }else{
    $avatar=$G['avatar'];
    $nickname=$G['nickname'];
    $gradename=$G['gradename'];
  }
  $href_main=onez()->href('');
  $href_logout=onez()->href('/logout.php');
  $this->menu_top_right.=<<<ONEZ
<ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="$avatar" class="user-image" alt="$nickname">
              <span class="hidden-xs">$nickname</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="$avatar" class="img-circle" alt="$nickname">

                <p>
                  $gradename
                  <small>$nickname</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="$href_main" class="btn btn-default btn-flat">管理首页</a>
                </div>
                <div class="pull-right">
                  <a href="$href_logout" class="btn btn-default btn-flat">安全退出</a>
                </div>
              </li>
            </ul>
          </li>
</ul>
ONEZ;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
  <title><?=$G['title']?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=$this->url?>/assets/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=$this->url?>/assets/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=$this->url?>/assets/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=$this->url?>/assets/css/skins/<?=$this->style?>.min.css">
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
  <?onez('jquery')->head()?>
  <?onez('jqueryui')->head()?>
  <?onez('bootstrap')->head()?>
  <?onez('less')->head()?>
  
  <script src="<?=$this->url?>/assets/js/app.min.js"></script>
  <script src="<?=$this->url?>/assets/js/bootbox.js"></script>
  <script src="<?=$this->url?>/assets/js/onez.js"></script>
  
  <link rel="stylesheet" href="<?=$this->url?>/assets/images/style.css">

<style>
.table th{
  white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.miniwin{
  background: #ecf0f5;
}
.miniwin .main-header,.miniwin .content-header,.miniwin .main-sidebar{
  display: none;
}
.miniwin .wrapper{
  background-color: #fff;
  box-shadow: none;
}
.miniwin .content-wrapper{
  margin-left: 0;
}
</style>
<script type="text/javascript">
window.onerror=function(){
  return false;
};
<?if($G['webdomain']){
  echo 'document.domain="'.$G['webdomain'].'";';
}?>
</script>
</head>
<?
$miniwin=onez()->gp('miniwin');
if($this->menu){
  include_once(dirname(__FILE__).'/body_sidebar.php');
}else{
  include_once(dirname(__FILE__).'/body_nosidebar.php');
}
?>