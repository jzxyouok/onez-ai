<?php

/* ========================================================================
 * $Id: index.php 2441 2016-09-06 17:39:30Z onez $
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
$G['title']='智能标签管理';
define('CUR_URL','/tags/index.php');
$action=onez()->gp('action');
if($action=='delete'){
  $id=(int)onez()->gp('id');
  onez('db')->open('tags')->delete("tagid='$id'");
  onez()->ok('删除标签成功','reload');
}
$record=onez('db')->open('tags')->page("1 order by level desc");
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
    <a href="<?php echo onez()->href('/tags/edit.php')?>" class="btn btn-success">
      添加新标签
    </a>
  </div>
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">
        <?=$G['title']?>
      </h3>
      <div class="box-tools pull-right">
        <small>
          <a href="http://ai.bbs.onez.cn/forum.php?mod=viewthread&tid=1" target="_blank">什么是智能标签？</a>
        </small>
      </div>
    </div>
    <div class="box-body  table-responsive no-padding">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>
              标签名称
            </th>
            <th>
              优先级
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
              <?php echo $rs['tagname'];?>
            </td>
            <td>
              <?php echo $rs['level'];?>
            </td>
            <td>
              <a href="<?php echo onez()->href('/tags/edit.php?id='.$rs['tagid'])?>" class="btn btn-xs btn-success">
                编辑
              </a>
              <a href="javascript:void(0)" onclick="onez.del('<?php echo $rs['tagid'];?>')" class="btn btn-xs btn-danger">
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