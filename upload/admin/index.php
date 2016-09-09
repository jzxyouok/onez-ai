<?php

/* ========================================================================
 * $Id: index.php 809 2016-09-08 07:28:04Z onez $
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


include(dirname(dirname(__FILE__)).'/lib/onezphp.php');
$userid=$G['userid']=(int)onez('scookie')->call('adminid');
if(!$userid){
  onez()->location('login.php');
}
$admin=onez('db')->open('admin')->one("adminid='$G[userid]'");
!$admin && onez()->location('login.php');
$G['title']=onez('admin')->title='超级管理中心';
$G['nickname']=$admin['username'];
$G['avatar']='images/test/avatar5.png';
function href($href){
  return '?mod='.$href;
}
function _header(){
  onez('admin')->header();
}
function _footer(){
  onez('admin')->footer();
}

#样式风格
onez('admin')->style='skin-red';
#是否窄屏
onez('admin')->boxed=1;

$Menu=array();
$Menu=array_merge($Menu,include(dirname(__FILE__).'/www/menu.inc.php'));

onez('admin')->menu=$Menu;

onez('admin')->start();
