<?php

/* ========================================================================
 * $Id: index.php 6207 2016-09-09 05:01:34Z onez $
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
define('CUR_URL','index.php');

$G['title']='管理首页';
#初始化表单
$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;

onez('admin')->header();
onez('admin')->widget('header')
  ->set('title',$G['title'])
  ->show();
echo onez('ui')->css('images/style.css');


$device=onez('db')->open('devices')->one("device_token like 'ai.device.dialog%'");
?>
<section class="content">
  <div class="row">
        <div class="col-md-4">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=onez('db')->open('person')->rows("deviceid='{$device['deviceid']}'")?> <sup style="font-size: 20px">人</sup></h3>

              <p>前端访客地址</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <?if($device){?>
            <a href="<?=onez('ai.device.dialog')->view('dialog&deviceid='.$device['deviceid'])?>" class="small-box-footer" target="_blank">点击打开 <i class="fa fa-arrow-circle-right"></i></a>
            <?}else{?>
            <a href="<?=onez()->href('/devices/index.php')?>" class="small-box-footer">请先添加终端 <i class="fa fa-arrow-circle-right"></i></a>
            <?}?>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?=onez('db')->open('workers')->rows("")?> <sup style="font-size: 20px">人</sup></h3>

              <p>人工管理窗口</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?=onez('ai.admin')->view('worker')?>" target="_blank" class="small-box-footer">点击打开 <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>--- <sup style="font-size: 20px"></sup></h3>

              <p>超级管理窗口</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?=onez('ai.admin')->view('admin')?>" target="_blank" class="small-box-footer">点击打开 <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      
    <div class="box box-danger">
      <div class="box-body">
        <code>API模式正在开发中，如有兴趣欢迎加入讨论...</code>
      </div>
    </div>
    
    
  <div class="row">
  
    <div class="col-md-8">
      <div class="box box-info">
        <div class="box-header ">
          <h3 class="box-title">什么是佳蓝人工智能开源框架</h3>
        </div>
        <div class="box-body">
          我们的最终目标是，打造一款能够完美连结服务端云平台、移动客户端、电脑网页、电脑软件、智能硬件等任意终端的人工智能框架。您可以免费使用、自主修改及二次开发。
<h4 class="text-gray">以及为部分应用场景(非已完成功能)</h4>
<p>网站智能客服</p>
<ol>
  <li>设定目标为在线访客</li>
  <li>自动分析访客的访问规律、页面偏好、是否会员、对什么内容感兴趣等，从而自动为此访客帖上相应的标签</li>
  <li>根据标签规则，调用不同的资源库，以及分配不同的人工客服</li>
  <li>例如，有<span class="btn btn-xs btn-info">正式客户</span>标签的用户，和没有此标签的用户，将会调用不同的资源库。</li>
</ol>
<p>私人秘书</p>
<ol>
  <li>设定目标为您个人独有的私人秘书</li>
  <li>您可以使用各种终端(电脑网页、手机客户端、智能硬件)记录日常各种数据</li>
  <li>为您的各种数据进行归类、整理</li>
  <li>在您需要的时候，快速以各种方式展现给您。如：语音、图表、表格、文本、图片、视频等</li>
</ol>
<p>智能家居控制</p>
<ol>
  <li>通过手机APP，语音，手势等方式，任意控制您家里的任何智能硬件</li>
  <li>重要的是，您的智能硬件只听命于您自己的平台。</li>
</ol>
<p>……</p>
<p class="text-red">以上并非此框架预设的功能，实际开发中可根据您的理解任意组合。</p>
        </div>
      </div>
    </div>
  
    <div class="col-md-4">
      <div class="box box-info">
        <div class="box-header ">
          <h3 class="box-title">联系方式</h3>
        </div>
        <div class="box-body">
<ul class="nav nav-pills nav-stacked">
  <li><a href="http://shang.qq.com/wpa/qunwpa?idkey=f7860dfb3e265264f9f359285de578f4fede15f6e8ef183614cdd11645922463" title="佳蓝人工智能开源框架" target="_blank">QQ交流群:<span class="pull-right text-red"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="佳蓝人工智能开源框架"></span></a></li>
  <li class="qrcode"><a href="javascript:;">微信公众号:<span class="pull-right text-black"><i class="fa fa-qrcode"></i> czonez</span></a>
  <img src="images/wx-czonez.jpg" style="width:290px;height:290px" />
  </li>
  
  <li><a href="http://ai.bbs.onez.cn/" target="_blank">论坛交流:<span class="pull-right text-black">点此访问</span></a></li>
</ul>
        </div>
      </div>
      
      <div class="box box-info">
        <div class="box-header ">
          <h3 class="box-title">最近更新</h3>
        </div>
<style>
.bbs ul{
  margin:0;
  padding: 0;
  list-style: none;
}
.bbs li{
  line-height: 2;
}
</style>
<div class="box-body bbs">
<script type="text/javascript" src="http://ai.bbs.onez.cn/api.php?mod=js&bid=3"></script>
        </div>
      </div>
    </div>
    
  </div>
    
</section>
<script type="text/javascript">
$(function(){
  $('.qrcode').click(function(){
    $(this).toggleClass('show');
  });
});
</script>
<?


onez('admin')->footer();