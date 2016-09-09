var onez=window.onez||{};
(function(onez) {
  onez.ready=function(callback,need){
    if(typeof need!='object'){
      need=[];
    }
    if(need.length<1){
      callback(onez.jq);
      return;
    }
    var f=need.shift();
    if(f.toLowerCase()=='jquery'){
      if(typeof jQuery=='undefined'){
        var head = document.getElementsByTagName('HEAD').item(0);
        var link = document.createElement("script");
        link.type = "text/javascript";
        link.src = onez.resList.jquery;
        link.onload = function(){
          onez.jq=jQuery.noConflic();
          onez.ready(callback,need);
        }
        link.onerror = function(){
          onez.ready(callback,need);
        }
        head.appendChild(link);
      }else{
        onez.jq=jQuery;
        onez.ready(callback,need);
      }
    }else if(typeof f=='object' && typeof f.name!='undefined' && typeof f.url!='undefined'){
      if(typeof onez[f.name]!='undefined'){
        onez.ready(callback,need);
      }else{
        onez.jq.getScript(f.url,function(){
          onez.ready(callback,need);
        });
      }
    }else{
      onez.ready(callback,need);
    }
  };
  onez.resizeList=[];
  onez.resize=function(callback){
    if(typeof callback!='function'){
      return;
    }
    if(onez.resizeList.length<1){
      $(window).bind('resize',function(){
        for(var i=0;i<onez.resizeList.length;i++){
          $(onez.resizeList[i]);
        }
      });
    }
    onez.resizeList.push(callback);
    $(callback);
  };
  onez.storage=function(key,value){
    if(typeof value=='undefined'){
      if(typeof window.localStorage=='undefined'){
        return '';
      }
      var value=window.localStorage.getItem(key);
      if(typeof value=='undefined' || value==null || value.length<1){
        return '';
      }
      return value;
    }else{
      if(typeof window.localStorage=='undefined'){
        return;
      }
      window.localStorage.setItem(key,value);
    }
  };
  onez.cookie=function(key,value){
    if(typeof value=='undefined'){
      var arr,reg=new RegExp("(^| )"+key+"=([^;]*)(;|$)");
      if(arr=document.cookie.match(reg)){
        return unescape(arr[2]);
      }else{
        return '';
      }
    }else{
      var exp = new Date();
      exp.setTime(exp.getTime() + 86400*365*1000);
      document.cookie = key + "="+ escape (value) + ";expires=" + exp.toGMTString();
    }
  };
})(onez);