<?php

/* ========================================================================
 * $Id: ai.device.dialog.php 2657 2016-09-09 09:18:26Z onez $
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
class onezphp_ai_device_dialog extends onezphp{
  function __construct(){
    
  }
  function options_ai(){
    global $G;
    $options=array();
    
    $url=$this->view('dialog&deviceid='.$G['item']['deviceid']);
    $html=<<<ONEZ
<a href="$url" target="_blank">$url</a>
ONEZ;
    $options['info']=array('label'=>'对话框地址','type'=>'html','html'=>$html);
    return $options;
  }
  function dialog(){
    global $G;
    include(dirname(__FILE__).'/php/dialog.php');
  }
  function input_types(){
    $types=array();
    $types[]=array('type'=>'ai.input.text','name'=>'文本');
    //$types[]=array('type'=>'ai.input.image','name'=>'图片');
    return $types;
  }
  function output_types(){
    $types=array();
    $types[]=array('type'=>'ai.output.text','name'=>'文本');
    $types[]=array('type'=>'ai.output.image','name'=>'图片');
    return $types;
  }
  function js(){
    $url=$this->url;
    $view=$this->view('');
    $deviceid=onez()->gp('deviceid');
    $auto=onez()->gp('auto');
    $html[]=<<<ONEZ
<script type="text/javascript">
var _onez_ai_url_device='$url';
var _onez_ai_view_device='$view';
var _onez_ai_deviceid='$deviceid';
var _onez_ai_auto='$auto';
</script>
ONEZ;
    $html[]=onez('ui')->js($this->url.'/js/ai.device.dialog.js');
    return implode("\n",$html);
  }
  //获取启动信息
  function start(){
    $initdata=$_POST;
    $data=onez('ai')->init($this)->start($initdata);
    onez()->output($data);
  }
  //发送一条信息
  function send(){
    $data=onez('ai')->init($this)->input($_POST);
    onez()->output($data);
  }
  //触发一条默认消息
  function auto(){
    $udid=onez()->gp('udid');
    $auto=onez()->gp('auto');
    !$auto && $auto='hello';
    $data=onez('ai')->init($this)->input(array(
      'auto'=>1,
      'udid'=>$udid,
      'type'=>'text',
      'message'=>$auto,
    ));
    onez()->output($data);
  }
  //未读消息
  function newmsg(){
    $udid=onez()->gp('udid');
    $msgid=(int)onez()->gp('msgid');
    $data=onez('ai')->init($this)->newmsg($udid,$msgid);
    onez()->output(array('messages'=>$data,'count'=>count($data)));
  }
  //历史记录
  function history(){
    $udid=onez()->gp('udid');
    $page=(int)onez()->gp('page');
    $data=onez('ai')->init($this)->history($udid,$page);
    onez()->output(array('messages'=>$data,'count'=>count($data)));
  }
  //设置已读
  function isread(){
    $msgids=onez()->gp('msgids');
    onez('ai')->init($this)->isread($msgids);
    onez()->output(array('status'=>'ok'));
  }
  //默认头像
  function avatar(){
    return $this->url.'/images/avatar.png';
  }
  
}