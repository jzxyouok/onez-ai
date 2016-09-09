<?php

/* ========================================================================
 * $Id: removetag.php 2695 2016-09-08 14:59:12Z onez $
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
$G['title']='请选择您要为目标移除的标签';
$action=onez()->gp('action');
if($action=='removetag'){
  $tagname=onez()->gp('tagname');
  onez('ai')->tags_remove($person->udid,$tagname);
  onez()->output(array('status'=>'success'));
}
$record=onez('db')->open('tags')->record("");
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
              标签名称
            </th>
            <th>
              标签描述
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($record as $rs){?>
          <tr>
            <td>
            <?if($person){
              if(!in_array($rs['tagname'],$person->info('tags'))){
                continue;
              }
              ?>
                <a href="javascript:void(0)" onclick="_remove_tag('<?=$rs['tagname']?>')" class="btn btn-xs btn-info">
                  移除
                </a>
            <?}else{?>
              <a href="javascript:void(0)" onclick="<?=$this->click_add(array('type'=>'removetag','tagid'=>$rs['tagid'],'text'=>'移除标签<code>'.$rs['tagname'].'</code>','tagname'=>$rs['tagname']))?>" class="btn btn-xs btn-info">
                选择
              </a>
            <?}?>
            </td>
            <td>
              <?php echo $rs['tagname'];?>
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
<script type="text/javascript">
function _remove_tag(tagname){
  $.post(window.location.href,{action:'removetag',tagname:tagname},function(data){
    if(data.status=='success'){
      parent._doit_add(data);
    }else{
      onez.alert(data.error);
    }
  },'json');
}
</script>
<?php
onez('admin')->footer();
?>