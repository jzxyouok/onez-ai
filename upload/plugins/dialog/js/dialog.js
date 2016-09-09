onez.ready(function(){
  $('body').attr('scroll','no').css({'overflow':'hidden'});
  
  var _auto=function(size,obj){
    if(obj.find('> .onez-auto').length>0){
      var offset=0;
      obj.find('> *').each(function(){
        if($(this).hasClass('onez-auto')){
        }else{
          offset+=$(this).height();
        }
        //offset+=parseInt($(this).css('marginTop'));
        //offset+=parseInt($(this).css('marginBottom'));
        offset+=parseInt($(this).css('paddingTop'));
        offset+=parseInt($(this).css('paddingBottom'));
      });
      obj.find('> .onez-auto').height(size-offset);
    }else{
      obj.css({'overflow':'hidden','overflow-y':'auto'});
    }
  };
  onez.resize(function(){
    var width_win=$(window).width();
    var height_win=$(window).height();
    var height_header=$('header').height();
    var height_footer=$('footer').height();
    var width_aside_left=$('aside.onez-left').width();
    var width_aside_right=$('aside.onez-right').width();
    
    $('.onez-dialog').width(width_win).height(height_win);
    
    var height_section=height_win-height_header-height_footer;
    $('section').css({top:height_header+'px'}).height(height_section);
    
    $('aside').height(height_section).each(function(){
      _auto(height_section,$(this));
    });
    
    var width_content=width_win-width_aside_left-width_aside_right;
    
    $('.onez-body').css({left:width_aside_left+'px'}).width(width_content);
    _auto(height_section,$('.onez-body'));
    
    var width_inputbox=width_content;
    width_inputbox-=parseInt($('.onez-inputbox textarea').css('paddingTop'));
    width_inputbox-=parseInt($('.onez-inputbox textarea').css('paddingBottom'));
    $('.onez-inputbox textarea').width(width_inputbox);
    
    var height_inputbox=$('.onez-inputbox').height();
    height_inputbox-=parseInt($('.onez-inputbox textarea').css('paddingTop'));
    height_inputbox-=parseInt($('.onez-inputbox textarea').css('paddingBottom'));
    $('.onez-inputbox textarea').height(height_inputbox);
  });
  $('.onez-dialog').css({'visibility':'visible','display':'none'}).fadeIn('fast');
});