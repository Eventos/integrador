/*8888888888888888888888888888888888888888888*/
$(document).ready(function() {	
	var defaults = {
			containerID: 'toTop', 
		containerHoverID: 'toTopHover',
		scrollSpeed: 1200,
		easingType: 'linear' 
		};
	$().UItoTop({ easingType: 'easeOutQuart' });
});

$(document).ready(function() {
	$("a#example3").fancybox({
			'transitionIn'	: 'none',
			'transitionOut'	: 'none'	
		});
});
/*888888888888888888888888888888888888888888888*/
$(document).ready(function () {
	$('#bt_menu').hover(function(){
		$('.listar-menu').css('-webkit-transition','all 0.3s linear');
		$('.menu').css('-webkit-transition','all 0.3s linear');
		$('.listar-menu').css('background','white');
		$('.bt_menu>span').css('color','white');
		$('.menu').css('background','black');
	});
	$('#bt_menu').mouseleave(function(){
		$('.listar-menu').css('background','black');
		$('.bt_menu>span').css('color','black');
		$('.menu').css('background','none');
	});
	$('#bt_menu').click(function(){
		if($('#menu_oculto').css('display')=='block'){
			$("#menu_oculto").slideUp(800);
		}
		else{
			$('#menu_oculto').slideDown(800);
		}
	});
	$('.fechar').click(function(){
		$('.boas-vindas').hide(150);
		$('#fancybox').hide(700);
	});
	$('#close').click(function(){
		$('.boas-vindas').hide(150);
		$('#fancybox').hide(700);
	});
	$(document).bind('click', function(e){ 
  		if (!$(e.target).parents('#fancybox').length){
      		$('.boas-vindas').hide(150);
			$('#fancybox').hide(700);
        }
	}); 
});