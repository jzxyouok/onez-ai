<?php

/* ========================================================================
 * $Id: form.plugin.child.php 2313 2016-09-06 16:44:38Z onez $
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
class onezphp_form_plugin_child extends onezphp{
  function __construct(){
    
  }
  function form_code($arr){
    global $G;
    list($value,$name)=explode('|',$arr['value']);
    $arr['value']=$name;
    
    $formkz=onez('bootstrap_form_kz')->init($arr);
    
    $formkz->input->attr('type','text')
                                        ->attr('data-ajax',$this->view('search&ptoken='.$arr['ptoken'].'&input='.urlencode($arr['key'])))
                                        ->attr('value',$name)
                                      ;
                                      
    $input_hide=onez('html')->create('input')
                                        ->attr('id','input-hide-'.$arr['key'])
                                        ->attr('name','hide-'.$arr['key'])
                                        ->attr('type','hidden')
                                        ->attr('value',$value)
                                      ;
    
    $formkz->box->add($input_hide);
    $html.=$formkz->code();
    
    if($this->times(1)){
      $G['footer-js'].=<<<ONEZ
onez.ai_script_select=function(input,name,token){
  $('#input-hide-'+input).val(token);
  $('#input-'+input).val(name);
}
ONEZ;
    }
    return $html;
  }
  function form_save(&$value,$arr){
    $key=$arr['key'];
    $value=implode('|',array(onez()->gp('hide-'.$key),$value));
    return $value;
  }
  function name($value){
    list($value,$name)=explode('|',$value);
    if(!$name){
      return '<span class="text-gray">(未设置)</span>';
    }
    return $name;
  }
  function search(){
    $input=(string)onez()->gp('input');
    $ptoken=onez()->gp('ptoken');
    $kw=onez()->gp('kw');
    $page=(int)onez()->gp('page');
    $plugins=onez('api')->request('plugins',array('tagname'=>$ptoken,'kw'=>$kw,'page'=>$page,));
    
    $record=array();
    if($plugins['plugins']){
      foreach($plugins['plugins'] as $rs){
        $item=array(
          'type'=>'item',
          'text'=>$rs['pname'],
          'token'=>$rs['ptoken'],
          'href'=>'javascript:onez.ai_script_select('.var_export($input,1).','.var_export($rs['pname'],1).','.var_export($rs['ptoken'],1).')',
        );
        $record[]=$item;
      }
    }
    onez()->output(array('record'=>$record));
  }
}