var onez=onez||{};
onez.alert=function(message,callback){
  if($("#hide-alert").length<1){
    var html='';
    html+='<div class="modal fade" id="hide-alert" tabindex="-1" role="basic" aria-hidden="true">';
    html+='<div class="modal-dialog">';
    html+='<div class="modal-content">';
    
    html+='<div class="modal-header">';
    html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>';
    html+='<h4 class="modal-title">系统提示</h4>';
    html+='</div>';
    html+='<div class="modal-body">'+message+'</div>';
    html+='<div class="modal-footer">';
    html+='</div>';
    
    html+='</div>';
    html+='</div>';
    html+='</div>';
    $(html).appendTo('body');
  }
  $("#hide-alert .modal-body").html(message);
  $('#hide-alert .modal-footer').empty();
  if(typeof callback=='undefined'){
    $('<button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>').appendTo('#hide-alert .modal-footer');
  }else{
    $('<button type="button" class="btn btn-default">确定</button>').click(callback).appendTo('#hide-alert .modal-footer');
  }
  $("#hide-alert").modal("show");
};
onez.confirm=function(message,callback){
  if($("#hide-alert").length<1){
    var html='';
    html+='<div class="modal fade" id="hide-alert" tabindex="-1" role="basic" aria-hidden="true">';
    html+='<div class="modal-dialog">';
    html+='<div class="modal-content">';
    
    html+='<div class="modal-header">';
    html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>';
    html+='<h4 class="modal-title">系统提示</h4>';
    html+='</div>';
    html+='<div class="modal-body">'+message+'</div>';
    html+='<div class="modal-footer">';
    html+='</div>';
    
    html+='</div>';
    html+='</div>';
    html+='</div>';
    $(html).appendTo('body');
  }
  $("#hide-alert .modal-body").html(message);
  $('#hide-alert .modal-footer').empty();
  if(typeof callback=='undefined'){
    $('<button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>').appendTo('#hide-alert .modal-footer');
  }else{
    $('<button type="button" class="btn btn-primary">确定</button>').click(function(){
      $('#hide-alert').modal('hide');
      callback();
    }).appendTo('#hide-alert .modal-footer');
    $('<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>').appendTo('#hide-alert .modal-footer');
  }
  $("#hide-alert").modal("show");
};
onez.formpost=function(form){
  $.post(window.location.href,$(form).serialize(),function(data){
    if(typeof data.error=='string'){
      onez.alert(data.error);
    }
    if(typeof data.status=='string' && data.status=='success'){
      if(typeof data.goto=='string'){
        if(typeof data.message=='string'){
          onez.alert(data.message,function(){
            if(data.goto=='reload'){
              window.location.reload();
            }else{
              window.location.href=data.goto;
            }
          });
        }else{
          if(data.goto=='reload'){
            window.location.reload();
          }else{
            window.location.href=data.goto;
          }
        }
      }else if(typeof data.message=='string'){
        onez.alert(data.message);
      }
    }
  },'json');
};
onez.del=function(id){
  onez.confirm('您确定要删除这条记录吗？',function(){
    $.post(window.location.href,{action:'delete',id:id},function(data){
      if(typeof data.error=='string'){
        onez.alert(data.error);
      }
      if(typeof data.status=='string' && data.status=='success'){
        if(typeof data.goto=='string'){
          if(typeof data.message=='string'){
            onez.alert(data.message,function(){
              if(data.goto=='reload'){
                window.location.reload();
              }else{
                window.location.href=data.goto;
              }
            });
          }else{
            if(data.goto=='reload'){
              window.location.reload();
            }else{
              window.location.href=data.goto;
            }
          }
        }else if(typeof data.message=='string'){
          onez.alert(data.message);
        }
      }
    },'json');
  });
};
onez.formcheck=function(form,option){
  var o={
    errorElement: 'span', //default input error message container
    errorClass: 'help-block help-block-error', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    ignore: "",  // validate all fields including form hidden input
    highlight: function (element) { // hightlight error inputs
        $(element)
            .closest('.form-group').addClass('has-error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change done by hightlight
        $(element)
            .closest('.form-group').removeClass('has-error'); // set error class to the control group
    },
    success: function (label) {
        label
            .closest('.form-group').removeClass('has-error'); // set success class to the control group
    },
    submitHandler: function (form) {
        onez.formpost(form);
    }
  };
  if(typeof option=='object'){
    for(var k in option){
      o[k]=option[k];
    }
  }
  form.validate(o);
};