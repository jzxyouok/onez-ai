<?php

/* ========================================================================
 * $Id: ai.input.text.php 2475 2016-09-07 18:42:36Z onez $
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
class onezphp_ai_input_text extends onezphp{
  function __construct(){
    
  }
  function form($item=array()){
    $arr=$item['rule'];
    $html[]=<<<ONEZ
<div class="form-group">
  <label>当用户发送的文本<code>完全等于</code>以下内容时</label>
  <textarea class="form-control" rows="5" id="extra_text_same">$arr[same]</textarea>
</div>
<div class="form-group">
  <label>当用户发送的文本包含以下<code>任意一行</code>时</label>
  <textarea class="form-control" rows="5" id="extra_text_one">$arr[one]</textarea>
</div>
<div class="form-group">
  <label>当用户发送的文本包含以下<code>所有行</code>时</label>
  <textarea class="form-control" rows="5" id="extra_text_all">$arr[all]</textarea>
</div>
<div class="form-group">
  <label class="text-blue">内容模板。此项为深度匹配，请慎重填写</label>
  <textarea class="form-control" rows="5" id="extra_text_tpl">$arr[tpl]</textarea>
</div>

ONEZ;
    $html[]=onez('ui')->js($this->url.'/js/input.js');
    return implode("\n",$html);
  }
  function match($data,$rule){
    if($data['type']!='text'){
      return false;
    }
    $message=trim($data['message']);
    if(!$message){
      return false;
    }
    #当用户发送的文本完全等于时
    if($rule['same']){
      $text=trim($rule['same']);
      if($message==$text){
        return true;
      }
    }
    #当用户发送的文本包含任意一行时
    if($rule['one']){
      $text=trim($rule['one']);
      foreach(explode("\n",$text) as $v){
        $v=trim($v);
        if($message==$v){
          return true;
        }
      }
    }
    #当用户发送的文本包含所有行时
    if($rule['all']){
      $text=trim($rule['all']);
      foreach(explode("\n",$text) as $v){
        $v=trim($v);
        if($v && $message!=$v){
          return false;
        }
      }
      return true;
    }
    #内容模板
    if($rule['tpl']){
      $text=trim($rule['tpl']);
      $vars=array();
      $s='/【([^】]+)】/is';
      if(@preg_match_all($s,$text,$mat)){
        $reg=@preg_replace($s,'(.+?)',$text);
        @preg_match_all($s,$message,$mat2);
        if(count($mat)==count($mat2)){
          foreach($mat as $k=>$m){
            $vars[$mat[$k][0]]=$mat2[$k][0];
            onez('ai')->person($mat[$k][0],$mat2[$k][0]);
          }
    print_r($vars);
          return true;
        }
      }
    }
    return false;
  }
}