<?php

/* ========================================================================
 * $Id: html.php 1551 2016-09-05 10:26:28Z onez $
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
class onezphp_html extends onezphp{
  var $tagname='div';
  var $html='';
  var $attrs=array();
  var $childs=array();
  function create($tagname){
    $spr=new onezphp_html();
    $spr->tagname=$tagname;
    return $spr;
  }
  function code(){
    $code='<'.$this->tagname;
    if($this->attrs){
      foreach($this->attrs as $k=>$v){
        $code.=' '.$k.'="'.$v.'"';
      }
    }
    if($this->childs){
      foreach($this->childs as $k=>$v){
        $this->html.=$v->code();
      }
    }
    if($this->html || $this->is_end){
      $code.='>';
      $code.=$this->html;
      $code.='</'.$this->tagname.'>';
    }else{
      $code.=' />';
    }
    return $code;
  }
  function html($html=false){
    if($html===false){
      return $this->html;
    }else{
      $this->html=$html;
      return $this;
    }
  }
  function add($sprite,$name=false){
    if(!$name){
      $name=$sprite->tagname;
      $n=0;
      while(isset($this->childs[$name])){
        $n++;
        $name=$sprite->tagname.$n;
      }
    }
    $this->childs[$name]=$sprite;
    return $this;
  }
  function get($name){
    return $this->childs[$name];
  }
  function remove($name){
    unset($this->childs[$name]);
  }
  function attr($key,$value=false){
    if($html===false){
      return $this->attrs[$key];
    }
    if($value){
      if($key=='tagname'){
        $this->tagname=$value;
      }else{
        $this->attrs[$key]=$value;
      }
    }else{
      unset($this->attrs[$key]);
    }
    return $this;
  }
}