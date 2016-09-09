<?php

/* ========================================================================
 * $Id: database_mysql.php 8829 2016-09-05 10:09:31Z onez $
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

 class database_mysql{
	var $version;
	var $link;
	var $info;
  function database_mysql($info){
  	$this->info=$info;
		if(empty($info['pconnect'])){
      $this->link=@mysql_connect($info['dbhost'], $info['dbuser'], $info['dbpass'],1);
		}else{
      $this->link=@mysql_pconnect($info['dbhost'], $info['dbuser'], $info['dbpass']);
		}
		if(!$this->link) {
      exit('连接MySQL数据库失败，请检查账号和密码');
			return false;
		} else {
			if(!@mysql_select_db($info['dbname'], $this->link)){
        @mysql_query('CREATE DATABASE IF NOT EXISTS '.$info['dbname'].' DEFAULT CHARSET '.$info['dbcharset'].' COLLATE '.$info['dbcharset'].'_general_ci;', $this->link);
        mysql_select_db($info['dbname'], $this->link);
      };
			$info['dbcharset'] && @$this->query('set names '.$info['dbcharset']);
		}
    register_shutdown_function(array(&$this, 'close'));
  }
  
  function close(){
    mysql_close($this->link);
  }
  
	function version() {
		if(empty($this->version)) {
			$this->version = mysql_get_server_info($this->link);
		}
		return $this->version;
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	function errno() {
		return (($this->link) ? mysql_errno($this->link) : mysql_errno());
	}
  
  function query($sql,$type='') {
    global $G;
    $time1=microtime(true);
    $sql=str_replace(' onez_onezonez_',' onezonez_',$sql);
    $sql=str_replace(' #_',' '.$this->info['tablepre'],$sql);
    $sql=str_replace(' `#_',' `'.$this->info['tablepre'],$sql);
    $sql=str_replace(' onez_',' '.$this->info['tablepre'],$sql);
    $sql=str_replace(' `onez_',' `'.$this->info['tablepre'],$sql);
    $sql=str_replace(' onezonez_',' onez_',$sql);
    $query=@mysql_query($sql, $this->link);
    $time2=microtime(true);
    $G['sql_query'][]='['.($time2-$time1).']'.$sql;
    
		if(!$query){
      if(function_exists('query_callback')){
        return query_callback($sql,$this->errno(),$this->error());
      }
      exit($this->errno().'['.$this->error().']'.$sql);
    }
		return $query;
  }
	function free_result($query) {
		return @mysql_free_result($query);
	}
  
  function getFields($table) {
    $fields=array();
    $result=$this->query("SHOW FIELDS FROM onez_$table");
    while ($key = $this->fetch_array($result)) {
      $fields[]=$key['Field'];
    }
    return $fields;
  }
  function fetch_array($sql) {
    return mysql_fetch_array($sql,MYSQL_ASSOC);
  }
	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}
  
  function rows($table,$vars="",$field='*'){
    if($vars){
      $vars = "where $vars";
    }
    $result=$this->query("select count($field) as id from onez_$table $vars");
    if(!$result)return 0;
    $rs=$this->fetch_array($result);
    return $rs['id'];
  }
  
  function checkKey($key){
    if(in_array($key,array('force','field','type','name'))){
      $key='`'.$key.'`';
    }
    return $key;
  }
  function insert($table,$arr) {
    $A=array();
    foreach($arr as $k=>$v){
      $v=var_export((string)$v,true);
			$A[]="`$k`=$v";
    }
    $query=$this->query("insert into onez_$table set ".implode(',',$A));
    return $this->insert_id();
  }
  function replace($table,$arr) {
    $A=array();
    foreach($arr as $k=>$v){
      $v=var_export((string)$v,true);
			$A[]="`$k`=$v";
    }
    $query=$this->query("replace into onez_$table set ".implode(',',$A));
    return $query;
  }
  function update($table,$arr,$vars) {
    if($vars){
      $vars = "where $vars";
    }
    $A=array();
    foreach($arr as $k=>$v){
      $v=var_export((string)$v,true);
			$A[]="`$k`=$v";
    }
    $query=$this->query("update onez_$table set ".implode(',',$A)." $vars");
    return $query;
  }
  function delete($table,$vars) {
    if($vars){
      $vars = "where $vars";
    }
    $query=$this->query("delete from onez_$table $vars");
  }
  function select($table,$key,$vars=""){
    if($vars){
      $vars = "where $vars";
    }
    $result=$this->query("select $key from onez_$table $vars");
    if(!$result){
      return false;
    }else{
      $rs=$this->fetch_array($result);
			$this->free_result($result);
      return $rs[$key];
    }
  }
  function one($table,$key,$vars=""){
    if($vars){
      $vars = "where $vars";
    }
    $result=$this->query("select $key from onez_$table $vars limit 1");
    if(!$result){
      return array();
    }else{
      $rs=$this->fetch_array($result);
			$this->free_result($result);
      return $rs;
    }
  }
  function autoindex($table){
    $result=mysql_query("SHOW TABLE STATUS LIKE 'onez_$table'");
    if(!$result){
      return false;
    }else{
      $rs=mysql_fetch_array($result);
			$this->free_result($result);
      return $rs['Auto_increment'];
    }
  }
  function record($table,$key,$vars="",$limit=""){
    if($vars){
      $vars = "where $vars";
    }
    if($limit){
      $limit = "limit $limit";
    }
    $k=explode(",",$key);
    $record = Array();
    $result=$this->query("select $key from onez_$table $vars $limit");
    $j=0;
    if(!$result){
      return $record;
    }
    while($onez=$this->fetch_array($result)){
      $record[$j]=$onez;
      $j++;
    }
		$this->free_result($result);
    return $record;
  }
	function sql($table) {
	  $res = mysql_query( "SHOW CREATE TABLE `onez_$table`" );
		$row = mysql_fetch_row( $res ); 
	  return $row[1];
	}
	function createtable($sql) {
		$type = strtoupper(preg_replace("/^\s*CREATE TABLE IF NOT EXISTS\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
		$type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
		return preg_replace("/^\s*(CREATE TABLE IF NOT EXISTS\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
			(mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT charset=utf8" : " TYPE=$type");
	}
	function runquery($sql) {
		$A = $ret = array();
		$num = 0;
		foreach(explode(";\n", trim($sql)) as $Query) {
			$queries = explode("\n", trim($Query));
			foreach($queries as $query) {
				$ret[$num] .= $query[0] == '#' || $query[0].$query[1] == '--' ? '' : $query;
			}
			$num++;
		}
		unset($sql);
		foreach($ret as $query) {
			$query = trim($query);
			if($query) {
				if(substr($query, 0, 12) == 'CREATE TABLE') {
					$name = preg_replace("/CREATE TABLE IF NOT EXISTS ([a-z0-9_]+) .*/is", "\\1", $query);
					$A[]=$this->createtable($query);
				} else {
					$A[]=$query;
				}
			}
		}
    foreach($A as $line){
      $this->query($line);
    }
		return $A;
	}
  function page($sql,$totalput=false,$maxperpage=20){
    global $PHP_SELF;
    $thispage=max(intval(onez()->gp('page')),1);
    $result=$this->query($sql);
    if($totalput===false){
      $totalput=mysql_num_rows($result);
    }
    if (($totalput %$maxperpage)==0){
      $PageCount=intval($totalput /$maxperpage);
    }else{
      $PageCount=intval($totalput /$maxperpage+1);
    } 
    $PageCount<1 && $PageCount=1;
    $thispage>$PageCount && $thispage=$PageCount;
    $sql="$sql limit ".(($thispage-1)*$maxperpage).",$maxperpage";
    
    $result=$this->query($sql);
    $record = Array();
    while($onez=$this->fetch_array($result)){
      $record[]=$onez;
    }
    $ms="";unset($A,$B);
    unset($_GET['page']);
    $strs=http_build_query($_GET);
    $strs=$strs ? $PHP_SELF.'?'.$strs.'&page=*' : $PHP_SELF.'?page=*';
    if(function_exists('pageinfo')){
      return array($record,pageinfo($strs,$PageCount,$thispage));
    }
    if($strs && $PageCount>1){
      $buffer = null;
      $index = '首页';
      $pre = '上一页';
      $next = '下一页';
      $last = '末页';
  
      if ($PageCount<=7) { 
        $range = range(1,$PageCount);
      } else {
        $min = $thispage - 3;
        $max = $thispage + 3;
        if ($min < 1) {
          $max += (3-$min);
          $min = 1;
        }
        if ( $max > $PageCount ) {
          $min -= ( $max - $PageCount );
          $max = $PageCount;
        }
        $min = ($min>1) ? $min : 1;
        $range = range($min, $max);
      }
      
      if ($thispage > 1) {
        $buffer .= "<li><a href='".str_replace('*',1,$strs)."'>{$index}</a></li> <li><a href='".str_replace('*',$thispage-1,$strs)."' class='prev'>{$pre}</a></li>";
      }
      foreach($range AS $one) {
        if ( $one == $thispage ) {
          $buffer .= "<li><a class='current'>{$one}</a></li>";
        } else {
          $buffer .= "<li><a href='".str_replace('*',$one,$strs)."'>{$one}</a></li>";
        }
      }
      if ($thispage < $PageCount) {
        $buffer .= "<li><a href='".str_replace('*',$thispage+1,$strs)."' class='nxt'>{$next}</a></li> <li><a href='".str_replace('*',$PageCount,$strs)."'>{$last}</a></li>";
      }
      $page='<ul class="pagination">'.$buffer . '</ul>';
		}
    return array($record,$page,$totalput);
  }
}
?>