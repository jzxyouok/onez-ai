(function(ai) {
  ai.max_msgid=0;
  //输出一条消息
  ai.print=function(msg,orderby){
    if(typeof msg.msgid!='undefined'){
      if($('.msg-item[data-msgid="'+msg.msgid+'"]').length>0){
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
      msg.pos='me';
      msg.nick=ai.name+'('+msg.you+')';
    }else{
      msg.pos='you';
      msg.nick=ai.person.name;
    }
    if(typeof msg.type!='undefined' && msg.type=='image'){
      msg.message='<img src="'+msg.message+'" class="image" />';
    }
    var div=$('<div class="msg-item msg-pos-'+msg.pos+'" />').attr('data-msgid',msg.msgid);
    
    var time=ai.time(msg.time);
    
    var usr=$('<div class="msg-item-usr" />').html(msg.nick+'\t'+time);
    usr.appendTo(div);
    var message=$('<div class="msg-item-message" />').html(msg.message);
    message.appendTo(div);
    
    
    var asrule=$('#asrule').is(':checked');
    if(asrule && msg.action!='ai'){
      if(msg.status=='ask'){
        $('<a href="javascript:;" class="_link _link_reply btn btn-xs btn-danger" onclick="onez.ai.reply(\''+msg.msgid+'\')">未处理</a>').appendTo(message);
        div.addClass('is-ask');
      }
    }
    if(orderby=='asc'){
      div.appendTo('#showbox');
      if(asrule && $('#_link_reply_doing').length<1){
        if($('#_link_reply_doing').length<1){
          if(message.find('._link_reply').length>0){
            onez.ai.reply(msg.msgid);
          }
        }
      }
    }else{
      div.prependTo('#showbox');
    }
    
    ai.active();
    
    div.find('img').bind('load',ai.tobottom);
    ai.tobottom();
  };
  ai.doit_reset=function(){
    if(typeof ai.persons[ai.person_id]!='undefined'){
      _deviceid=ai.persons[ai.person_id].person.deviceid;
      _personid=ai.person_id;
    }
  };
  ai.doit=function(){
    
  };
  //滚动到最底部
  ai.tobottom=function(){
    $('#showbox').scrollTop($('#showbox')[0].scrollHeight);
  };
  //回复一条
  ai.reply=function(msgid){
    $('#_link_reply_doing').remove();
    var msgdiv=$('.msg-item[data-msgid="'+msgid+'"]');
    var div=$('<div id="_link_reply_doing" />').attr('data-msgid',msgid).ani('bounceInUp');
    //var h3=$('<h3 />').html('文本内容').appendTo(div);
    var p=$('<p />').html($.trim(msgdiv.find('.msg-item-message').clone().find('._link').remove().end().text())).appendTo(div);
    var btns=$('<div class="btns"></div>').appendTo(div);
    var p2=$('<p class="help" />').html('您也可以通过直接回复快速存为“文本一对一”规则').appendTo(div);
    $('<button class="btn btn-primary">存为自定义规则</button>').click(function(){
      miniwin(_onez_ai_view_device+'design&msgid='+msgid+'&person_id='+ai.person_id+'&text='+encodeURIComponent(p.text()),'存为规则');
      div.remove();
      msgdiv.removeClass('reply-doing');
    }).appendTo(btns);
    $('<button class="btn btn-warning">忽略</button>').click(function(){
      
      ai.post('cancel',{msgid:msgid},function(data){
        
      });
      div.remove();
      msgdiv.removeClass('reply-doing is-ask').find('._link_reply').remove();
    }).appendTo(btns);
    $('<button class="btn btn-warning">忽略所有</button>').click(function(){
      
      ai.post('cancel',{msgid:'all',person_id:ai.person_id},function(data){
        
      });
      div.remove();
      $('.msg-item').removeClass('reply-doing is-ask');
      $('._link_reply').remove();
    }).appendTo(btns);
    $('<button class="btn btn-danger">关闭</button>').click(function(){
      div.remove();
      msgdiv.removeClass('reply-doing');
    }).appendTo(btns);
    div.appendTo('body');
    msgdiv.addClass('reply-doing');
  };
  //发送当前输入区的内容
  ai.sendinput=function(){
    if(ai.person_id==0){
      alert('请先选择用户');
      return;
    }
    var message=$.trim($('#inputbox').val());
    if(message.length<1){
      return;
    }
    var msg={
      type:'text',
      message:message,
    }
    $('#inputbox').val('').get(0).focus();
    msg.person_id=ai.person_id;
    var asrule=$('#asrule').is(':checked');
    if(asrule){
      var _link_reply_doing=$('#_link_reply_doing');
      if(_link_reply_doing.length>0){
        msg.msgid=_link_reply_doing.attr('data-msgid');
        msg.asrule=1;
        _link_reply_doing.remove();
        $('.msg-item[data-msgid="'+msg.msgid+'"]').removeClass('reply-doing is-ask').find('._link_reply').remove();
      }
    }
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
  
  
  ai.person_ids=[];
  ai.person_id=0;
  ai.persons={};
  ai.person={};
  ai.Person=function(person){
    var _this_=this;
    this.person=person;
    this.id=person['id'];
    this.name=person['name'];
    this.online=1;
    this.update=function(person){
      for(var k in person){
        _this_.person[k]=person[k];
      }
      
      if(typeof person.avatar!='undefined'){
        _this_.ui.find('.onez-person-avatar').css({'background-image':'url('+person.avatar+')'});
      }
      if(typeof person.nickname!='undefined'){
        _this_.name=person.nickname;
        _this_.ui.find('.onez-person-nickname').html(person.nickname);
      }
      if(typeof person.summary!='undefined'){
        _this_.ui.find('.onez-person-summary').html(person.summary);
      }
      if(typeof person.status!='undefined'){
        _this_.ui.find('.onez-person-status').html(person.status);
      }
    };
    this.remove=function(){
      if(ai.person_id==_this_.id){
        ai.close();
      }
      $('[data-person="'+_this_.id+'"]').remove();
      if(typeof ai.persons[_this_.id]!='undefined'){
        delete ai.persons[_this_.id];
      }
    };
    
    this.ui=$('<div class="onez-person"></div>');
    $('<div class="onez-person-avatar"></div>').appendTo(this.ui);
    $('<div class="onez-person-nickname"></div>').appendTo(this.ui);
    $('<div class="onez-person-summary"></div>').appendTo(this.ui);
    $('<div class="onez-person-status"></div>').appendTo(this.ui);
    this.ui.attr('data-person',_this_.id).appendTo('#userlist');
    this.ui.appendTo('#userlist');
    this.update(person);
    this.ui.click(function(){
      ai.open(_this_.id);
    });
  };
  //打开对话框
  ai.open=function(person_id){
    if(typeof ai.persons[person_id]=='undefined'){
      return;
    }
    var person=ai.persons[person_id];
    if(person_id==ai.person_id){
      person.ui.ani('shake');
      return;
    }
    if(ai.person_id!=0){
      ai.close();
    }
    ai.max_msgid=0;
    ai.person=person;
    person.ui.addClass('current');
    person.ui.ani('rubberBand');
    ai.person_id=person_id;
    
    ai.post('person_info',{person_id:ai.person_id},function(data){
      if(data.messages){
        for(var i=0;i<data.messages.length;i++){
          var msg=data.messages[i];
          ai.print(msg,'desc');
        }
      }
      if(data.tip){
        $('.onez-tip').html(data.tip);
      }
      $('#inputbox').attr('disabled',false).removeClass('disabled');
      $(window).trigger('resize');
      $('.onez-btns').show();
      $('#inputbox').val('').get(0).focus();
      ai.moreinfo();
    });
  };
  ai.info_format=function(key,value){
    if(typeof value=='object' || typeof value=='undefined'){
      return'';
    }
    if(key=='deviceid'||key=='udid'){
      return'';
    }
    if(typeof value=='string'){
      if(value.indexOf('http://')!=-1 || value.indexOf('https://')!=-1){
        value='<a href="'+value+'" target="_blank">'+value+'</a>';
      }
    }
    var html='';
    html+='<dt>'+key+':</dt>';
    html+='<dd>'+value+'</dd>';
    return html;
  };
  ai.moreinfo=function(){
    ai.post('person_more',{person_id:ai.person_id},function(data){
      var html='';
      if(data.info){
        var info=data.info;
        if(info.tags){
          html+='<p class="tags">';
          for(var i=0;i<info.tags.length;i++){
            html+='<span class="btn btn-xs btn-primary">'+info.tags[i]+'</span>';
          }
          html+='</p>';
        }
        
        html+='<h3>智能属性</h3>';
        html+='<dl class="dl-horizontal">';
        for(var k in info){
          if(k=='tags' || k=='initinfo' || k=='lastinfo' || k=='device'){
            continue;
          }
          html+=ai.info_format(k,info[k]);
        }
        html+='</dl>';
        
        if(data.info.lastinfo){
          html+='<h3>本次信息</h3>';
          html+='<dl class="dl-horizontal">';
          for(var k in data.info.lastinfo){
            html+=ai.info_format(k,data.info.lastinfo[k]);
          }
          html+='</dl>';
        }
        if(data.info.initinfo){
          html+='<h3>首次信息</h3>';
          html+='<dl class="dl-horizontal">';
          for(var k in data.info.initinfo){
            html+=ai.info_format(k,data.info.initinfo[k]);
          }
          html+='</dl>';
        }
      }
      $('#moreinfo').html(html);
      
    });
  };
  //关闭当前对话框
  ai.close=function(){
    $('#showbox,#inputbox,#moreinfo').empty();
    $('#inputbox').attr('disabled',true).val('请先选择用户').addClass('disabled');
    $('.onez-tip,.onez-btns').hide();
    $(window).trigger('resize');
    if(ai.person_id==0){
      return;
    }
    if(typeof ai.persons[ai.person_id]!='undefined'){
      ai.persons[ai.person_id].ui.removeClass('current');
    }
    ai.person={};
    ai.person_id=0;
  };
  //启动第一步，读取未读消息
  ai.newmsg=function(callback){
    ai.post('newmsg',{person_ids:ai.person_ids.join(','),person_id:ai.person_id,msgid:ai.max_msgid},function(data){
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
      if(data.persons){
        ai.person_ids=[];
        for(var k in ai.persons){
          ai.persons[k].online=0;
        }
        for(var i=0;i<data.persons.length;i++){
          var person=data.persons[i];
          var person_id=person['id'];
          
          ai.person_ids.push(person_id);
          
          //新用户
          if(typeof ai.persons[person_id]=='undefined'){
            ai.persons[person_id]=new ai.Person(person);
          }else{
            ai.persons[person_id].update(person);
          }
          ai.persons[person_id].online=1;
        }
        //离线用户
        for(var k in ai.persons){
          if(ai.persons[k].online==0){
            ai.persons[k].remove();
          }
        }
      }
      if(typeof callback=='function'){
        callback();
      }
    });
  };
  //设置消息已读
  ai.isread=function(msgids){
    ai.post('isread',{msgids:msgids.join(',')},function(data){
    });
  };
  
  
  
  //启动
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
  //ai.newmsg(ai.history);
  ai.postobj.grade=_onez_ai_grade;
  ai.close();
  ai.init();
  ai.update(ai.newmsg);
})(onez.ai);