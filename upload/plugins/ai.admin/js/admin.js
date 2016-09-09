var _doit_index=0;
//为目标增加一个标签
function _doit_addtag(){
  miniwin(_url+'addtag&deviceid='+_deviceid+'&personid='+_personid,'为目标增加一个标签');
}
//为目标移除一个标签
function _doit_removetag(){
  miniwin(_url+'removetag&deviceid='+_deviceid+'&personid='+_personid,'为目标移除一个标签');
}
//修改目标属性
function _doit_setattr(){
  miniwin(_url+'setattr&deviceid='+_deviceid+'&personid='+_personid,'修改目标属性');
}
//执行一个脚本
function _doit_script(){
  miniwin(_url+'script&deviceid='+_deviceid+'&personid='+_personid,'执行一个脚本');
}
//输出一条数据
function _doit_output(){
  miniwin(_url+'output&deviceid='+_deviceid+'&personid='+_personid,'输出一条数据');
}
//执行添加操作
function _doit_add(obj){
  if(typeof onez.ai=='object' && typeof onez.ai.doit=='function'){
    onez.ai.doit(obj);
    closeWin();
    return;
  }
  
  var json=$(obj).attr('data-json');
  json=json.replace(/\\\\/g,'\\');
  json=JSON.parse(json);
  
  _doit_index++;
  
  var btn=$('<button type="button" class="btn btn-xs btn-danger" onclick="_doit_del('+_doit_index+')">删除</button>');
  $('<li />').css({'padding':'3px 0'}).attr('data-index',_doit_index).attr('data-json',JSON.stringify(json)).html(json.text+' ').append(btn).appendTo('#_doit');
  closeWin();
}
//
function _doit_del(_doit_index){
  bootbox.confirm('确定要删除吗？',function(result){
    if(result){
      $('#_doit li[data-index="'+_doit_index+'"]').remove();
    }
  });
}
function _doit_get(){
  var doit=[];
  $('#_doit li[data-json]').each(function(){
    var json=$(this).attr('data-json');
    json=json.replace(/\\\\/g,'\\');
    json=JSON.parse(json);
    doit.push(json);
  });
  if(doit.length<1){
    return '至少应执行一种操作';
  }
  
  return doit;
}
$(function(){
  if(typeof _doits=='object'){
    for(var i=0;i<_doits.length;i++){
      var json=_doits[i];
      _doit_index++;
      var btn=$('<button type="button" class="btn btn-xs btn-danger" onclick="_doit_del('+_doit_index+')">删除</button>');
      $('<li />').css({'padding':'3px 0'}).attr('data-index',_doit_index).attr('data-json',JSON.stringify(json)).html(json.text+' ').append(btn).appendTo('#_doit');
    }
  }
});