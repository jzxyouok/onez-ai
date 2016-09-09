<?php

/* ========================================================================
 * $Id: admin.php 4153 2016-09-05 10:26:28Z onez $
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
class onezphp_admin_widgets{
  var $vars=array();
  var $code;
  function code(){
    return $this->html;
  }
  function show(){
    if($this->code){
      echo $this->code;
    }else{
      echo $this->code();
    }
    return $this;
  }
  function add($html){
    $this->html.=$html;
    return $this;
  }
  function get($key,$def=false){
    $value=$this->vars[$key];
    if($def!==false && !isset($this->vars[$key])){
      return $def;
    }
    return $value;
  }
  function set($key,$value){
    $this->vars[$key]=$value;
    return $this;
  }
  function setByArray($vars){
    if(is_array($vars)){
      foreach($vars as $k=>$v){
        $this->set($k,$v);
      }
    }
    return $this;
  }
  function wrap($name,$opt,$methods=false){
    if(in_array($name,array('box'))){
      $name=preg_replace('/[^0-9a-zA-Z_]+/i','',$name);
      $file=dirname(__FILE__).'/widgets/'.$name.'.php';
      if(file_exists($file)){
        $wrap=onez('admin')->widget($name)->setByArray($this->vars)->setByArray($opt);
        if($methods){
          foreach($methods as $k=>$v){
            call_user_func_array(array($wrap,$k),$v);
          }
        }
        $this->code=$wrap->set('html',$this->code())->code();
        return $this;
      }
    }
    $A='<'.$name;
    foreach($opt as $k=>$v){
      $A.=' '.$k.'="'.$v.'"';
    }
    $A.='>';
    $B='</'.$name.'>';
    
    if($this->code){
      $this->code=$A.$this->code.$B;
    }else{
      $this->code=$A.$this->code().$B;
    }
    return $this;
  }
}
class onezphp_admin extends onezphp{
  var $style='skin-blue';
  var $boxed=1;
  var $title_mini='管理';
  var $title='管理中心';
  function __construct(){
    
  }
  
  function header(){
    global $G;
    include_once(dirname(__FILE__).'/header.php');
  }
  
  function footer($type='user'){
    global $G;
    include_once(dirname(__FILE__).'/footer.php');
  }
  function widget($name){
    global $G;
    $name=preg_replace('/[^0-9a-zA-Z_]+/i','',$name);
    $file=dirname(__FILE__).'/widgets/'.$name.'.php';
    if(file_exists($file)){
      include_once($file);
      $clsName="onezphp_admin_widgets_$name";
      if(class_exists($clsName)){
        return new $clsName();
      }
    }
  }
  //哪个菜单处理激活状态
  function menu_active(&$menu){
    foreach($menu as $k=>&$v){
      if(strpos($v['href'],CUR_URL)!==false){
        $v['current']=1;
        return 1;
      }
      if(strpos($v['url'],CUR_URL)!==false){
        $v['current']=1;
        return 1;
      }
      if($v['children']){
        $r=$this->menu_active($v['children']);
        if($r){
          $v['current']=1;
          return 1;
        }
      }
    }
    return 0;
  }
  //显示菜单
  function showmenu($menu,$step=false){
    if($step===false && defined('CUR_URL')){
      $this->menu_active($menu);
    }
    foreach($menu as $v){
      if($step===false){
        if(!$v['href'] && !$v['url']){
          echo'<li class="header">'.$v['name'].'</li>';
          continue;
        }
      }
      $target=$v['target'];
      !$target && $target='_self';
      $href=onez('admin')->href($v['href']);
      if($v['url']){
        $href=$v['url'];
      }
      if($v['children']){
        echo'<li class="treeview'.($v['current']?' active':'').'">';
        echo'<a href="#"><i class="'.$v['icon'].'"></i> <span>'.$v['name'].'</span> <i class="fa fa-angle-left pull-right"></i></a>';
        echo'<ul class="treeview-menu">';
        $this->showmenu($v['children'],$step+1);
        echo'</ul>';
      }else{
        !$v['icon'] && $v['icon']='fa fa-circle-o';
        echo'<li'.($v['current']?' class="active"':'').'>';
        echo'<a href="'.$href.'" target="'.$target.'"><i class="'.$v['icon'].'"></i> <span>'.$v['name'].'</span></a>';
        echo'<li>';
      }
      echo'</li>';
    }
  }
  //自动显示后台内页面
  function start(){
    $mod=onez()->gp('mod');
    if(!onez()->start()){
      onez('admin')->header();
      echo 'MOD"'.$mod.'"不存在';
      onez('admin')->footer();
      exit();
    }
  }
  function href($href){
    return onez()->href($href);
  }
}