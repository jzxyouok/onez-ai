<?php

/* ========================================================================
 * $Id: uicolor.php 2059 2016-09-05 10:26:28Z onez $
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
  if($arr['after']){
    $this->html.='<div class="form-group">
          <label for="input-'.$arr['key'].'"'.($this->get('dir')=='horizontal'?' class="col-sm-2 control-label"':'').'>'.$arr['label'].'</label>
          '.($this->get('dir')=='horizontal'?'<div class="col-sm-10">':'').'
    <div class="input-group">
          <input type="'.$arr['type'].'" class="form-control" id="input-'.$arr['key'].'" name="'.$arr['key'].'" placeholder="'.$arr['hint'].'" value="'.$value.'">
          <span class="input-group-btn">'.$arr['after'].'</span>
    </div>
          '.($this->get('dir')=='horizontal'?'</div>':'').'
        </div>';
  }else{
    if(!$G['footer-uicolor']){
      $G['footer-uicolor']=1;
      $G['footer-js']=<<<ONEZ
$(function(){
  $('.fc-color-picker li.current').css({'border-bottom':'2px #f00 solid'});
  $('.fc-color-picker li[data-color]').click(function(){
    var color=$(this).attr('data-color');
    $('.fc-color-picker li[data-color]').css({'border':'0'});
    $(this).css({'border-bottom':'2px #f00 solid'});
    $('.fc-color-picker').parent().find('input').val(color);
  });  
});
ONEZ;
    }
    $colors=array('aqua','blue','light-blue','teal','yellow','orange','green','lime','red','purple','fuchsia','muted','navy');
    $color_chooser='';
    foreach($colors as $v){
      $color_chooser.='<li'.($v==$value?' class="current"':'').' data-color="'.$v.'"><span class="text-'.$v.'"><i class="fa fa-square"></i></span></li>';
    }
    $this->html.='<div class="form-group">
          <label for="input-'.$arr['key'].'"'.($this->get('dir')=='horizontal'?' class="col-sm-2 control-label"':'').'>'.$arr['label'].'</label>
          '.($this->get('dir')=='horizontal'?'<div class="col-sm-10">':'').'
          <input type="hidden" id="input-'.$arr['key'].'" name="'.$arr['key'].'" value="'.$value.'">
          <ul class="fc-color-picker" id="color-chooser">'.$color_chooser.'</ul>
          '.($this->get('dir')=='horizontal'?'</div>':'').'
        </div>';
  }
}