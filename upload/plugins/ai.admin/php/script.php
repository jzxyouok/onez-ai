<?php

/* ========================================================================
 * $Id: script.php 1915 2016-09-07 11:40:46Z onez $
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
$G['title']='请选择您要为目标执行的脚本';
$page=(int)onez()->gp('page');
$plugins=onez('api')->request('plugins',array('tagname'=>'ai.script','kw'=>$kw,'page'=>$page,));
onez('admin')->header();
$record=array($plugins['plugins'],$plugins['pageinfo']);
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
              脚本名称
            </th>
            <th>
              脚本描述
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($record[0] as $rs){?>
          <tr>
            <td>
              <a href="<?=$this->view('script_detail&script='.$rs['ptoken'].'&name='.urlencode($rs['pname']))?>" class="btn btn-xs btn-info">
                选择
              </a>
            </td>
            <td>
              <?php echo $rs['pname'];?>
            </td>
            <td>
              <?php echo $rs['summary'];?>
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