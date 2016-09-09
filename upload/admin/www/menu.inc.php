<?php

/* ========================================================================
 * $Id: menu.inc.php 1347 2016-09-09 05:18:48Z onez $
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
$Menu=array (
  array (
    'name' => '高级选项',
    'href' => '',
    'icon' => 'fa fa-fw fa-newspaper-o',
  ),
  array (
    'name' => '管理首页',
    'href' => 'index.php',
    'icon' => 'fa fa-fw fa-calendar-check-o',
  ),
  array (
    'name' => '基本设置',
    'href' => '/options.php',
    'icon' => 'fa fa-fw fa-gear',
  ),
  array (
    'name' => '修改管理密码',
    'href' => '/account/setpwd.php',
    'icon' => 'fa fa-fw fa-key',
  ),
  array (
    'name' => '智能配置',
    'href' => '',
    'icon' => 'fa fa-fw fa-newspaper-o',
  ),
  array (
    'name' => '智能标签',
    'href' => '/tags/index.php',
    'icon' => 'fa fa-fw fa-diamond',
  ),
  array (
    'name' => '智能属性',
    'href' => '/attrs/index.php',
    'icon' => 'fa fa-fw fa-check-square-o',
  ),
  array (
    'name' => '应答规则',
    'href' => '/rules_group/index.php',
    'icon' => 'fa fa-fw fa-comments-o',
  ),
  array (
    'name' => '终端管理',
    'href' => '/devices/index.php',
    'icon' => 'fa fa-fw fa-graduation-cap',
  ),
  array (
    'name' => '人工辅助',
    'href' => '',
    'icon' => 'fa fa-fw fa-newspaper-o',
  ),
  array (
    'name' => '负责人管理',
    'href' => '/workers/index.php',
    'icon' => 'fa fa-fw fa-gg',
  ),
);

return $Menu;