<?php

/* ========================================================================
 * $Id: ai.attr.number.php 922 2016-09-09 09:36:46Z onez $
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
class onezphp_ai_attr_number extends onezphp{
  function __construct(){
    
  }
  function options_ai(){
    $options=array();
    $options['plus']=array('label'=>'增加','type'=>'text','key'=>'plus','hint'=>'请填写数字','notempty'=>'');
    $options['minus']=array('label'=>'减少','type'=>'text','key'=>'minus','hint'=>'请填写数字','notempty'=>'');
    $options['set']=array('label'=>'设置为','type'=>'text','key'=>'set','hint'=>'请填写数字','notempty'=>'');
    return $options;
  }
  function doit(&$result,$v,$person){
    
    $key=$v['attr']['subject'];
    $value=(float)$person->info($key);
    
    if(isset($v['plus'])){
      $value+=(float)$v['plus'];
    }
    if(isset($v['minus'])){
      $value-=(float)$v['minus'];
    }
    if(isset($v['set'])){
      $value=(float)$v['set'];
    }
    
    $person->attrs_set($key,$value);
  }
}