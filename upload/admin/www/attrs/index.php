<?php

/* ========================================================================
 * $Id: index.php 2312 2016-09-06 17:50:44Z onez $
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
$G['title']='智能属性管理';
define('CUR_URL','/attrs/index.php');
$action=onez()->gp('action');
if($action=='delete'){
  $id=(int)onez()->gp('id');
  onez('db')->open('attrs')->delete("attrid='$id'");
  onez()->ok('删除属性成功','reload');
}
$record=onez('db')->open('attrs')->page("");
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
      <?=$G['title']?>
    </li>
  </ol>
</section>
<section class="content">
  <div class="btns" style="padding-bottom: 10px">
    <a href="<?php echo onez()->href('/attrs/edit.php')?>" class="btn btn-success">
      添加新属性
    </a>
  </div>
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">
        <?=$G['title']?>
      </h3>
      <div class="box-tools pull-right">
      </div>
    </div>
    <div class="box-body  table-responsive no-padding">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>
              属性名称
            </th>
            <th>
              数据类型
            </th>
            <th>
              操作
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($record[0] as $rs){?>
          <tr>
            <td>
              <?php echo $rs['subject'];?>
            </td>
            <td>
              <?php echo onez('form.plugin.child')->name($rs['type']);?>
            </td>
            <td>
              <a href="<?php echo onez()->href('/attrs/edit.php?id='.$rs['attrid'])?>" class="btn btn-xs btn-success">
                编辑
              </a>
              <a href="javascript:void(0)" onclick="onez.del('<?php echo $rs['attrid'];?>')" class="btn btn-xs btn-danger">
                删除
              </a>
            </td>
          </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
    <?if($record[1]){?>
    <div class="box-footer clearfix">
      <?php echo $record[1];?>
    </div>
    <?}?>
  </div>
</section>
<?php
onez('admin')->footer();
?>