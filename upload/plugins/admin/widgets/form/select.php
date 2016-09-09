<?php

/* ========================================================================
 * $Id: select.php 1854 2016-09-05 10:26:28Z onez $
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
  $select='';
  $s='';
  if($arr['mul'] || $arr['multiple']){
    $s=' multiple="multiple"';
    $G['footer'].='<script src="'.onez('admin')->url.'/assets/plugins/select2/select2.full.min.js"></script>';
    $G['footer'].='<link rel="stylesheet" href="'.onez('admin')->url.'/assets/plugins/select2/select2.min.css">';
    $G['footer-js'].="$('select[multiple]').select2();";
    $select.='<select class="form-control" multiple="multiple" id="input-'.$arr['key'].'" name="'.$arr['key'].'[]">';
  }else{
    $select.='<select class="form-control" id="input-'.$arr['key'].'" name="'.$arr['key'].'">';
  }
  if($arr['options']){
    foreach($arr['options'] as $k=>$v){
      if($arr['mul'] || $arr['multiple']){
        $s=in_array($k,$value)?' selected':'';
      }else{
        $s=$value==$k?' selected':'';
      }
      $select.='<option value="'.$k.'"'.$s.'>'.$v.'</option>';
    }
  }
  $select.='</select>';
  
  if($arr['after']){
    $this->html.='<div class="form-group">
          <label for="input-'.$arr['key'].'"'.($this->get('dir')=='horizontal'?' class="col-sm-2 control-label"':'').'>'.$arr['label'].'</label>
          '.($this->get('dir')=='horizontal'?'<div class="col-sm-10">':'').'
    <div class="input-group">
          '.$select.'
          <span class="input-group-btn">'.$arr['after'].'</span>
    </div>
          '.($this->get('dir')=='horizontal'?'</div>':'').'
        </div>';
  }else{
    $this->html.='<div class="form-group">
          <label for="input-'.$arr['key'].'"'.($this->get('dir')=='horizontal'?' class="col-sm-2 control-label"':'').'>'.$arr['label'].'</label>
          '.($this->get('dir')=='horizontal'?'<div class="col-sm-10">':'').'
          '.$select.'
          '.($this->get('dir')=='horizontal'?'</div>':'').'
        </div>';
  }
}