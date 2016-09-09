<?php

/* ========================================================================
 * $Id: ai.attr.picurl.php 533 2016-09-09 05:28:00Z onez $
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
class onezphp_ai_attr_picurl extends onezphp{
  function __construct(){
    
  }
  function options_ai(){
    $options=array();
    $options['set']=array('label'=>'设置为','type'=>'upload','key'=>'set','hint'=>'','notempty'=>'');
    return $options;
  }
  function doit(&$result,$v,$person){
    
    $key=$v['attr']['subject'];
    $value=$person->info($key);
    
    
    if(isset($v['set'])){
      $value=onez()->gp('set');
    }
    $person->attrs_set($key,$value);
  }
}