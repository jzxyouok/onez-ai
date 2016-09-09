<?php

/* ========================================================================
 * $Id: footer.php 3435 2016-09-09 05:22:20Z onez $
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
?>
  </div>
  <!-- /.content-wrapper -->

</div>
<div class="modal fade" id="hide-miniwin" style="display: none">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
        </button>
        <h4 class="modal-title">系统提示</h4>
      </div>
      <div class="modal-body"><iframe id="NoPermissioniframe" width="100%" height="100%" frameborder="0" ></iframe></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<?=$G['footer']?>
<script type="text/javascript">
<?=$G['footer-js']?>

function closeWin(){
  $("#hide-miniwin").modal('hide');
}
$(function(){
  $('a.onez-miniwin').each(function(){
    $(this).attr('data-href',$(this).attr('href'));
    $(this).attr('href','javascript:;');
    $(this).click(function(){
      var href=$(this).attr('data-href');
      if(href.indexOf('?')==-1){
        href+='?miniwin=1';
      }else{
        href+='&miniwin=1';
      }
      var title=$(this).attr('data-title');
      if(typeof title=='undefined' || title==''){
        title=$(this).text();
      }
      $('#hide-miniwin h4').text(title);
      var w=$(window).width()-100;
      if(w>800){
        //w=800;
      }
      $('#hide-miniwin .modal-dialog').css({width:w+'px'});
      $('#hide-miniwin .modal-body').css({padding:'0px'});
      
      $("#NoPermissioniframe").attr("src", href);
      $("#hide-miniwin").draggable({
				cursor: "move",
				handle: '.modal-header'
			}).modal({backdrop: 'static', keyboard: false});
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
    });
  });
  $('[data-ajax]').wrap('<div class="ajaxBox"></div>').bind('input click',function(){
    var _input=$(this);
    var kw=$(this).val();
    var ajax=$(this).attr('data-ajax');
    $.post(ajax,{kw:kw},function(o){
      if($('.ajaxBox .mybox').length<1){
        $('<div class="mybox"></div>').insertAfter(_input);
      }
      var mybox=$('.ajaxBox .mybox');
      mybox.empty();
      for(var i=0;i<o.record.length;i++){
        var item=o.record[i];
        if(item.href){
          $('<a href="'+item.href+'" />').addClass(item.type).html(item.text).appendTo(mybox);
        }else{
          $('<a href="javascript:;" />').addClass(item.type).html(item.text).bind('mousedown',function(){
            if($(this).hasClass('tip')){
              return;
            }
            _input.val($(this).text());
            $('.ajaxBox .mybox').remove();
          }).appendTo(mybox);
        }
      }
    },'json');
  });
  $('body').bind('click',function(){
    $('.ajaxBox .mybox').remove();
  });
  $('input.date').datepicker({
    format: 'yyyy-mm-dd',
		language: 'zh-CN',
    autoclose: true
  });
});
</script>
</body>
</html>
