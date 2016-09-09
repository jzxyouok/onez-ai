<?php

/* ========================================================================
 * $Id: plugin.php 339 2016-09-02 10:52:36Z onez $
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

$token=onez()->gp('_token');
$href=onez()->gp('_href');
define('CUR_URL',onez('super')->plugin_href($token,$href));

if($token){
  $file=onez($token)->path.'/super'.$href;
  if(file_exists($file)){
    include($file);
    return;
  }
}

onez('admin')->header();
onez('admin')->footer();