<?php

/* ========================================================================
 * $Id: rules.inc.php 427 2016-09-06 16:18:58Z onez $
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
$options_type=array(
  'all'=>'当目标同时拥有所有蓝色标签时',
  'one'=>'当目标有任意一个蓝色标签时',
  'allnot'=>'当目标没有任何一个以下蓝色标签时',
);
$options_typename=array(
  'all'=>'当目标同时有标签(*)时',
  'one'=>'当目标有标签(*)中任意一个时',
  'allnot'=>'当目标没有标签(*)中任何一个时',
);