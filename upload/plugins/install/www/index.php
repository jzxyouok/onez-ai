<?php

/* ========================================================================
 * $Id: index.php 1880 2016-09-05 10:26:27Z onez $
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
onez('admin')->title=$G['title']='佳蓝系列产品安装向导';

$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;
$form->add(array('label'=>'超级管理账号','type'=>'text','key'=>'admin_username','hint'=>'','notempty'=>'超级管理账号不能为空'));
$form->add(array('label'=>'超级管理密码','type'=>'password','key'=>'admin_password1','hint'=>'','notempty'=>'超级管理密码不能为空'));
$form->add(array('label'=>'确认超级管理密码','type'=>'password','key'=>'admin_password2','hint'=>'','notempty'=>'确认超级管理密码不能为空'));

#处理提交
if($onez=$form->submit()){
  $admin_username=$onez['admin_username'];
  $admin_password1=$onez['admin_password1'];
  $admin_password2=$onez['admin_password2'];
  !$admin_username && onez()->error('超级管理账号不能为空');
  !$admin_password1 && onez()->error('超级管理密码不能为空');
  $admin_password1!=$admin_password2 && onez()->error('两次密码不一致');
  onez('cache')->option_set(array(
    'is_install'=>$admin_username,
    'admin_username'=>$admin_username,
    'admin_password'=>md5($admin_password2),
  ));
  onez()->ok(1,onez('super')->www('/index.php'));
}
onez('admin')->header();
?>
<section class="content">
<div class="row">
  <div class="col-lg-6 col-xs-offset-3">


<form method="post" id="form-common" class="">
    <h3 class="box-title">设置超级管理账号</h3>
<div class="callout callout-info lead">
  <h4>系统提示</h4>
  <p>超级管理账号用于管理各扩展配置信息，请务必妥善保存</p>
</div>
	  <?=$form->code();?>
	  <button class="btn btn-success" type="submit">下一步</button>
    <input type="hidden" name="action" value="save">
</form>

  
  </div>
</div>
</section>
<?
echo $form->js();
onez('admin')->footer();