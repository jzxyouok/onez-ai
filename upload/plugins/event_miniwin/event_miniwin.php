<?php

/* ========================================================================
 * $Id: event_miniwin.php 1375 2016-09-07 09:54:17Z onez $
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
onez('event');
class onezphp_event_miniwin extends onezphp_event{
  function init(){
    global $G;
    $this->eventName='miniwin';
    $G['footer-js'].=<<<ONEZ
function miniwin(url,title){
  if(url.indexOf('?')==-1){
    url+='?miniwin=1';
  }else{
    url+='&miniwin=1';
  }
  if(typeof title=='undefined' || title==''){
    title=document.title;
  }
  $('#hide-miniwin h4').text(title);
  var w=$(window).width()-100;
  if(w>800){
    w=800;
  }
  $('#hide-miniwin .modal-dialog').css({width:w+'px'});
  $('#hide-miniwin .modal-body').css({padding:'0px'});
  
  $("#NoPermissioniframe").attr("src", url);
  $("#hide-miniwin").find('.modal-dialog').draggable({
		cursor: "move",
		handle: '.modal-header'
	}).end().modal({backdrop: 'static', keyboard: false});
  var _scrollHeight = $(document).scrollTop();
  var wHeight = $(window).height();
  var this_height=wHeight-100;
  var this_top=(wHeight-this_height)/2+_scrollHeight+"px";
  var this_top=(wHeight-this_height)/2+"px";

  var h=this_height-100;
  if(h>600){
    h=600;
  }
  var myifmcss={height:h+'px'};//iframe样式
  $('#hide-miniwin .modal-dialog').find('.modal-content').css({height: '100%',width: '100%'}).find('h4').html(title||"").end().find('.modal-body').css({height: '85%'}).find("#NoPermissioniframe").css(myifmcss);
}
ONEZ;
    return $this;
  }
}