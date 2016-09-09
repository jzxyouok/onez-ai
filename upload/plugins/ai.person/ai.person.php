<?php

/* ========================================================================
 * $Id: ai.person.php 2873 2016-09-09 03:48:24Z onez $
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
class onezphp_ai_person extends onezphp{
  var $persons=array();
  var $person=array();
  var $info=array();
  var $cls;
  function __construct(){
    
  }
  function init($id){
    if(is_array($id)){
      $T=$id;
      $id=$T['id'];
      if($this->persons[$id]){
        return $this->persons[$id];
      }
    }else{
      if($this->persons[$id]){
        return $this->persons[$id];
      }
      $T=onez('db')->open('person')->one("id='$id' or udid='$id'");
    }
    if(!$T){
      return $this;
    }
    $person=new onezphp_ai_person();
    $person->cls=$this;
    $person->create($T);
    $this->persons[$id]=$person;
    return $person;
  }
  function create($person){
    $this->person=$person;
    $this->udid=$person['udid'];
    $this->id=$person['id'];
    $this->info=unserialize($person['lastinfo']);
    //标签
    
    #目标的标签
    $this->info['tags']=array();
    $T=onez('db')->open('person_tags')->record("udid='$person[udid]'");
    foreach($T as $rs){
      $this->info['tags'][]=$rs['tagname'];
    }
    
    //属性
    $T=onez('db')->open('person_attrs')->record("udid='{$person['udid']}'");
    foreach($T as $rs){
      $this->info($rs['attrkey'],unserialize($rs['value']));
    }
    //设备
    $T=onez('db')->open('devices')->one("deviceid='{$person['deviceid']}'");
    if($T){
      list($dtoken)=explode('|',$T['device_token']);
      $this->info('device',onez($dtoken));
    }
    return $this;
  }
  function info($key,$value=false){
    if($value===false){
      $value=$this->info[$key];
      if($key=='avatar'||$key=='头像'){
        !$value && $value=$this->info('device')->avatar();
        !$value && $value=$this->cls->url.'/images/avatar.png';
      }elseif($key=='nickname'||$key=='昵称'){
        !$value && $value='PERSON'.$this->person['id'];
      }
      return $value;
    }else{
      $this->info[$key]=$value;
      return $this;
    }
  }
  
  function attrs_set($key,$value){
    if(!$key){
      return $this;
    }
    $value=serialize($value);
    $udid=$this->udid;
    $onez=array();
    $T=onez('db')->open('person_attrs')->one("udid='$udid' and attrkey='$key'");
    if($T){
      $onez['value']=$value;
      $onez['time']=time();
      onez('db')->open('person_attrs')->update($onez,"id='$T[id]'");
    }else{
      $onez['udid']=$udid;
      $onez['attrkey']=$key;
      $onez['value']=$value;
      $onez['time']=time();
      onez('db')->open('person_attrs')->insert($onez);
    }
    return $this;
  }
  //给目标移除一个标签
  function attrs_remove($key){
    if(!$key){
      return $this;
    }
    $udid=$this->udid;
    $T=onez('db')->open('person_attrs')->one("udid='$udid' and attrkey='$key'");
    if(!$T){
      return $this;
    }
    onez('db')->open('person_attrs')->delete("id='$T[id]'");
    return $this;
  }
}