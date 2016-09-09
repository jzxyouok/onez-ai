<?php

/* ========================================================================
 * $Id: edit.php 5086 2016-09-06 18:02:22Z onez $
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

include(dirname(__FILE__).'/rules.inc.php');

$id=(int)onez()->gp('id');
if($id){#编辑
  $item=onez('db')->open('rules_group')->one("groupid='$id'");
  $G['title']='编辑应答规则分类';
  $btnname='保存修改';
}else{#添加
  $item=array();
  $item['tags']='所有目标';
  $G['title']='添加应答规则分类';
  $btnname='立即添加';
}

#初始化表单
$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;

#预加载
#创建表单项
$form->add(array('type'=>'hidden','key'=>'action','value'=>'save'));
$form->add(array('label'=>'规则分类名称','type'=>'text','key'=>'subject','hint'=>'请填写规则分类名称','notempty'=>'规则分类名称不能为空'));

$options=array();
$T=onez('db')->open('workers')->record("");
foreach($T as $rs){
  $options[$rs['workerid']]=$rs['username'];
}
$form->add(array('label'=>'负责人','type'=>'select','multiple'=>1,'key'=>'workers','value'=>explode(',',$item['workers']),'options'=>$options));


$form->add(array('label'=>'标签判定方式','type'=>'select','key'=>'type','options'=>$options_type));

#处理提交
if($onez=$form->submit()){
  $onez['tags']=onez()->gp('tags');
  $onez['workers']=implode(',',onez()->gp('workers'));
  if($id){
    onez('db')->open('rules_group')->update($onez,"groupid='$id'");
  }else{
    onez('db')->open('rules_group')->insert($onez);
  }
  onez()->ok('操作成功',onez()->href('/rules_group/index.php'));
}
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
    <li>
      <a href="<?php echo onez()->href('/rules_group/index.php')?>">
        智能标签管理
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
        <div class="form-group">
          <p id="tags_selected">
            <?
            $mytags=explode(',',$item['tags']);
            foreach($mytags as $tag){?>
              <button type="button" data-tag="<?=$tag?>" class="btn btn-xs btn-info"><i class="fa fa-minus-circle"></i> <?=$tag?></button>
            <?}?>
          </p>
        </div>
        <div class="form-group">
          <label for="input-tagname">未添加的标签</label>
          <p id="tags_notselected">
            <?
            $tags=onez('db')->open('tags')->record("1 order by level desc,tagid asc");
            foreach($tags as $rs){
              if(in_array($rs['tagname'],$mytags)){
                continue;
              }?>
              <button type="button" data-tag="<?=$rs['tagname']?>" class="btn btn-xs btn-info"><i class="fa fa-plus-circle"></i> <?=$rs['tagname']?></button>
            <?}?>
          </p>
        </div>

      </div>
      <div class="box-footer clearfix">
        <button type="submit" class="btn btn-primary">
          <?php echo $btnname;?>
        </button>
        <a href="<?php echo onez()->href('/rules_group/index.php')?>" class="btn btn-default">
          返回
        </a>
      </div>
    </div>
    <input type="hidden" id="tags" name="tags" value="<?=$item['tags']?>" />
    <input type="hidden" name="action" value="save" />
  </form>
</section>
<script type="text/javascript">
function _update_tags(){
  var tags=[];
  $('#tags_selected .btn[data-tag]').each(function(){
    tags.push($(this).attr('data-tag'));
  });
  $('#tags').val(tags.join(','));
  
  if($('#tags_selected .btn').length<1){
    $('#tags_selected').html('<span class="text-red">请至少添加一个标签</span>');
  }
  if($('#tags_notselected .btn').length<1){
    $('#tags_notselected').html('<span class="text-red">没有可添加的标签了</span>, <a href="<?php echo onez()->href('/tags/edit.php')?>">去添加？</a>');
  }
}
$(function(){
  $('.btn[data-tag]').click(function(){
    if($(this).parents('#tags_selected').length>0){
      if($('#tags_notselected .btn').length<1){
        $('#tags_notselected').empty();
      }
      $(this).removeClass('btn-info').addClass('btn-default').appendTo('#tags_notselected').find('i').removeClass('fa-minus-circle').addClass('fa-plus-circle');
    }else{
      if($('#tags_selected .btn').length<1){
        $('#tags_selected').empty();
      }
      $(this).removeClass('btn-default').addClass('btn-info').appendTo('#tags_selected').find('i').removeClass('fa-plus-circle').addClass('fa-minus-circle');
    }
    _update_tags();
  });
  _update_tags();
});
</script>
<?php
echo $form->js();
onez('admin')->footer();
?>