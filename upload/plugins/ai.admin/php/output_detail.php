<?php

/* ========================================================================
 * $Id: output_detail.php 2677 2016-09-09 05:26:42Z onez $
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

$item=array();
$G['title']='输出内容';
  

#初始化表单
$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;

$action=onez()->gp('action');
if($action=='output'){
  onez('ai.admin')->check();
  onez('ai.output')->doit($result,$_POST,$person->id);
  onez()->output(array('status'=>'success'));
}

#创建表单项
$form->add(array('label'=>'所属终端','type'=>'html','html'=>'<code>'.$device['subject'].'</code>'));
$form->add(array('label'=>'数据类型','type'=>'html','html'=>'<code>'.$output_typename.'</code>'));
if($options=onez($output_type)->options_ai()){
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
        <a href="<?php echo $this->view('output&deviceid='.$deviceid.'&personid='.$personid.'&miniwin=1')?>" class="btn btn-default">
          返回
        </a>
      </div>
    </div>
  </form>
</section>
<script type="text/javascript">
$(function(){
  $('#form-common').unbind('submit').bind('submit',function(){
    var arr=$(this).serializeArray();
    var json={
      type:'output',
      output:'<?=$output_type?>',
      text:'输出<code><?=$output_typename?></code>数据',
    };
    for(var i in arr){
      if(arr[i].value.length<1){
        continue;
      }
      json.text+='<code>['+arr[i].name+']='+arr[i].value+'</code>;';
      json[arr[i].name]=arr[i].value;
    }
    <?if($person){?>
    delete json['type'];
    delete json['text'];
    json.action='output';
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
    <?}?>
    return false;
  });
});
</script>
<?php
onez('admin')->footer();
?>