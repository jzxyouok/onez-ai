<?php

/* ========================================================================
 * $Id: edit.php 2706 2016-09-09 09:40:12Z onez $
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
define('CUR_URL','/workers/index.php');

$id=(int)onez()->gp('id');
if($id){#编辑
  $item=onez('db')->open('workers')->one("workerid='$id'");
  $G['title']='编辑负责人';
  $item['password']='';
  $btnname='保存修改';
}else{#添加
  $item=array();
  $G['title']='添加负责人';
  $btnname='立即添加';
}

#初始化表单
$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;

#创建表单项
$form->add(array('type'=>'hidden','key'=>'action','value'=>'save'));
$form->add(array('label'=>'负责人账号','type'=>'text','key'=>'username','hint'=>'请填写负责人账号','notempty'=>'负责人账号不能为空'));

if($id){
  $form->add(array('label'=>'负责人密码','type'=>'text','key'=>'password','hint'=>'不改请留空','notempty'=>''));
}else{
  $form->add(array('label'=>'负责人密码','type'=>'text','key'=>'password','hint'=>'请填写负责人密码','notempty'=>'负责人密码不能为空'));
}

#处理提交
if($onez=$form->submit()){
  if($id){
    if($onez['password']){
      $onez['password']=md5($onez['password']);
    }else{
      unset($onez['password']);
    }
    onez('db')->open('workers')->update($onez,"workerid='$id'");
  }else{
    $onez['password']=md5($onez['password']);
    onez('db')->open('workers')->insert($onez);
  }
  onez()->ok('操作成功',onez()->href('/workers/index.php'));
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
      <a href="<?php echo onez()->href('/workers/index.php')?>">
        负责人管理
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
        <button type="submit" class="btn btn-primary">
          <?php echo $btnname;?>
        </button>
        <a href="<?php echo onez()->href('/workers/index.php')?>" class="btn btn-default">
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