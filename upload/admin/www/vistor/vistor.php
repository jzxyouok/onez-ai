<?php

/* ========================================================================
 * $Id: vistor.php 2705 2016-09-02 11:44:12Z onez $
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
$G['title']='访客管理';
define('CUR_URL','/vistor/vistor.php');
$action=onez()->gp('action');

$record=onez('db')->open('vistor')->page("");
onez('admin')->header();
?>
<section class="content-header">
  <h1>
    访客管理
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
      访客管理
    </li>
  </ol>
</section>
<section class="content">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">
        访客管理
      </h3>
      <div class="box-tools pull-right">
      </div>
    </div>
    <div class="box-body  table-responsive no-padding">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>
              识别码
            </th>
            <th>
              首次访问时间
            </th>
            <th>
              首次访问IP
            </th>
            <th>
              身份
            </th>
            <th>
              国家
            </th>
            <th>
              集货站
            </th>
            <th>
              问题
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
              <?php echo $rs['udid'];?>
            </td>
            <td>
              <?php echo date('Y-m-d H:i:s',$rs['infotime']);?>
            </td>
            <td>
              <?php echo $rs['infoip'];?>
            </td>
            <td>
              <?if($rs['userid']){?>
                <p>会员编号:<?php echo $rs['userid'];?></p>
              <?}?>
              <?if($rs['realname']){?>
                <p>姓名:<?php echo $rs['realname'];?></p>
              <?}?>
              <?if($rs['email']){?>
                <p>信箱:<?php echo $rs['email'];?></p>
              <?}?>
              <?if($rs['mobile']){?>
                <p>手機:<?php echo $rs['mobile'];?></p>
              <?}?>
            </td>
            <td>
              <?php echo $rs['country'];?>
            </td>
            <td>
              <?php echo $rs['shop'];?>
            </td>
            <td>
              <?php echo $rs['question'];?>
            </td>
            <td>
            </td>
          </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
    <div class="box-footer clearfix">
      <?php echo $record[1];?>
    </div>
  </div>
</section>
<?php
onez('admin')->footer();
?>