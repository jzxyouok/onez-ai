<?php

/* ========================================================================
 * $Id: ai.admin.php 10377 2016-09-09 04:33:18Z onez $
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
class onezphp_ai_admin extends onezphp{
  function __construct(){
    
  }
  function doit($item=array()){
    $arr=$item['doit'];
    $doits=is_array($arr)?json_encode($arr):'[]';
    $url=$this->view('');
    !$item['is_dialog'] && $html[]=<<<ONEZ
<h3>当目标发送的数据符合以上条件时，您要执行的操作是？</h3>
<p>
  <button type="button" class="btn btn-xs btn-success" onclick="_doit_addtag()">为目标增加一个标签</button>
  <button type="button" class="btn btn-xs btn-success" onclick="_doit_removetag()">为目标移除一个标签</button>
  <button type="button" class="btn btn-xs btn-success" onclick="_doit_setattr()">修改目标属性</button>
  <button type="button" class="btn btn-xs btn-success" onclick="_doit_script()">执行一个脚本</button>
  <button type="button" class="btn btn-xs btn-success" onclick="_doit_output()">输出一条数据</button>
</p>
<ol id="_doit">
</ol>
ONEZ;
    $html[]=<<<ONEZ
<script type="text/javascript">
var _url='$url';
var _deviceid='$item[deviceid]';
var _personid='';
var _doits=$doits;
</script>
ONEZ;
    #预加载
    onez('event')->load('miniwin')->args();
    $html[]=onez('ui')->js($this->url.'/js/admin.js');
    return implode("\n",$html);
  }
  function addtag(){
    $deviceid=(int)onez()->gp('deviceid');
    $personid=(int)onez()->gp('personid');
    if($personid){
      $person=onez('ai.person')->init($personid);
    }
    include_once(dirname(__FILE__).'/php/addtag.php');
  }
  function removetag(){
    $deviceid=(int)onez()->gp('deviceid');
    $personid=(int)onez()->gp('personid');
    if($personid){
      $person=onez('ai.person')->init($personid);
    }
    include_once(dirname(__FILE__).'/php/removetag.php');
  }
  function setattr(){
    $deviceid=(int)onez()->gp('deviceid');
    $personid=(int)onez()->gp('personid');
    if($personid){
      $person=onez('ai.person')->init($personid);
    }
    include_once(dirname(__FILE__).'/php/setattr.php');
  }
  function setattr_detail(){
    global $G;
    $_REQUEST['miniwin']=1;
    $deviceid=(int)onez()->gp('deviceid');
    $personid=(int)onez()->gp('personid');
    if($personid){
      $person=onez('ai.person')->init($personid);
    }
    include_once(dirname(__FILE__).'/php/setattr_detail.php');
  }
  function script(){
    $_REQUEST['miniwin']=1;
    $personid=(int)onez()->gp('personid');
    if($personid){
      $person=onez('ai.person')->init($personid);
    }
    include_once(dirname(__FILE__).'/php/script.php');
  }
  function script_detail(){
    global $G;
    $_REQUEST['miniwin']=1;
    $deviceid=(int)onez()->gp('deviceid');
    $personid=(int)onez()->gp('personid');
    if($personid){
      $person=onez('ai.person')->init($personid);
    }
    include_once(dirname(__FILE__).'/php/script_detail.php');
  }
  function output(){
    $deviceid=(int)onez()->gp('deviceid');
    $device=onez('db')->open('devices')->one("deviceid='$deviceid'");
    list($dtoken)=explode('|',$device['device_token']);
    
    $personid=(int)onez()->gp('personid');
    if($personid){
      $person=onez('ai.person')->init($personid);
    }
    include_once(dirname(__FILE__).'/php/output.php');
  }
  function output_detail(){
    $deviceid=(int)onez()->gp('deviceid');
    $device=onez('db')->open('devices')->one("deviceid='$deviceid'");
    list($dtoken)=explode('|',$device['device_token']);
    
    $output_type=onez()->gp('output_type');
    $output_typename=onez()->gp('output_typename');

    $_REQUEST['miniwin']=1;
    
    $personid=(int)onez()->gp('personid');
    if($personid){
      $person=onez('ai.person')->init($personid);
    }
    include_once(dirname(__FILE__).'/php/output_detail.php');
  }
  function click_add($arr){
    return 'parent._doit_add(this)" data-json='.var_export(json_encode($arr),1).' data-tmp="';
  }
  function worker(){
    global $G;
    $workerid=(int)onez('cache')->cookie('workerid');
    if($workerid){
      $worker=onez('db')->open('workers')->one("workerid='$workerid'");
    }
    if(!$worker){
      include_once(dirname(__FILE__).'/php/login.php');
      exit();
    }
    $G['grade']='worker';
    $G['title']='人工管理窗口';
    include_once(dirname(__FILE__).'/php/dialog.php');
    
    $url=$this->url;
    $view=$this->view('');
    $html=array();
    $html[]=<<<ONEZ
<script type="text/javascript">
var _onez_ai_url_device='$url';
var _onez_ai_view_device='$view';
var _onez_ai_grade='worker';
</script>
ONEZ;
    $html[]=onez('ui')->js($this->url.'/js/ai.admin.dialog.js');
    echo implode("\n",$html);
  }
  function admin(){
    global $G;
    $userid=$G['userid']=(int)onez('scookie')->call('adminid');
    if($userid){
      $admin=onez('db')->open('admin')->one("adminid='$G[userid]'");
    }
    if(!$admin){
      onez()->location(onez()->homepage().'/admin');
    }
    $G['grade']='admin';
    $G['title']='超级管理窗口';
    include_once(dirname(__FILE__).'/php/dialog.php');
    
    
    $url=$this->url;
    $view=$this->view('');
    $html=array();
    $html[]=<<<ONEZ
<script type="text/javascript">
var _onez_ai_url_device='$url';
var _onez_ai_view_device='$view';
var _onez_ai_grade='admin';
</script>
ONEZ;
    $html[]=onez('ui')->js($this->url.'/js/ai.admin.dialog.js');
    echo implode("\n",$html);
  }
  //检测权限
  function check(){
    global $G;
    $grade=onez()->gp('grade');
    if(!$grade){
      $grade=onez('scookie')->call('grade');
    }else{
      onez('scookie')->call('grade',$grade);
    }
    if($grade=='admin'){
      $userid=(int)onez('scookie')->call('adminid');
      if($userid){
        $G['plat']='admin';
        $G['userid']=$userid;
        return true;
      }
    }elseif($grade=='worker'){
      $workerid=(int)onez('cache')->cookie('workerid');
      if($workerid){
        $G['plat']='worker';
        $G['userid']=$workerid;
        return true;
      }
    }
    $G['grade']=$G['plat'];
    onez()->output(array('status'=>'error','message'=>'请先登录'));
  }
  //新消息
  function newmsg(){
    global $G;
    $person_ids=explode(',',onez()->gp('person_ids'));
    $person_id=(int)onez()->gp('person_id');
    
    $this->check();
    $result=array();
    if($G['plat']=='admin'){
      
    }elseif($G['plat']=='worker'){
      
    }
    $P=array();
    //
    $persons=array();
    $T=onez('db')->open('person')->record("1 order by lasttime desc");
    foreach($T as $rs){
      $noread=onez('db')->open('history')->rows("udid='$rs[udid]' and action='person' and status='ask'");
      $status='';
      if($noread>0){
        $status.='<span class="badge">'.$noread.'</span>';
      }
      if($rs['id']==$person_id){
        $P=$rs;
      }
      $p=onez('ai.person')->init($rs);
      $person=array(
        'id'=>$rs['id'],
        'deviceid'=>$rs['deviceid'],
        'avatar'=>$p->info('头像'),
        'status'=>$status,
        'nickname'=>$p->info('昵称'),
        'summary'=>onez()->substr($rs['lastmsg'],0,20),
      );
      $persons[]=$person;
    }
    $result['persons']=$persons;
    
    if($P){
      $msgid=(int)onez()->gp('msgid');
      if($msgid>0){
        $T=onez('db')->open('history')->record("udid='{$P['udid']}' and id>$msgid order by id");
      }else{
        $T=onez('db')->open('history')->record("udid='{$P['udid']}' and isread_u=0 order by id");
      }
      onez('ai')->msg_format($T);
      $result['messages']=$T;
    }
    
    onez()->output($result);
  }
  //目标信息
  function person_info(){
    global $G;
    
    $this->check();
    $person_id=(int)onez()->gp('person_id');
    $person=onez('db')->open('person')->one("id='$person_id'");
    $result=array();
    if($G['plat']=='admin'){
      
    }elseif($G['plat']=='worker'){
      
    }
    
    
    $result['messages']=onez('ai')->history($person['udid']);
    
    onez()->output($result);
  }
  //目标各类属性
  function person_more(){
    global $G;
    
    $this->check();
    $person_id=(int)onez()->gp('person_id');
    
    $person=onez('ai.person')->init($person_id);
    
    $info=$person->info;
    
    $info['initinfo']=unserialize($person->person['initdata']);
    $info['lastinfo']=unserialize($person->person['lastdata']);
    
    $info['initinfo']['时间']=date('Y-m-d H:i',$person->person['firsttime']);
    $info['initinfo']['IP']=$person->person['firstip'];
    $info['lastinfo']['时间']=date('Y-m-d H:i',$person->person['lasttime']);
    $info['lastinfo']['IP']=$person->person['lastip'];
    
    unset($info['device']);
    $result['info']=$info;
    
    onez()->output($result);
  }
  function cancel(){
    $result=array();
    $this->check();
    $msgid=onez()->gp('msgid');
    
    if($msgid=='all'){
      
      $person_id=(int)onez()->gp('person_id');
      $person=onez('db')->open('person')->one("id='$person_id'");
      $onez=array();
      $onez['status']='cancel';
      onez('db')->open('history')->update($onez,"udid='$person[udid]' and action='person' and status='ask'");
    }else{
      $msgid=intval($msgid);
      $onez=array();
      $onez['status']='cancel';
      onez('db')->open('history')->update($onez,"id='$msgid'");
    }
    
    
    onez()->output($result);
  }
  //发送信息
  function send(){
    global $G;
    $this->check();
    $person_id=(int)onez()->gp('person_id');
    $person=onez('db')->open('person')->one("id='$person_id'");
    
    $result=array();
    
    
    $type=onez()->gp('type');
    if($type=='text'){
      $text=onez()->gp('message');
      
      //自动学习
      $asrule=(int)onez()->gp('asrule');
      if($asrule){
        $msgid=(int)onez()->gp('msgid');
        if($msgid>0){
          onez('ai')->study($msgid,$text,$person,1);
        }
      }
      
      $msg=array(
        'type'=>'text',
        'pos'=>'you',
        'time'=>time(),
        'message'=>$text,
      );
      onez('ai')->push($person['udid'],$msg,$text,array(
        'you'=>$G['plat'].'-'.$G['userid'],
      ));
    }
    
    onez()->output($result);
  }
  //设置已读
  function isread(){
    $msgids=onez()->gp('msgids');
    if($msgids){
      $onez=array();
      $onez['isread_u']=1;
      $onez['readtime_u']=time();
      onez('db')->open('history')->update($onez,"id in ($msgids)");
    }
    return $this;
  }
  //设为规则
  function design(){
    include(dirname(__FILE__).'/php/design.php');
  }
}