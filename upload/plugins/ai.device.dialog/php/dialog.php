<?php

/* ========================================================================
 * $Id: dialog.php 2456 2016-09-09 05:05:24Z onez $
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
$G['title']='佳蓝人工智能开源框架';

onez('ai')->init($this);

$G['title']=onez('ai')->info('name');

#初始化对话框引擎
$dialog=onez('dialog')->init();

#附加css样式
$dialog->header_add(onez('ui')->less(dirname(__FILE__).'/less/style.less'));

$dialog->header();
?>

<div class="onez-dialog">
  <!--对话框顶部，永远在最底-->
  <header></header>
  <section>
    <!--左侧，显示系统信息-->
    <aside class="onez-left system-info">
      <div class="myinfo">
        <img src="<?=onez('ai')->info('avatar')?>" alt="<?=onez('ai')->info('name')?>" class="img-circle">
        <h3><?=onez('ai')->info('name')?></h3>
      </div>
      <div class="myinfo-summary onez-auto">
        <p><?=onez('ai')->info('myinfo')?></p>
      </div>
    </aside>
    <!--聊天主窗口-->
    <div class="onez-body system-main">
      <!--提示区-->
      <div class="onez-tip"></div>
      <!--内容显示区-->
      <div class="onez-auto" id="showbox"></div>
      <!--工具条-->
      <div class="onez-toolbar" id="toolbar"></div>
      <!--输入区-->
      <div class="onez-inputbox">
        <textarea id="inputbox"></textarea>
      </div>
      <!--输入区-->
      <div class="onez-btns">
        <div class="pull-left">
          
        </div>
        <div class="pull-right">
          <button type="button" class="btn btn-primary" id="sendbtn">发送</button>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
    <!--联想展示区域-->
    <aside class="onez-right system-help"></aside>
  </section>
  <!--对话框底部，永远在最底-->
  <footer>
    <p class="intro">
      技术支持：<a href="http://www.onez.cn/" target="_blank">佳蓝科技</a> &nbsp; 
      基于<a href="http://xl.onez.cn/" target="_blank">onezphp</a>框架开发 &nbsp; 
      技术交流群：185490966 <a href="http://shang.qq.com/wpa/qunwpa?idkey=f7860dfb3e265264f9f359285de578f4fede15f6e8ef183614cdd11645922463" title="佳蓝人工智能开源框架" target="_blank"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="佳蓝人工智能开源框架"></a> &nbsp; 
      <a href="http://ai.bbs.onez.cn/" target="_blank">论坛交流</a> &nbsp; 
    </p>
  </footer>
</div>
<?
onez('onezjs')->init();
onez('ai')->js();
$dialog->footer();#显示底部?>