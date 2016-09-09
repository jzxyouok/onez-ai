(function(ai) {
  ai.max_msgid=0;
  //输出一条消息
  ai.print=function(msg,orderby){
    if(typeof msg.msgid!='undefined'){
      if($('.msg-item-usr[data-msgid="'+msg.msgid+'"]').length>0){
        return;
      }
      msg.msgid=parseInt(msg.msgid);
    }else{
      msg.msgid=0;
    }
    if(msg.msgid>ai.max_msgid){
      ai.max_msgid=msg.msgid;
    }
    if(typeof orderby=='undefined'){
      orderby='asc';
    }
    if(typeof msg.time=='undefined'){
      msg.time='';
    }
    if(typeof msg.action=='undefined'){
      msg.action='ai';
    }
    if(msg.action=='ai'){
      msg.pos='you';
      msg.nick=ai.name;
    }else{
      msg.pos='me';
      msg.nick='您';
    }
    if(typeof msg.type!='undefined' && msg.type=='image'){
      msg.message='<img src="'+msg.message+'" class="image" />';
    }
    var div=$('<div class="msg-item msg-pos-'+msg.pos+'" />');
    
    var time=ai.time(msg.time);
    
    var usr=$('<div class="msg-item-usr" />').attr('data-msgid',msg.msgid).html(msg.nick+'\t'+time);
    usr.appendTo(div);
    var message=$('<div class="msg-item-message" />').html(msg.message);
    message.appendTo(div);
    
    if(orderby=='asc'){
      div.appendTo('#showbox');
    }else{
      div.prependTo('#showbox');
    }
    
    ai.active();
    
    div.find('img').bind('load',ai.tobottom);
    ai.tobottom();
  };
  //滚动到最底部
  ai.tobottom=function(){
    $('#showbox').scrollTop($('#showbox')[0].scrollHeight);
  };
  //发送当前输入区的内容
  ai.sendinput=function(){
    var message=$.trim($('#inputbox').val());
    if(message.length<1){
      return;
    }
    var msg={
      type:'text',
      message:message,
    }
    $('#inputbox').val('').get(0).focus();
    ai.send(msg);
  };
  ai.recv(ai.print);
  ai.send(function(msg){
    ai.post('send',msg,function(data){
      if(typeof data.messages!='undefined'){
        for(var i=0;i<data.messages.length;i++){
          var msg=data.messages[i];
          ai.print(msg);
        }
      }
    });
  });
  //调整窗口后跳到最底部
  onez.resize(ai.tobottom);
  
  
  //启动
  if(_onez_ai_deviceid!=''){
    ai.postobj.deviceid=_onez_ai_deviceid;
  }
  var start={
    deviceid:_onez_ai_deviceid,
    udid:ai.udid
  };
  start['系统语言']=(navigator.systemLanguage?navigator.systemLanguage:navigator.language);
  start['屏幕色深']=screen.colorDepth;
  start['屏幕尺寸']=screen.width + '*' + screen.height;
  start['页面编码']=document.charset;
  start['来源地址']=window.top.document.referrer;
  if(window.top.document.referrer==''){
    start['来源地址']='直接打开';
  }
  ai.post('start',start,function(data){
    if(typeof data.udid=='string'){
      ai.udid=data.udid;
    }
    if(ai.start()){
      $('#inputbox').val('').get(0).focus();
      $('#sendbtn').click(ai.sendinput);
      $('#inputbox').keydown(function(e){
        var key = e.which ? e.which : e.keyCode;
        if(key==13){
          ai.sendinput();
          e.cancelBubble=true;
          e.preventDefault();
          e.stopPropagation();
        }
      });
      ai.newmsg(ai.history);
    }
  });
  //启动第一步，读取未读消息
  ai.newmsg=function(callback){
    ai.post('newmsg',{msgid:ai.max_msgid},function(data){
      if(data.messages){
        var newmsgids=[];
        for(var i=0;i<data.messages.length;i++){
          var msg=data.messages[i];
          newmsgids.push(msg.msgid);
          ai.print(msg);
        }
        if(newmsgids.length>0){
          ai.isread(newmsgids);
        }
        
      }
      if(typeof callback=='function'){
        callback();
      }
    });
  };
  //启动第二步，读取历史记录
  ai.history=function(){
    ai.post('history',{},function(data){
      for(var i=0;i<data.messages.length;i++){
        var msg=data.messages[i];
        ai.print(msg,'desc');
      }
      ai.init();
      ai.update(ai.newmsg);
      ai.post('auto',{auto:_onez_ai_auto},function(data){
        
      });
    });
  };
  //设置消息已读
  ai.isread=function(msgids){
    ai.post('isread',{msgids:msgids.join(',')},function(data){
      
    });
  };
})(onez.ai);