<?php

/* ========================================================================
 * $Id: super.php 933 2016-09-05 15:50:44Z onez $
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
class onezphp_super extends onezphp{
  function __construct(){
  }
  function init(){
  }
  function options(){
    $options=array();
    $options['onez_appid_help']=array('label'=>'佳蓝通信密钥说明','type'=>'html','html'=>'<code>用于快速获取云端扩展，实现更多更强大的功能。申请地址：<a href="http://xl.onez.cn/" target="_blank">点此申请</a><span class="text-gray">(注册后自动分配)</span></code>');
    $options['onez_appid']=array('label'=>'ONEZ_APPID','type'=>'text','key'=>'onez_appid','hint'=>'','notempty'=>'');
    $options['onez_appkey']=array('label'=>'ONEZ_APPKEY','type'=>'text','key'=>'onez_appkey','hint'=>'','notempty'=>'');
    return $options;
  }
  
  function plugin_href($token,$href){
    $href=str_replace('?','&',$href);
    return onez('super')->www('/plugin.php?_token='.urlencode($token).'&_href='.$href);
  }
}