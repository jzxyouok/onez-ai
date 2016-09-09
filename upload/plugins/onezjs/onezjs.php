<?php

/* ========================================================================
 * $Id: onezjs.php 403 2016-09-05 07:33:32Z onez $
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
class onezphp_onezjs extends onezphp{
  function __construct(){
    
  }
  function init(){
    if($this->times(1)){
      echo '<script src="'.$this->url.'/js/onez.js"></script>';
      $resList=array(
        'jquery'=>onez('jquery')->js(),
      );
      echo '<script>onez.resList='.json_encode($resList).'</script>';
    }
    return $this;
  }
}