window.onload = function() {
	appInit();
};

function appInit(){
	initCards();
	//checkAJAX();
	initScrollButtons();
	initPostForm();
	initAJAX();
}

function initAJAX(){
	if(ajaxLoad){
		ajaxPage++;
		$(document).bind('scroll',function(){
			if($(window).scrollTop()+$(window).height()>$(document).height()-500){
				loadPosts('/'+ajaxAction+'/'+ajaxPage+'/');
			}
		});
	}
}

function initScrollButtons(){
	$('.scroll_top').bind('click',function(){
		$('html, body').animate({
			scrollTop: 0
		}, 500);
	});
	$('.scroll_down').bind('click',function(){
		$('html, body').animate({
			scrollTop: $(document).height()
		}, 500);
	});
}

function initPostForm(){
	$('.open_form_btn').bind('click',function(){
		$(this).hide();
		$('.post_form > form').show();
	});
	$('.upload_media_btn').bind('click',function(){
		$('.upload_media').click();
	});
}

function initCards(){
	if('content' in document.createElement('template')){
		$('.post_content').each(function(idx, obj){
			cutContent(obj);
		});
	}
	$('.post_media_link').fancybox();
}

function cutContent(obj){
	var id = $('#'+obj.id).data('id');
	if($('#post_content_'+id).height()>500){
		$('#post_content_'+id).addClass('post_content_cutted');
		$('#post_link_'+id).hide();
		$('#post_additional_actions_'+id).html($('#expand_text').html());
		$('#post_additional_actions_'+id).click(function(){
			expandContent($(this).data('id'));
		});
		$('#post_additional_actions_'+id).show();
	}
}

function expandContent(id){
	$('#post_content_'+id).removeClass('post_content_cutted');
	$('#post_link_'+id).show();
	$('#post_additional_actions_'+id).hide();
	$('#post_additional_actions_'+id).html('');
	$('#post_additional_actions_'+id).click(function(){});

}

function loadPosts(subURI = '/', method = 'GET'){
	var URI = '/ajax/'+subURI;
	if(!ajaxLock&&ajaxTimeOut<new Date().getTime()){
		ajaxLock = true;
		$.ajax({
			method:'GET',
			url:URI,
			cache:false,
			//dataType:'json',
			contentType: 'html/text'
		}).done(function(data){
			if(data.length>0){
				$('.main_page_content').append(data);
				initCards();
				ajaxPage++;
				ajaxLock = false;
				ajaxTimeOut = new Date().getTime()+300;
			}
		});
	}
}

function popUpAlert(message = ''){
	alert(message);
}
function checkAJAX(){
	//$res = reqAJAX('/test/');
	//console.log($res);
	//$res = reqAJAX('/test/1/');
	//console.log($res);
	//console.log(reqAJAX('/test/1_2_3/'));
}
/*
if(
				data.status !== 'undefined' &&
				data.status &&
				data.data !== 'undefined'
			){
				res = data.data;
				if(res.length>0){
					ajaxLock = false;
				}
				console.log(res);
			} else {
				ajaxLock = false;
			}
			*/
			//dataType:'json',
			//contentType: 'application/json'