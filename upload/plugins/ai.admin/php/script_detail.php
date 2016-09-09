<?php

/* ========================================================================
 * $Id: script_detail.php 2152 2016-09-07 12:34:58Z onez $
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

$script=onez()->gp('script');
$name=onez()->gp('name');


$item=array();
$G['title']='脚本附加信息';
  

#初始化表单
$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;

#创建表单项
$form->add(array('type'=>'hidden','key'=>'action','value'=>'save'));
$form->add(array('label'=>'脚本名称','type'=>'html','html'=>'<code>'.($name?$name:onez($script)->token).'</code>'));
if($options=onez($script)->options()){
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
        <a href="<?php echo $this->view('script&miniwin=1')?>" class="btn btn-default">
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
      type:'script',
      script:'<?=$script?>',
      text:'执行脚本<code><?=$name?></code>',
    };
    for(var i in arr){
      if(arr[i].value.length<1){
        continue;
      }
      json[arr[i].name]=arr[i].value;
    }
    $(this).attr('data-json',JSON.stringify(json));
    parent._doit_add($(this));
    return false;
  });
});
</script>
<?php
onez('admin')->footer();
?>