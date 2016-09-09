<?php

/* ========================================================================
 * $Id: textarea.php 1374 2016-09-05 10:26:28Z onez $
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
          <textarea type="'.$arr['type'].'" class="form-control" rows="5" id="input-'.$arr['key'].'"'.($arr['height']?' style="height:'.$arr['height'].'px"':'').' name="'.$arr['key'].'" placeholder="'.$arr['hint'].'">'.$value.'</textarea>
          <span class="input-group-btn">'.$arr['after'].'</span>
    </div>
          '.($this->get('dir')=='horizontal'?'</div>':'').'
        </div>';
  }else{
    $this->html.='<div class="form-group">
          <label for="input-'.$arr['key'].'"'.($this->get('dir')=='horizontal'?' class="col-sm-2 control-label"':'').'>'.$arr['label'].'</label>
          '.($this->get('dir')=='horizontal'?'<div class="col-sm-10">':'').'
          <textarea type="'.$arr['type'].'" class="form-control" rows="5" id="input-'.$arr['key'].'"'.($arr['height']?' style="height:'.$arr['height'].'px"':'').' name="'.$arr['key'].'" placeholder="'.$arr['hint'].'">'.$value.'</textarea>
          '.($this->get('dir')=='horizontal'?'</div>':'').'
        </div>';
  }
}