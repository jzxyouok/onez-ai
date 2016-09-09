<?php

/* ========================================================================
 * $Id: add_design.php 5682 2016-09-08 18:10:32Z onez $
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
define('CUR_URL','/rules_group/index.php');

include(dirname(dirname(__FILE__)).'/rules_group/rules.inc.php');

$id=(int)onez()->gp('id');
if($id){#编辑
  $item=onez('db')->open('rules')->one("ruleid='$id'");
  
  $groupid=$item['groupid'];
  $deviceid=$item['deviceid'];
  $input_type=$item['input_type'];
  $input_typename=$item['input_typename'];
}else{#添加
  $item=array();
  $groupid=(int)onez()->gp('groupid');
  $deviceid=(int)onez()->gp('deviceid');
  $input_type=onez()->gp('input_type');
  $input_typename=onez()->gp('input_typename');
}


$group=onez('db')->open('rules_group')->one("groupid='$groupid'");

$device=onez('db')->open('devices')->one("deviceid='$deviceid'");


$G['title']='设计规则';



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
    $onez['add_info']='后台:<code>'.$G['nickname'].'</code>';
    $onez['addtype']='admin';
    $onez['addtime']=time();
    onez('db')->open('rules')->insert($onez);
  }
  onez()->ok('操作成功',onez()->href('/rules/index.php?groupid='.$groupid));
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
    onez.formpost(this);
    return false;
  });
});
</script>
<?php
onez('admin')->footer();
?>