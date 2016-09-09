<?php

/* ========================================================================
 * $Id: options.php 1992 2016-09-07 14:47:30Z onez $
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
#当前页地址（导航栏是否选中，和menu.inc.php中的href值一致）
define('CUR_URL','/options.php');
$item=onez('cache')->get('options');

$G['title']='管理首页';
#初始化表单
$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;
#预加载上传扩展
onez('upload');

$form->add(array('type'=>'hidden','key'=>'action','value'=>'save'));
$form->add(array('label'=>'机器人名称','type'=>'text','key'=>'myname','hint'=>'请设置机器人名称','notempty'=>'机器人名称不能为空'));
$form->add(array('label'=>'机器人头像','type'=>'upload','key'=>'myavatar','hint'=>'请设置机器人头像','notempty'=>''));
$form->add(array('label'=>'机器人简介','type'=>'textarea','key'=>'myinfo','hint'=>'请设置机器人简介','notempty'=>''));

#处理提交
if($onez=$form->submit()){
  onez('cache')->option_set($onez);
  onez()->ok('操作成功','reload');
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
          <?=$G['title']?>
        </h3>
        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        <?php echo $form->code();?>
      </div>
      <div class="box-footer clearfix">
        <button type="submit" class="btn btn-primary">
          保存修改
        </button>
      </div>
    </div>
    <input type="hidden" name="action" value="save" />
  </form>
</section>
<?php
echo $form->js();
onez('admin')->footer();
?>