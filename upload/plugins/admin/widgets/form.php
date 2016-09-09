<?php

/* ========================================================================
 * $Id: form.php 2926 2016-09-06 00:41:40Z onez $
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
class onezphp_admin_widgets_form extends onezphp_admin_widgets{
  var $items=array();
  function __construct(){
    
  }
  function submit(){
    $action=onez()->gp('action');
    if($action=='save'){
      $onez=array();
      foreach($this->items as $key=>$arr){
        if($arr['type']=='hidden'){
          continue;
        }
        if(strpos($arr['key'],'tmp-')!==false){
          continue;
        }
        $onez[$arr['key']]=onez()->gp($arr['key']);
        $file=$this->form_file($arr);
        if(!file_exists($file) && onez()->exists($arr['token'])){
          onez($arr['token'])->form_save($onez[$arr['key']],$arr);
        }
      }
      return $onez;
    }
    return false;
  }
  function form_file($arr){
    $file=dirname(__FILE__).'/form/'.$arr['type'].'.php';
    if(in_array($arr['type'],array('number','date','password'))){
      $file=dirname(__FILE__).'/form/text.php';
    }
    return $file;
  }
  function add($item){
    $item['token']=$item['type'];
    $item['type']=preg_replace('/[^0-9a-zA-Z_]+/i','',$item['type']);
    !$item['type'] && $arr['type']='text';
    if(!$item['key']){
      $item['key']='tmp-'.uniqid();
    }
    $this->items[$item['key']]=$item;
    return $this;
  }
  function code(){
    global $G;
    $TYPE='code';
    $values=$this->get('values');
    foreach($this->items as $key=>$arr){
      $value=$values[$arr['key']];
      if($arr['value']){
        $value=$arr['value'];
      }
      if($arr['label'] && $arr['notempty']){
        $arr['label'].='<span class="text-red">*</span>';
      }
      $arr['value']=$value;
      if($arr['type']=='hidden'){
        $this->html.='<input type="hidden" name="'.$arr['key'].'" value="'.$arr['value'].'" />';
        continue;
      }
      $file=$this->form_file($arr);
      if(!file_exists($file)){
        if(onez()->exists($arr['token'])){
          $r=onez($arr['token'])->form_code($arr);
          if($r){
            $this->html.=$r;
            continue;
          }
        }
        $file=dirname(__FILE__).'/form/text.php';
      }
      include($file);
    }
    return $this->html;
  }
  function js(){
    $myjs='';
    foreach($this->items as $key=>$arr){
      if($arr['notempty']){
        $myjs.="if($('#input-$arr[key]').val().length<1){onez.alert(".var_export($arr['notempty'],1).");return false;}\n";
      }
    }
    $js.=<<<ONEZ
<script type="text/javascript">
$(function(){
  $('#form-common').bind('submit',function(){
    $myjs
    onez.formpost(this);
    return false;
  });
});
</script>
ONEZ;
    return $js;
  }
  function options($key=false){
    $options=array();
    $options['text']='单行文本';
    $options['textarea']='多行文本';
    $options['uicolor']='颜色选择';
    $options['select']='下拉选择';
    $options['checkbox']='开关';
    if($key){
      return $options[$key];
    }
    return $options;
  }
}