function _rule_get(){
  var rule={};
  var inputs=['#extra_text_same','#extra_text_one','#extra_text_all','#extra_text_tpl'];
  var n=0;
  for(var i in inputs){
    var key=inputs[i].substr(12);
    var value=$(inputs[i]).val();
    if(value.length>0){
      rule[key]=value;
      n++;
    }
  }
  if(n==0){
    return '用户输入内容请至少设置一项';
  }
  return rule;
}