<?php

/* ========================================================================
 * $Id: checkbox.php 617 2016-09-05 10:26:28Z onez $
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
  $select.='<select class="form-control" id="input-'.$arr['key'].'" name="'.$arr['key'].'">';
  if($arr['options']){
    foreach($arr['options'] as $k=>$v){
      $s=$value==$k?' selected':'';
      $select.='<option value="'.$k.'"'.$s.'>'.$v.'</option>';
    }
  }
  $select.='</select>';
  
  $this->html.='<div class="form-group">
        <label>
          <input type="checkbox" id="input-'.$arr['key'].'" name="'.$arr['key'].'" '.($value?' checked':'').' value="1">
          '.$arr['label'].'
        </label>
      </div>';
}