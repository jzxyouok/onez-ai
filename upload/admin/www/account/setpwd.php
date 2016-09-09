<?php

/* ========================================================================
 * $Id: setpwd.php 1825 2016-09-05 14:53:42Z onez $
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
$G['title']='修改密码';

define('CUR_URL','/account/setpwd.php');

$form=onez('admin')->widget('form');

$form->add(array('label'=>'旧密码','type'=>'password','key'=>'password0','hint'=>'请输入您的旧密码','notempty'=>'旧密码不能为空','value'=>''));
$form->add(array('label'=>'新密码','type'=>'password','key'=>'password1','hint'=>'请输入您的新密码','notempty'=>'新密码不能为空','value'=>''));
$form->add(array('label'=>'确认新密码','type'=>'password','key'=>'password2','hint'=>'请再次输入新密码','notempty'=>'确认新密码不能为空','value'=>''));

#处理提交
if($onez=$form->submit()){
  $password0=$onez['password0'];
  $password1=$onez['password1'];
  $password2=$onez['password2'];
  $password1!=$password2 && onez()->error('再次密码不一致');
  $T=onez('db')->open('admin')->one("adminid='$G[userid]'");
  md5($password0)!=$T['password'] && onez()->error('旧密码不正确');
  onez('db')->open('admin')->update(array(
    'password'=>md5($password2),
  ),"adminid='$G[userid]'");  
  onez()->ok('修改密码成功','reload');
}

onez('admin')->header();
?>
<section class="content">
<div class="row">
  <div class="col-lg-8">
  
<form method="post" id="form-common" class="">
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$G['title']?></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
	  <?=$form->code();?>
  </div><!-- /.box-body -->
  <div class="box-footer">
	  <button class="btn btn-success" type="submit">保存修改</button>
  </div>
</div>
<input type="hidden" name="action" value="save">
</form>

  
  </div>
</div>
</section>
<?
echo $form->js();
onez('admin')->footer();