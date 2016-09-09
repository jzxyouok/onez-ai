onez.dialog_open=function(url,width,height){
  var left=($(window).width()-width)/2;
  var top=($(window).height()-height)/2;
  window.open(url, encodeURIComponent(url), 'width='+width+', height='+height+',left='+left+', top='+top+', toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no');
};