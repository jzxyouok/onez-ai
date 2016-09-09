<?php

/* ========================================================================
 * $Id: index.php 3551 2016-09-06 18:05:52Z onez $
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
$G['title']='应答规则分类管理';
define('CUR_URL','/rules_group/index.php');


include(dirname(__FILE__).'/rules.inc.php');


$action=onez()->gp('action');
if($action=='delete'){
  $id=(int)onez()->gp('id');
  onez('db')->open('rules_group')->delete("groupid='$id'");
  onez()->ok('删除分类成功','reload');
}
$record=onez('db')->open('rules_group')->page("");
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
    <a href="<?php echo onez()->href('/rules_group/edit.php')?>" class="btn btn-success">
      添加新分类
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
              分类名称
            </th>
            <th>
              触发方式
            </th>
            <th>
              详细规则
            </th>
            <th>
              负责人
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
            <td><?
            $mytags=explode(',',$rs['tags']);
            $tags='';
            foreach($mytags as $tag){
              $tags.='<span class="btn btn-xs btn-info">'.$tag.'</span>';
            }
            echo str_replace('*',$tags,$options_typename[$rs['type']]);
            ?>
            </td>
            <td>
              <?php
              $n=onez('db')->open('rules')->rows("groupid='$rs[groupid]'");
              ?>
              共<code><?=$n?></code>条 
              
              <a href="<?php echo onez()->href('/rules/index.php?groupid='.$rs['groupid'])?>" class="btn btn-xs btn-primary">
                管理
              </a>
            </td>
            <td>
              <?php
              if($rs['workers']){
                $T=onez('db')->open('workers')->record("workerid in ($rs[workers])");
                $W=array();
                foreach($T as $r){
                  $W[]=$r['username'];
                }
                echo implode(', ',$W);
              }else{
                echo '<span>没有指定负责人</span>';
              }
              ?>
            </td>
            <td>
              <a href="<?php echo onez()->href('/rules_group/edit.php?id='.$rs['groupid'])?>" class="btn btn-xs btn-success">
                编辑
              </a>
              <a href="javascript:void(0)" onclick="onez.del('<?php echo $rs['groupid'];?>')" class="btn btn-xs btn-danger">
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