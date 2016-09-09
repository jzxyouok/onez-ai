<?php

/* ========================================================================
 * $Id: setattr_detail.php 3206 2016-09-09 09:31:02Z onez $
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

$attrid=(int)onez()->gp('attrid');

$attr=onez('db')->open('attrs')->one("attrid='$attrid'");

list($atoken)=explode('|',$attr['type']);


$item=$G['item']=array();
$G['title']='属性操作方式';


$action=onez()->gp('action');
if($action=='setattr'){
  onez('ai.attr')->doit($result,$_POST,$person->id);
  onez()->output(array('status'=>'success'));
}
  

#初始化表单
$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;

#创建表单项


$form->add(array('label'=>'属性名称','type'=>'html','html'=>'<code>'.$attr['subject'].'</code>'));

if($person){
  $current=$G['item']['current']=$person->info($attr['subject']);
  $form->add(array('label'=>'当前值','type'=>'html','html'=>'<code>'.$current.'</code>'));
}
if($options=onez($atoken)->options_ai()){
  foreach($options as $v){
    $form->add($v);
  }
}

#处理提交
onez('admin')->header();
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
      </div>
      <div class="box-footer clearfix">
        <button type="submit" class="btn btn-primary">
          确定
        </button>
        <a href="<?php echo $this->view('setattr&deviceid='.$deviceid.'&personid='.$personid.'&miniwin=1')?>" class="btn btn-default">
          返回
        </a>
      </div>
    </div>
    <input type="hidden" name="attrid" value="<?=$attrid?>" />
  </form>
</section>
<script type="text/javascript">
$(function(){
  $('#form-common').unbind('submit').bind('submit',function(){
    var arr=$(this).serializeArray();
    var json={
      type:'setattr',
    };
    for(var i in arr){
      if(arr[i].value.length<1){
        continue;
      }
      if(arr[i].name=='plus'){
        json.text='属性<code><?=$attr['subject']?></code> 增加<code>'+arr[i].value+'</code>';
      }
      if(arr[i].name=='minus'){
        json.text='属性<code><?=$attr['subject']?></code> 减少<code>'+arr[i].value+'</code>';
      }
      if(arr[i].name=='set'){
        json.text='属性<code><?=$attr['subject']?></code> 设置为<code>'+arr[i].value+'</code>';
      }
      json[arr[i].name]=arr[i].value;
    }
    <?if($person){?>
    delete json['type'];
    delete json['text'];
    json.action='setattr';
    $.post(window.location.href,json,function(data){
      if(data.status=='success'){
        parent._doit_add(data);
      }else{
        onez.alert(data.error);
      }
    },'json');
    <?}else{?>
    $(this).attr('data-json',JSON.stringify(json));
    parent._doit_add($(this));
    return false;
    <?}?>
    return false;
  });
});
</script>
<?php
onez('admin')->footer();
?>