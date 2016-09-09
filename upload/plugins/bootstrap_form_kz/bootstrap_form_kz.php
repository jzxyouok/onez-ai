<?php

/* ========================================================================
 * $Id: bootstrap_form_kz.php 1537 2016-09-05 23:59:27Z onez $
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
class onezphp_bootstrap_form_kz extends onezphp{
  var $box;
  var $arr=array();
  var $input=false;
  function __construct(){
    
  }
  function init($arr){
    $this->arr=$arr;
    $this->box=onez('html')->create('div')->attr('class','form-group');
    
    $label=onez('html')->create('label')->attr('for','input-'.$arr['key'])->html($arr['label']);
    
    $this->input=onez('html')->create('input')->attr('class','form-control')
                                        ->attr('id','input-'.$arr['key'])
                                        ->attr('name',$arr['key'])
                                        ->attr('placeholder',$arr['hint'])
                                        ->attr('value',$value)
                                      ;
    
    $this->box->add($label);
    return $this;
  }
  function code(){
    $arr=$this->arr;
    if($arr['before'] || $arr['after']){
      $group=onez('html')->create('div')->attr('class','input-group');
      if($arr['before']){
        $span=onez('html')->create('span')->attr('class','input-group-btn')->html($arr['before']);
        $group->add($span);
      }
      $this->input && $group->add($this->input);
      if($arr['after']){
        $span=onez('html')->create('span')->attr('class','input-group-btn')->html($arr['after']);
        $group->add($span);
      }               ;
      $this->box->add($group);
    }else{
      $this->input && $this->box->add($this->input);
    }
    return $this->box->code();
  }
}