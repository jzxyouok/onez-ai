<?php

/* ========================================================================
 * $Id: detail.php 2248 2016-09-09 05:26:04Z onez $
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
define('CUR_URL','/devices/index.php');

$deviceid=(int)onez()->gp('deviceid');
$device=$item=$G['item']=onez('db')->open('devices')->one("deviceid='$deviceid'");
$G['title']=$device['subject'];

list($dtoken)=explode('|',$device['device_token']);

#初始化表单
$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;

#创建表单项
$form->add(array('type'=>'hidden','key'=>'action','value'=>'save'));
$form->add(array('label'=>'自定义终端名称','type'=>'html','html'=>'<code>'.$device['subject'].'</code>'));
$form->add(array('label'=>'终端类型','type'=>'html','html'=>'<code>'.onez('form.plugin.child')->name($device['device_token']).'</code>'));
if($options=onez($dtoken)->options_ai()){
  foreach($options as $v){
    $form->add($v);
  }
}

#处理提交
if($onez=$form->submit()){
  if($id){
    onez('db')->open('devices')->update($onez,"deviceid='$id'");
  }else{
    onez('db')->open('devices')->insert($onez);
  }
  onez()->ok('操作成功',onez()->href('/devices/index.php'));
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
      <a href="<?php echo onez()->href('/devices/index.php')?>">
        终端管理
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
      </div>
      <div class="box-footer clearfix">
        <a href="<?php echo onez()->href('/devices/index.php')?>" class="btn btn-default">
          返回
        </a>
      </div>
    </div>
    <input type="hidden" name="action" value="save" />
  </form>
</section>
<?php
echo $form->js();
onez('admin')->footer();
?>