<?php

/* ========================================================================
 * $Id: menu.inc.php 651 2016-09-05 10:32:12Z onez $
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
    'name' => '网站基本设置',
    'href' => '',
    'icon' => '',
  ),
  array (
    'name' => '网站参数设置',
    'url' => onez('super')->www('/options.php'),
    'icon' => '',
  ),
  array (
    'name' => '数据表安装与升级',
    'url' => onez('super')->www('/dbtables.php'),
    'icon' => '',
  ),
  array (
    'name' => '设置管理账号和密码',
    'url' => onez('super')->www('/setpwd.php'),
    'icon' => '',
  ),
  array (
    'name' => '查看演示',
    'url' => onez('super')->www('/demos.php'),
    'icon' => '',
  ),
);

return $Menu;

