<?php

/* ========================================================================
 * $Id: box.php 1034 2016-09-05 10:26:28Z onez $
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
class onezphp_admin_widgets_box extends onezphp_admin_widgets{
  function __construct(){
    
  }
  function addbtn($name,$url,$style='success'){
    $this->btns.='<a href="'.$url.'" class="btn btn-success">'.$name.'</a> ';
    return $this;
  }
  function code(){
    //$this->html.='<section class="content">';
    
    $footer='';
    if($this->get('footer')){
      $footer='<div class="box-footer clearfix">'.$this->get('footer').'</div>';
    }
    $this->html.='
  <div class="btns" style="padding-bottom: 10px">'.$this->btns.'</div>
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">'.$this->get('title').'</h3>
      <div class="box-tools pull-right"></div>
    </div>
    <!-- /.box-header -->
    <div class="box-body '.$this->get('attr-body').'">
    '.$this->get('html').'
    </div>
    <!-- /.box-body -->
    '.$footer.'
    <!-- /.box-footer --></div>
';
    //$this->html.='</section>';
    return $this->html;
  }
}