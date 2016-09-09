<?php

/* ========================================================================
 * $Id: dbtables.php 4544 2016-09-09 05:50:30Z onez $
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
define('CUR_URL',onez('super')->www('/dbtables.php'));

$G['title']='数据表安装与升级';
$btnname='一键更新';

#初始化表单
$form=onez('admin')->widget('form')
  ->set('title',$G['title'])
  ->set('values',$item)
;

$current=onez('mysql.dbtables')->read();
//exit($current=onez('mysql.dbtables')->code());
$DBTables=array();
#系统自带表
$sysFile=ONEZ_ROOT.'/config/dbtables.php';
if(file_exists($sysFile)){
  $dbtables=include($sysFile);
  if($dbtables){
    $DBTables[]=array(
      'group'=>'系统自带',
      'dbtables'=>$dbtables,
    );
  }
}

$sqls=array();
#处理提交
$action=onez()->gp('action');
if($action=='save'){
  $sqls=onez()->stripslashes($_REQUEST['sqls']);
  $sqls=json_decode(base64_decode($sqls),1);
  foreach($sqls as $sql){
    if($sql['type']=='query'){
      onez('db')->db()->query($sql['sql']);
    }elseif($sql['type']=='insert'){
      onez('db')->open($sql['table'])->insert($sql['values']);
    }
  }
  onez()->ok('操作成功','reload');
}
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
  <?if($DBTables){?>
  <form id="form-common" method="post">
    <?foreach($DBTables as $K=>$V){?>
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">
          <?=$V['group']?>
        </h3>
        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
<table class="table">
	<thead>
  	<tr>
  		<th>表名</th>
  		<th>递增字段</th>
  		<th width="500">包含字段</th>
  		<th>记录</th>
  		<!--<th>备注</th>-->
  		<th>分析</th>
  	</tr>
	</thead>
	<tbody>
        <?foreach($V['dbtables'] as $tablename=>$table){?>
  	<tr>
  		<td><?=$tablename?></td>
  		<td><?=$table['idname']?></td>
  		<td><?
      $fields=$fieldNames=array();
      $result='<span class="text-green">正常</span>';
      foreach($table['fields'] as $k=>$v){
        if(!in_array($v['fieldname'],$fields)){
          $fields[]=$v['fieldname'];
          $fieldname=$v['fieldname'];
          if($current[$tablename] && !$current[$tablename]['fields'][$v['fieldname']]){
            $sql=onez('db')->create_field($v);
            $sql && $sqls[]=array(
              'type'=>'query',
              'tablename'=>$tablename,
              'sql'=>'ALTER TABLE `onez_'.$tablename.'` ADD '.$sql,
            );
            $fieldname='<code title="需要追加">'.$fieldname.'</code>';
            $result=str_replace('<span class="text-green">正常</span>','',$result);
            $result && $result.='<br />';
            $result.='<span class="text-red">字段`'.$v['fieldname'].'`不存在，需要追加</span>';
          }
          $fieldNames[]=$fieldname;
        }
      }
      echo implode(', ',$fieldNames);
      
      if(!$current[$tablename]){
        $result='<span class="text-red">表不存在，需要创建</span>';
        if($table['summary_create']){
          $result.='<br /><span class="text-red">'.$table['summary_create'].'</span>';
        }
        $sqls[]=array(
          'type'=>'query',
          'tablename'=>$tablename,
          'sql'=>onez('db')->create_mysql($tablename,$table['idname'],$table['fields']),
        );
        if($table['defaults']){
          foreach($table['defaults'] as $v){
            $sqls[]=array(
              'type'=>'insert',
              'table'=>$tablename,
              'values'=>$v,
            );
          }
        }
      }
      ?></td>
  		<td><code><?
      if(!$current[$tablename]){
        echo '---';
      }else{
        echo onez('db')->open($tablename)->rows('');
      }
      ?></code> 条</td>
  		<!--<td><?=$table['summary']?></td>-->
  		<td><?=$result?></td>
  	</tr>
        <?}?>
	</tbody>
</table>
      </div>
    </div>
    <?}?>
    <?if($sqls){?>
    <button type="submit" class="btn btn-success">一键更新</button>
    <input type="hidden" name="sqls" value=<?=base64_encode(json_encode($sqls))?> />
    <?}?>
    <input type="hidden" name="action" value="save" />
  </form>
  <?}else{?>
  <h2 class="text-red text-center">当前程序未涉及数据表</h2>
  <?}?>
</section>
<?php
echo $form->js();
onez('admin')->footer();
?>