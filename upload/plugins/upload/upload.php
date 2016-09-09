<?php

/* ========================================================================
 * $Id: upload.php 3509 2016-09-05 23:59:27Z onez $
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
class onezphp_upload extends onezphp{
  var $isfirst=1;
  function __construct(){
    
  }
  function form_code($arr){
    $html='';
    #只加载一次
    if($this->isfirst){
      $this->isfirst=0;
      $html.='<link rel="stylesheet" href="'.$this->url.'/bootstrap-fileinput/css/fileinput.min.css">';
      $html.='<script src="'.$this->url.'/bootstrap-fileinput/js/fileinput.min.js"></script>';
      $html.='<script src="'.$this->url.'/bootstrap-fileinput/js/locales/zh.js"></script>';
    }
    
    $formkz=onez('bootstrap_form_kz')->init($arr);
    
    $formkz->input->attr('id','input-'.$arr['key'])
                                        ->attr('name',$arr['key'])
                                        ->attr('type','text')
                                        ->attr('class','form-control')
                                        ->attr('placeholder','远程图片地址')
                                        ->attr('style','margin-top:5px;')
                                        ->attr('value',$arr['value'])
                                      ;
    $input_hide=onez('html')->create('input')
                                        ->attr('id','input-upload-'.$arr['key'])
                                        ->attr('name','upload-'.$arr['key'])
                                        ->attr('type','file')
                                        ->attr('class','form-control')
                                        ->attr('value',$arr['value'])
                                      ;
    $formkz->box->add($input_hide);
    
    $html.=$formkz->code();
    
    $exts=array('jpg','png','gif');
    if($arr['filetype']=='audio'){
      
    }else{
      
    }
    $exts=json_encode($exts);
    
    $value=$arr['value']?"'<img src=\"{$arr['value']}\" style=\"max-width:320px;max-height:280px\">'":'';
    $url=$this->view('savefile&token=upload-'.$arr['key']);
    $html.=<<<ONEZ
<script type="text/javascript">
$("#input-upload-{$arr['key']}").fileinput({
    uploadUrl:'$url',
    initialPreview:[$value],
    allowedFileExtensions:$exts,
    enctype:'multipart/form-data',
    language:'zh'
}).on("fileuploaded", function(event, data, previewId, index) {
  var obj = data.response;
  if(obj.success && obj.success.url){
    $("#input-{$arr['key']}").val(obj.success.url);
  }
});
</script>
ONEZ;
/**
$('#file-Portrait').fileinput({
                language: 'zh', //设置语言
                uploadUrl: "/FileUpload/Upload", //上传的地址
                allowedFileExtensions : ['jpg', 'png','gif'],//接收的文件后缀,
                maxFileCount: 100,
                enctype: 'multipart/form-data',
                showUpload: true, //是否显示上传按钮
                showCaption: false,//是否显示标题
                browseClass: "btn btn-primary", //按钮样式             
                previewFileIcon: "<i class='glyphicon glyphicon-king'></i>", 
                msgFilesTooMany: "选择上传的文件数量({n}) 超过允许的最大数值{m}！",
            });
*/
    return $html;
  }
  function savefile($token=''){
    !$token && $token=onez()->gp('token');
    $FILE=$_FILES[$token];
    $A=array();
    if($FILE){
      $A['success']['url']=onez('filesave')->upload('/'.date('Y/m/d/His_').uniqid().'.png',onez()->read($FILE['tmp_name']));
    }
    onez()->output($A);
  }
}