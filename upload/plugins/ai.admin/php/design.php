<?php

/* ========================================================================
 * $Id: design.php 6413 2016-09-09 03:48:30Z onez $
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


include(ONEZ_ROOT.'/admin/www/rules_group/rules.inc.php');

$item=array();
$deviceid=(int)onez()->gp('deviceid');
$person_id=(int)onez()->gp('person_id');
$msgid=(int)onez()->gp('msgid');
$text=$item['summary']=onez()->gp('text');
$input_type='ai.input.text';
$input_typename='文本';


$person=onez('ai.person')->init($person_id);
$deviceid=$person->person['deviceid'];

$device=onez('db')->open('devices')->one("deviceid='$deviceid'");



$groupid=(int)onez()->gp('groupid');
if(!$groupid){
  $tags=$person->info('tags');
  //遍历规则分类
  $groups=onez('db')->open('rules_group')->record("");
  foreach($groups as $group){
    //判断是否符合标签规则
    if(!onez('ai')->tags_match($tags,$group)){
      continue;
    }
    $groupid=$group['groupid'];
  }
}
!$groupid && onez('showmessage')->error('没有符合此用户的规则分类，请先去后台增加相应的分类');
$group=onez('db')->open('rules_group')->one("groupid='$groupid'");

$G['title']='设计规则';

$item['rule']=json_encode(array(
  'same'=>$text,
));

#初始化表单
$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;

#创建表单项
$form->add(array('type'=>'hidden','key'=>'action','value'=>'save'));
$form->add(array('label'=>'规则描述','type'=>'textarea','key'=>'summary','hint'=>'规则描述用于快速识别/查找','notempty'=>''));


            $grouphtml='<code>'.$group['subject'].'</code>';
            $mytags=explode(',',$group['tags']);
            $tags='';
            foreach($mytags as $tag){
              $tags.='<span class="btn btn-xs btn-info">'.$tag.'</span>';
            }
            $grouphtml.= '<p><br /><span class="text">'.str_replace('*',$tags,$options_typename[$group['type']]).'</span></p>';
$form->add(array('label'=>'规则分类','type'=>'html','html'=>$grouphtml));
$form->add(array('label'=>'适合终端','type'=>'html','html'=>'<code>'.$device['subject'].'</code>'));
$form->add(array('label'=>'数据类型','type'=>'html','html'=>'<code>'.$input_typename.'</code>'));

#处理提交
$action=onez()->gp('action');
if($action=='save'){
  $onez=array();
  $onez['groupid']=(int)onez()->gp('groupid');
  $onez['deviceid']=(int)onez()->gp('deviceid');
  $onez['summary']=onez()->gp('summary');
  $onez['input_type']=onez()->gp('input_type');
  $onez['input_typename']=onez()->gp('input_typename');
  $onez['rule']=$_REQUEST['rule'];
  $onez['doit']=$_REQUEST['doit'];
  
  $onez['updatetime']=time();
  $onez['hash']=md5($onez['groupid'].$onez['deviceid'].$_REQUEST['rule'].$_REQUEST['doit']);
  
  if($id){
    onez('db')->open('rules')->update($onez,"ruleid='$id'");
  }else{
    if(onez('db')->open('rules')->rows("hash='{$onez['hash']}'")>0){
      onez()->error('此规则已存在','');
    }
    $onez['userid']=$G['userid'];
    if($G['grade']=='admin'){
      $onez['add_info']='超管:<code>'.$G['userid'].'</code>';
    }elseif($G['grade']=='worker'){
      $onez['add_info']='负责人:<code>'.$G['userid'].'</code>';
    }else{
    }
    $onez['addtype']=$G['grade'];
    $onez['addtime']=time();
    onez('db')->open('rules')->insert($onez);
  }
  
  $data=array(
    'type'=>'text',
    'message'=>$text,
  );
  $doit=onez('ai')->doit($data,json_decode($onez['doit'],1));
  onez()->ok('操作成功','');
}
onez('admin')->header();

$arr=array();
$arr['deviceid']=$deviceid;
$arr['groupid']=$groupid;
$arr['input_type']=$input_type;
$arr['rule']=array();
$arr['doit']=array();
$item['rule'] && $arr['rule']=json_decode($item['rule'],1);
$item['doit'] && $arr['doit']=json_decode($item['doit'],1);
?>
<section class="content-header">
  <h1>
    <?=$G['title']?>
  </h1>
  <ol class="breadcrumb">
    <li>
      <a href="<?php echo onez()->href('/')?>">
        <i class="fa fa-dashboard">
        </i>
        管理首页
      </a>
    </li>
    <li>
      <a href="<?php echo onez()->href('/rules_group/index.php')?>">
        <?=$group['subject']?>
      </a>
    </li>
    <li>
      <a href="<?php echo onez()->href('/rules/index.php?groupid='.$groupid)?>">
        规则管理
      </a>
    </li>
    <li>
      <a href="<?php echo onez()->href('/rules/add_device.php?groupid='.$groupid)?>">
        选择终端(<?=$device['subject']?>)
      </a>
    </li>
    <li>
      <a href="<?php echo onez()->href('/rules/add_input.php?groupid='.$groupid.'&deviceid='.$deviceid)?>">
        数据类型(<?=$input_typename?>)
      </a>
    </li>
    <li class="active">
      <?php echo $G['title'];?>
    </li>
  </ol>
</section>
<section class="content">
  <form id="form-common" method="post">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">
          <?php echo $G['title'];?>
        </h3>
        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        <?php echo $form->code();?>
        <?=onez($input_type)->form($arr)?>
        <?=onez('ai.admin')->doit($arr)?>
      </div>
      <div class="box-footer clearfix">
        <button type="submit" class="btn btn-primary">
          保存规则
        </button>
      </div>
    </div>
    <input type="hidden" name="groupid" value="<?=$groupid?>" />
    <input type="hidden" name="deviceid" value="<?=$deviceid?>" />
    <input type="hidden" name="input_type" value="<?=$input_type?>" />
    <input type="hidden" name="input_typename" value="<?=$input_typename?>" />
    <input type="hidden" name="rule" id="rule_input" value="" />
    <input type="hidden" name="doit" id="doit_input" value="" />
  </form>
</section>
<script type="text/javascript">
$(function(){
  $('#form-common').bind('submit',function(){
    //input信息
    if(typeof _rule_get=='function'){
      var rule=_rule_get();
      if(typeof rule=='string'){
        onez.alert(rule);
        return false;
      }
      $('#rule_input').val(JSON.stringify(rule));
    }
    
    //doit信息
    var doit=_doit_get();
    if(typeof doit=='string'){
      onez.alert(doit);
      return false;
    }
    $('#doit_input').val(JSON.stringify(doit));
    
    $.post(window.location.href,$(this).serialize(),function(data){
      if(data.status=='success'){
        parent._doit_add(data);
      }else{
        onez.alert(data.error);
      }
    },'json');
    return false;
  });
});
</script>
<?php
onez('admin')->footer();
?>