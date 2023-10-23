// JavaScript Document
$(document).ready(function(e) {
	var b=$("#content_main").width();
	var c=b-90;
	$("#content_main").css({'width':c});
	
	var win_h=$(window).height();
	var left_menu_h=$("#left_menu").height();
	if(win_h<(left_menu_h+55))
	{
		$("#left_menu").css({'position':'absolute'});
	}
	else
	{
		$("#left_menu").css({'position':'fixed'});
	}
});
$(window).resize(function(){
	var win_w=$(window).width();
	var temp=win_w-90;
	if(temp<890)
	{
		temp=890;
	}
	$("#content_main").css({'width':temp});
	
	var win_h=$(window).height();
	var left_menu_h=$("#left_menu").height();
	if(win_h<(left_menu_h+55))
	{
		$("#left_menu").css({'position':'absolute'});
	}
	else
	{
		$("#left_menu").css({'position':'fixed'});
	}
	});