var onez=window.onez||{};
if(typeof onez.ai=='undefined'){
  onez.ai={};
}
(function(ai) {
  ai.udid=_onez_ai_udid;
  ai.url=_onez_ai_url;
  ai.view=_onez_ai_view;
  ai.device=_onez_ai_device;
  ai.postobj=_onez_ai_post;
  ai.name=_onez_ai_name;
  ai.avatar=_onez_ai_avatar;
  ai.post=function(action,postdata,callback){
    if(typeof postdata=='object'){
      for(var k in ai.postobj){
        postdata[k]=ai.postobj[k];
      }
    }
    var url=_onez_ai_view;
    if(typeof _onez_ai_view_device!='undefined'){
      url=_onez_ai_view_device;
    }
    url+=action;
    $.post(url,postdata,function(data){
      if(typeof callback=='function'){
        callback(data);
      }
    },'json');
  };
  //发送一组数据
  ai.sendList=[];
  ai.send=function(obj){
    if(typeof obj=='function'){
      ai.sendList.push(obj);
    }else{
      for(var i=0;i<ai.sendList.length;i++){
        $(ai.sendList[i](obj));
      }
    }
  };
  //接收到一组数据
  ai.recvList=[];
  ai.recv=function(obj){
    if(typeof obj=='function'){
      ai.recvList.push(obj);
    }else{
      for(var i=0;i<ai.recvList.length;i++){
        $(ai.recvList[i](obj));
      }
    }
  };
  //定时读取
  ai.updateList=[];
  ai.update=function(obj){
    if(typeof obj=='function'){
      ai.updateList.push(obj);
    }else{
      ai.cur_update+=10;
      ai.sec_update++;
      if(ai.sec_update>=2000){
        ai.sec_update=2000;
      }
      if(ai.cur_update>=ai.sec_update){
        ai.cur_update=0;
        for(var i=0;i<ai.updateList.length;i++){
          $(ai.updateList[i](obj));
        }
      }
    }
  };
  //时间
  ai.time=function(t){
    var date=new Date(t * 1000);
    
    var day=[];
  	var Y_=date.getFullYear().toString();
    day.push(Y_);
  	var m=(date.getMonth()+1).toString();
    day.push(m);
  	var d=date.getDate().toString();
    day.push(d);
    
    var pre='';
    var daynow=day.join('-');
    if(daynow!=_today){
      pre=daynow+' ';
    }
    
  	var H_=date.getHours().toString();
  	var i_=date.getMinutes().toString();
  	var s_=date.getSeconds().toString();
  	if(i_.length==1)i_="0"+i_;
  	if(s_.length==1)s_="0"+s_;
  	return pre+H_+":"+i_+":"+s_;
  };
  
  //识别当前访客信息
  if(ai.udid==''){
    ai.udid=onez.storage('udid');
  }
  if(ai.udid==''){
    ai.udid=onez.cookie('udid');
  }
  //启动入口，由当前终端的js控制
  ai.start=function(){
    if(ai.udid==''){
      ai.recv({
        type:'error',
        message:'未获取到有效标识'
      });
      return false;
    }
    onez.cookie('udid',ai.udid);
    onez.storage('udid',ai.udid);
    ai.postobj.udid=ai.udid;
    return true;
  };
  //正式启动
  ai.init=function(){
    ai.cur_update=0;
    ai.active();
    ai.timer_update=setInterval('onez.ai.update()',100);
  };
  //设置为活动
  ai.active=function(){
    ai.sec_update=100;
    
  };
})(onez.ai);