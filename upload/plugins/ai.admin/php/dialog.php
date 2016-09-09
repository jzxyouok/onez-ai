<?php

/* ========================================================================
 * $Id: dialog.php 4353 2016-09-09 05:04:02Z onez $
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

onez('ai')->init($this);

#初始化对话框引擎
$dialog=onez('dialog')->init();

#附加css样式
$dialog->header_add(onez('ui')->less(dirname(__FILE__).'/less/style.less'));

$dialog->header();

//图标动画
onez('animate.css')->init();
onez('jqueryui')->head();
onez('event')->load('miniwin')->args();
?>

<div class="onez-dialog">
  <!--对话框顶部，永远在最底-->
  <header>
    
  </header>
  <section>
    <!--左侧，显示系统信息-->
    <aside class="onez-left system-info">
      <dt>在线用户</dt>
      <dd class="onez-auto" id="userlist"></dd>
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
          <input type="checkbox" id="asrule" checked /> 保存为规则，下次同样的消息自动回复此内容
        </div>
        <div class="pull-right">
          <button type="button" class="btn btn-sm btn-success" id="sendbtn">发送</button>
          <button type="button" class="btn btn-sm btn-danger" onclick="onez.ai.close()">关闭</button>
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-primary" onclick="onez.ai.doit_reset();_doit_addtag()">增加标签</button>
            <button type="button" class="btn btn-sm btn-primary" onclick="onez.ai.doit_reset();_doit_removetag()">移除标签</button>
            <button type="button" class="btn btn-sm btn-primary" onclick="onez.ai.doit_reset();_doit_setattr()">修改属性</button>
            <button type="button" class="btn btn-sm btn-primary" onclick="onez.ai.doit_reset();_doit_script()">执行脚本</button>
            <button type="button" class="btn btn-sm btn-primary" onclick="onez.ai.doit_reset();_doit_output()">自定义回复</button>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
    <!--功能展示区域-->
    <aside class="onez-right system-help">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#moreinfo" role="tab" data-toggle="tab">目标信息</a></li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content onez-auto">
        <div role="tabpanel" class="tab-pane active" id="moreinfo"></div>
      </div>
    </aside>
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

<div class="modal fade" id="hide-miniwin" style="display: none">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        </button>
        <h4 class="modal-title">系统提示</h4>
      </div>
      <div class="modal-body"><iframe id="NoPermissioniframe" width="100%" height="100%" frameborder="0" ></iframe></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function closeWin(){
  $("#hide-miniwin").modal('hide');
}
</script>
<?
echo onez('ai.admin')->doit(array('is_dialog'=>1));
onez('onezjs')->init();
onez('ai')->js();
$dialog->footer();#显示底部?>