<?php

/* ========================================================================
 * $Id: login.php 1883 2016-09-02 10:51:44Z onez $
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


include(dirname(dirname(__FILE__)).'/lib/onezphp.php');
$action=onez()->gp('action');
if($action=='chklogin'){
  if(!onez('rndcode')->check('rndcode')){
    onez()->error('验证码不正确');
  }
  $username=onez()->gp('username');
  $password=onez()->gp('password');
  $password_md5=md5($password);
  $T=onez('db')->open('admin')->one("username='$username' and password='$password_md5'");
  !$T && onez()->error('账号或密码不正确');
  onez('scookie')->call('adminid',$T['adminid'],0);
  onez()->ok('登录成功','index.php');
}
$userid=(int)onez('scookie')->call('adminid');
if($userid){
  onez()->location('index.php');
}

$ui=onez('ui')->init();
$ui->header();
?>
<link rel="stylesheet" href="images/signin.css">
<div class="signin">
	<div class="signin-head"><img src="images/test/avatar5.png" alt="" class="img-circle"></div>
	<form class="form-signin" method="post" role="form">
		<input type="text" name="username" class="form-control" placeholder="管理账号" required autofocus />
		<input type="password" name="password" class="form-control" placeholder="管理密码" required />
    <p>
		<input type="text" name="rndcode" class="form-control rndcode" placeholder="验证码" required />
    <img src="<?=onez('rndcode')->pic()?>" class="rndcode-img"/>
    </p>
		<button class="btn btn-lg btn-warning btn-block" type="submit">登录</button>
    <input type="hidden" name="action" value="chklogin" />
	</form>
</div>
<script type="text/javascript">
$(function(){
  $('.form-signin').unbind('submit').bind('submit',function(){
    $.post(window.location.href,$(this).serialize(),function(o){
      if(o.error){
        $('.rndcode-img').trigger('click');
        alert(o.error);
      }else{
        location.href=o.goto;
      }
    },'json');
    return false;
  });
});
</script>
<?
$ui->footer();
