<?php

/* ========================================================================
 * $Id: setattr.php 2081 2016-09-08 15:42:32Z onez $
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
$G['title']='请选择您要为目标修改的属性';
$record=onez('db')->open('attrs')->page("1");
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
            <th width="60">
              操作
            </th>
            <th>
              属性名称
            </th>
            <th>
              属性类型
            </th>
            <?if($person){?>
            <th>
              当前值
            </th>
            <?}?>
          </tr>
        </thead>
        <tbody>
          <?php foreach($record[0] as $rs){?>
          <tr>
            <td>
              <a href="<?=$this->view('setattr_detail&deviceid='.$deviceid.'&personid='.$personid.'&attrid='.$rs['attrid'])?>" class="btn btn-xs btn-info">
                选择
              </a>
            </td>
            <td>
              <?php echo $rs['subject'];?>
            </td>
            <td>
              <?php echo onez('form.plugin.child')->name($rs['type']);?>
            </td>
            <?if($person){?>
            <td>
              <code><?php echo $person->info($rs['subject']);?></code>
            </td>
            <?}?>
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