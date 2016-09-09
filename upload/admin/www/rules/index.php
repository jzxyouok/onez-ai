<?php

/* ========================================================================
 * $Id: index.php 3064 2016-09-07 13:28:20Z onez $
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
$G['title']='应答规则管理';
define('CUR_URL','/rules_group/index.php');

$groupid=(int)onez()->gp('groupid');
$group=onez('db')->open('rules_group')->one("groupid='$groupid'");

$action=onez()->gp('action');
if($action=='delete'){
  $id=(int)onez()->gp('id');
  onez('db')->open('rules')->delete("ruleid='$id'");
  onez()->ok('删除规则成功','reload');
}
$record=onez('db')->open('rules')->page("groupid='$groupid' order by step,ruleid");
onez('admin')->header();

?>
<section class="content-header">
  <h1>
    <?=$G['title']?> <small>分类:<?=$group['subject']?></small>
  </h1>
  <ol class="breadcrumb">
    <li>
      <a href="<?php echo onez()->href('/')?>">
        <i class="fa fa-dashboard">
        </i>
        管理首页
      </a>
    </li>
    <li>
      <a href="<?php echo onez()->href('/rules_group/index.php')?>">
        <i class="fa fa-dashboard">
        </i>
        <?=$group['subject']?>
      </a>
    </li>
    <li class="active">
      <?=$G['title']?>
    </li>
  </ol>
</section>
<section class="content">
  <div class="btns" style="padding-bottom: 10px">
    <a href="<?php echo onez()->href('/rules/add_device.php?groupid='.$groupid)?>" class="btn btn-success">
      高级录入
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
              端终
            </th>
            <th>
              输入类型
            </th>
            <th>
              操作员
            </th>
            <th>
              规则描述
            </th>
            <th>
              操作
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($record[0] as $rs){
            
$device=onez('db')->open('devices')->one("deviceid='$rs[deviceid]'");
            ?>
          <tr>
            <td>
              <?php echo $device['subject'];?>
            </td>
            <td>
              <?php echo $rs['input_typename'];?>
            </td>
            <td>
              <?php echo $rs['add_info'];?>
            </td>
            <td>
              <?php echo $rs['summary'];?>
            </td>
            <td>
              <a href="<?php echo onez()->href('/rules/add_design.php?id='.$rs['ruleid'])?>" class="btn btn-xs btn-success">
                编辑
              </a>
              <a href="javascript:void(0)" onclick="onez.del('<?php echo $rs['ruleid'];?>')" class="btn btn-xs btn-danger">
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