<?php

/* ========================================================================
 * $Id: options.php 1932 2016-09-09 05:27:50Z onez $
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
define('CUR_URL',onez('super')->www('/options.php'));

$G['title']='网站参数设置';
$btnname='保存修改';
$item=onez('cache')->get('options');

#初始化表单
$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;
$Menu=onez('admin')->menu;
$_options_keys=array();
#创建表单项
$form->add(array('type'=>'hidden','key'=>'action','value'=>'save'));
foreach(_get_all_plugins() as $ptoken){
  if(method_exists(onez($ptoken),'options')){
    $options=onez($ptoken)->options();
    if($options){
      foreach($options as $k=>$v){
        if(in_array($k,$_options_keys)){
          continue;
        }
        $_options_keys[]=$k;
        $form->add($v);
      }
    }
  }
}
onez('admin')->menu=$Menu;


#处理提交
if($onez=$form->submit()){
  onez('cache')->option_set($onez);
  onez()->ok('操作成功','reload');
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
          <?=$G['title']?>
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
      </div>
    </div>
    <input type="hidden" name="action" value="save" />
  </form>
</section>
<?php
echo $form->js();
onez('admin')->footer();
?>