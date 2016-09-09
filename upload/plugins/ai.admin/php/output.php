<?php

/* ========================================================================
 * $Id: output.php 1574 2016-09-08 15:43:56Z onez $
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
$G['title']='输出一条数据';

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
              数据类型
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
          $record=onez($dtoken)->output_types();
          foreach($record as $k=>$rs){?>
          <tr>
            <td>
              <a href="<?=$this->view('output_detail&deviceid='.$deviceid.'&personid='.$personid.'&output_type='.$rs['type'].'&output_typename='.urlencode($rs['name']))?>" class="btn btn-xs btn-info">
                选择
              </a>
            </td>
            <td>
              <?php echo $rs['name'];?>
            </td>
          </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php
onez('admin')->footer();
?>