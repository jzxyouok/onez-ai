<?php

/* ========================================================================
 * $Id: text.php 1253 2016-09-05 10:26:28Z onez $
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
if($TYPE=='code'){
  
  $box=onez('html')->create('div')->attr('class','form-group');
  
  $label=onez('html')->create('label')->attr('for','input-'.$arr['key'])->html($arr['label']);
  $input=onez('html')->create('input')->attr('class','form-control')
                                      ->attr('id','input-'.$arr['key'])
                                      ->attr('name',$arr['key'])
                                      ->attr('type',$arr['type'])
                                      ->attr('placeholder',$arr['hint'])
                                      ->attr('value',$arr['value'])
                                    ;
  $box->add($label);
  
  if($arr['before'] || $arr['after']){
    $group=onez('html')->create('div')->attr('class','input-group');
    if($arr['before']){
      $span=onez('html')->create('span')->attr('class','input-group-btn')->html($arr['before']);
      $group->add($span);
    }
    $group->add($input);
    if($arr['after']){
      $span=onez('html')->create('span')->attr('class','input-group-btn')->html($arr['after']);
      $group->add($span);
    }               ;
    $box->add($group);
  }else{
    $box->add($input);
  }
  $this->html.=$box->code();
}