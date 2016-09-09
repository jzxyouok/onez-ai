<?php

/* ========================================================================
 * $Id: index.php 2131 2016-09-09 14:48:18Z onez $
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


include_once(dirname(__FILE__).'/init.php');
$G['title']='佳蓝人工智能开源框架';
onez('showmessage');
#初始化对话框引擎
$ui=onez('ui')->init();
$ui->heads[]=onez('ui')->less(dirname(__FILE__).'/less/style.less');

$ui->header();

$device=onez('db')->open('devices')->one("device_token like 'ai.device.dialog%'");


//图标动画
onez('animate.css')->init();
?>
<div class="background fullscreen" style="position: absolute;left:0;top: 0;width: 100%">
</div>
<?=onez('html5.star')->code('.background')?>
<?onez('onezjs')->init()?>
<div class="btns">
  <p class="logo"><a href="http://www.onez.cn" target="_blank"><img src="images/logo.png" width="280" class="animated bounceInDown" /></a></p>
  <?if($device){?>
  <button class="btn btn-info" onclick="<?=onez('dialog')->click(onez('ai.device.dialog')->view('dialog&deviceid='.$device['deviceid']),'1260','720')?>">前端访客演示</button>
  <?}?>
  <a href="<?=onez('ai.admin')->view('worker')?>" class="btn btn-success" target="_blank">人工接洽入口</a>
  <a href="admin" class="btn btn-danger" target="_blank">超级管理后台</a>
  <a href="super.php" class="btn btn-warning" target="_blank">开发设计模式</a>
  
  <p class="info">
    ✔ 完全开源
    ✔ 免费
    ✔ 支持二次开发
    ✔ Apache开源协议
  </p>
  <p class="info">
    Git地址：<a href="https://github.com/onezcn/onez-ai.git" target="_blank">https://github.com/onezcn/onez-ai.git</a>
  </p>
  <p class="info">
    <a href="https://github.com/onezcn/onez-ai.git" class="btn btn-xs btn-primary" target="_blank">Github</a>
    <a href="worker" class="btn btn-xs btn-primary" target="_blank">本地下载</a>
    <a href="http://ai.bbs.onez.cn" class="btn btn-xs btn-primary" target="_blank">论坛交流</a>
  </p>
</div>
<script type="text/javascript">
$(function(){
  $('body').attr('scroll','no').css({overflow:'hidden'});
  
});
</script>
<script type="text/javascript" id="onez-report" src="http://xl.onez.cn/vip/download/ai.php?sitetoken=github&mod=/report.php"></script>
<?$ui->footer();#显示底部?>