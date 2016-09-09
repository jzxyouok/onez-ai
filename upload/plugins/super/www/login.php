<?php

/* ========================================================================
 * $Id: login.php 2769 2016-09-09 15:11:04Z onez $
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
onez('admin')->menu=false;
onez('admin')->title=$G['title']='登录超级管理中心';

$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;
$form->add(array('label'=>'超级管理账号','type'=>'text','key'=>'admin_username','hint'=>'','notempty'=>'超级管理账号不能为空'));
$form->add(array('label'=>'超级管理密码','type'=>'password','key'=>'admin_password','hint'=>'','notempty'=>'超级管理密码不能为空'));

#处理提交
if($onez=$form->submit()){
  $admin_username=$onez['admin_username'];
  $admin_password=$onez['admin_password'];
  !$admin_username && onez()->error('超级管理账号不能为空');
  !$admin_password && onez()->error('超级管理密码不能为空');
  if(!onez('rndcode')->check('rndcode')){
    onez()->output(array('rndcode'=>'error','error'=>'验证码不正确'));
  }
  
  md5($admin_password)!=onez('cache')->option('admin_password') && onez()->error('超级管理账号或密码不正确');
  
  onez('cache')->cookie('superinfo',array('username'=>$admin_username),1);
  onez()->ok('登录成功',onez('super')->www('/index.php'));
}
onez('admin')->header();
?>
<section class="content">
<div class="row">
		<div class="col-xs-6 col-xs-offset-3" id="tipmsg"></div>
  <div class="col-lg-6 col-xs-offset-3">


<form method="post" id="login_form" class="">
    <h3 class="box-title"></h3>

<div class="callout callout-info lead">
  <h4>系统提示</h4>
  <p>请填写开发模式下的超级管理账号</p>
</div>
	  <?=$form->code();?>
					<div class="form-group" style="margin-bottom: 0">
						<label>验证码</label>
					</div>
          <div class="form-group input-group">
            <input type="text" name="rndcode" class="form-control input-lg">
                <span class="input-group-btn">
                  <img src="<?=onez('rndcode')->pic()?>" id="image-rndcode" style="height: 46px;" />
                </span>
          </div>
	  <button class="btn btn-block btn-lg btn-success" type="submit">立即登录</button>
    <input type="hidden" name="action" value="save">
</form>

  
  </div>
</div>
</section>
<script type="text/javascript">
$(function(){
  $('input.form-control').addClass('input-lg');
  $('#login_form').unbind('submit').bind('submit',function(){
    $.post(window.location.href,$(this).serialize(),function(data){
      if(data.error){
        if(typeof data.rndcode=='string' && data.rndcode=='error'){
          $('#image-rndcode').trigger('click');
        }
        $('#tipmsg').html('<div class="alert alert-danger">'+data.error+'</div>');
      }else{
        location.href=data.goto;
      }
    },'json');
    return false;
  });
});
</script>
<?
onez('admin')->footer();