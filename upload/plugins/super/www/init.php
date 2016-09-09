<?php

/* ========================================================================
 * $Id: init.php 1774 2016-09-05 17:37:00Z onez $
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
#所有已安装的扩展
function _get_all_plugins(){
  $plugins=array();
  $glob=glob(ONEZ_ROOT.ONEZ_NODE_PATH.'/*');
  if($glob){
    foreach($glob as $v){
      $name=basename($v);
      if(file_exists("$v/$name.php")){
        if(!in_array($name,$plugins)){
          $plugins[]=$name;
        }
      }
    }
  }
  $glob=glob(ONEZ_ROOT.ONEZ_MYNODE_PATH.'/*');
  if($glob){
    foreach($glob as $v){
      $name=basename($v);
      if(file_exists("$v/$name.php")){
        if(!in_array($name,$plugins)){
          $plugins[]=$name;
        }
      }
    }
  }
  return $plugins;
}
#网站是否已安装
$options=onez('cache')->get('options');
if(!$options['is_install']){
  onez()->location(onez('install')->www('/index.php'));
}
#是否已登录
if(onez()->gp('mod')!='/login.php'){
  $superinfo=onez('cache')->cookie('superinfo');
  if(!$superinfo['username']){
    onez()->location(onez('super')->www('/login.php'));
  }
}
#网站样式
onez('admin')->style='skin-yellow';

$Menu=array();
$Menu=array_merge($Menu,include(dirname(__FILE__).'/menu.inc.php'));

$plugins=_get_all_plugins();

#扩展中是否有数据库
foreach($plugins as $ptoken){
  if(method_exists(onez($ptoken),'dbtables')){
    
    $Menu[]=array (
      'name' => '数据库分析',
      'url' => onez('super')->www('/dbtables.php'),
      'icon' => '',
    );
    break;
  }
}

#扩展中哪些包含管理菜单
foreach($plugins as $ptoken){
  if(method_exists(onez($ptoken),'menus')){
    $menus=onez($ptoken)->menus();
    if($menus && is_array($menus)){
      $Menu[]=array (
        'name' => $ptoken,
        'href' => '',
        'icon' => '',
      );
      $Menu=array_merge($Menu,$menus);
    }
  }
}


onez('admin')->menu=$Menu;