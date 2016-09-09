<?php

/* ========================================================================
 * $Id: mysql.dbtables.php 4097 2016-09-09 05:50:02Z onez $
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
class onezphp_mysql_dbtables extends onezphp{
  function __construct(){
    
  }
  function code(){
    $tables=$this->read();
    $html[]='<?php';
    $html[]="!defined('IN_ONEZ') && exit('Access Denied');";
    $html[]='$dbtables=array();';
    
    foreach($tables as $tablename=>$table){
      $html[]='';
      $html[]='#'.$table['fullname'];
      $html[]='$dbtables[\''.$tablename.'\']=array(';
      $html[]="  'idname'=>'$table[idname]',";
      $html[]="  'fields'=>array(";
      foreach($table['fields'] as $k=>$v){
        $html[]="    array (";
        $html[]="      'fieldname' => '$v[fieldname]',";
        $html[]="      'fieldtype' => '$v[fieldtype]',";
        $html[]="      'mylen' => '$v[mylen]',";
        $html[]="      'summary' => '$v[summary]',";
        $html[]="      'is_index' => '$v[is_index]',";
        $html[]="      'is_only' => '$v[is_only]',";
        $html[]="    ),";
      }
      $html[]="  ),";
      
      
      if($tablename=='admin'){
        $html[]="  'defaults'=>array(
    array (
      'username' => 'admin',
      'password' => md5('admin'),
    ),
  ),
  'summary_create'=>'默认管理账号和密码都是<code>admin</code>',";
      }
      $html[]=');';
      
    }
    $html[]='return $dbtables;';
    return implode("\n",$html);
  }
  function read($info=array()){
    !$info && $info=array(
      'dbhost'=>onez('cache')->option('dbhost'),
      'dbuser'=>onez('cache')->option('dbuser'),
      'dbpass'=>onez('cache')->option('dbpass'),
      'dbname'=>onez('cache')->option('dbname'),
      'dbcharset'=>onez('cache')->option('dbcharset'),
      'tablepre'=>onez('cache')->option('tablepre',0),
      'pconnect'=>1,
    );
    $link=@mysql_connect($info['dbhost'], $info['dbuser'], $info['dbpass'],1);
    !$link && onez('showmessage')->error('请检查您的数据库账号是否正确');
		if(!@mysql_select_db($info['dbname'], $link)){
      onez('showmessage')->error('数据库名不存在，或者您的账号没有操作此数据库的权限');
    };
    mysql_query('set names '.$info['dbcharset'],$link);
    
    
    $dbname=$info['dbname'];
    $tbl=$info['tablepre'];
    $rs = mysql_query("SHOW TABLES FROM $dbname",$link); 
    $tables = array(); 
    while ($row = mysql_fetch_row($rs)) {
      $table=array();
      $tablename=$row[0];
      $table['fullname']=$tablename;
      $rescolumns = mysql_query("SHOW FULL COLUMNS FROM $tablename",$link) ;
      while($row = mysql_fetch_array($rescolumns,MYSQL_ASSOC)){
        $field=array();
        $field['fieldname']=$row['Field'];
        $field['summary']=$row['Comment'];
        $type=$row['Type'];
        if(preg_match('/int\(([0-9]+)\)/i',$type,$mat)){
          $field['fieldtype']='int';
          $field['mylen']=(int)$mat[1];
          !$field['mylen'] && $field['mylen']=11;
        }elseif(preg_match('/float\(([0-9]+),([0-9]+)\)/i',$type,$mat)){
          switch($mat[2]){
            case '2':
              $field['fieldtype']='amt';
              break;
            default:
              $field['fieldtype']='addr';
              $field['mylen']=$mat[1];
              !$field['mylen'] && $field['mylen']='11,6';
              break;
          }
        }elseif(preg_match('/varchar\(([0-9]+)\)/i',$type,$mat)){
          $field['fieldtype']='text';
          $field['mylen']=$mat[1];
          !$field['mylen'] && $field['mylen']='120';
        }elseif(preg_match('/longtext/i',$type,$mat)){
          $field['fieldtype']='long';
        }
        $Extra=$row['Extra'];
        if($Extra=='auto_increment'){
          $table['idname']=$field['fieldname'];
          continue;
        }
        if($row['Key']=='MUL'){
          $field['is_index']=1;
        }
        $table['fields'][$row['Field']]=$field;
      }
      
      if(strpos($tablename,$tbl)===0){
        $tablename=substr($tablename,strlen($tbl));
      }
      $table['subject']=$tablename;
      $table['tablename']=$tablename;
      $tables[$tablename] = $table; 
    } 
    mysql_free_result($rs);
    return $tables;
  }
}