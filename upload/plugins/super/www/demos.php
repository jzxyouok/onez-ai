<?php

/* ========================================================================
 * $Id: demos.php 1094 2016-09-02 10:52:36Z onez $
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
$G['title']='本站可查看演示的扩展';

define('CUR_URL',onez('super')->www('/demos.php'));

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
<div class="row">
  <div class="col-lg-12">
  
<table class="table">
	<thead>
  	<tr>
  		<th>扩展名称</th>
  		<th>操作</th>
  	</tr>
	</thead>
	<tbody>
<?
foreach(_get_all_plugins() as $ptoken){
  if(method_exists(onez($ptoken),'demo')){
    
?>
  	<tr>
  		<td><?=$ptoken?></td>
  		<td><a href="<?=onez($ptoken)->view('demo')?>" target="_blank" class="btn btn-xs btn-success">查看演示</a></td>
  	</tr>
<?
  }
}?>
	</tbody>
</table>
  
  </div>
</div>
</section>
<?
onez('admin')->footer();