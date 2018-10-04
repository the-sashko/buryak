window.onload = function() {
	appInit();
};

function appInit(){
	initCards();
	//checkAJAX();
	initScrollButtons();
	initMenuButton();
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

function initMenuButton(){
	$('.top_menu_btn').bind('click',function(){
		$('.top_menu_pda').toggle();
	});
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
	initLinksPreview();
	initCardsPreview();
}

function initLinksPreview(){
	$('.post_external_link').hover(function(event){
		var time = new Date().getTime();
		$('#popup').html('<iframe id=\"link_preview_iframe_'+time+'\" src="'+$(this).attr('href')+'" scrolling="no" style="width:248px;height:248px;border:none;border-radius:.5em;"></iframe>');
		//$('#popup').offset({top:event.pageY+10,left:event.pageX+10});
		$('#popup').css('top',event.pageY+10);
		$('#popup').css('left',event.pageX+10);
		$('#link_preview_iframe_'+time).bind('load',function(){
			$('#popup').show();
		});
		/*$('#link_preview_iframe_'+time).bind('click',function(){
			$('#popup').hide();
			$('#popup').html('');
			$('#popup').offset({top:0,left:0});
		});*/
		$('.post_external_link').bind('mouseout',function(){
			$('#popup').hide();
			$('#popup').html('');
			$('#popup').css('top','0');
			$('#popup').css('left','0');
		});
	});
}
function initCardsPreview(){
	$('.card_snippet_link_without_level').data('level',postSnippetLevel);
	$('.card_snippet_link_without_level').removeClass('card_snippet_link_without_level');
	$('.card_snippet_link').hover(function(event){
		if(!postSnippetAJAXLock&&!$(this).hasClass('used')){
			postSnippetAJAXLock = true;
			postSnippetX = event.pageX;
			postSnippetY = event.pageY;
			var postID = $(this).data('id');
			var sectionID = $(this).data('section');
			var currLevel = $(this).data('level');
			while(currLevel < postSnippetLevel){
				$('.post_snippet_card_popup[data-level="'+postSnippetLevel+'"]').remove();
				postSnippetLevel--;
			}
			$('.post_snippet_card_popup[data-level="'+currLevel+'"]').remove();
			$('.used').removeClass('used');
			$(this).addClass('used');
			$.ajax({
				method:'GET',
				url:'/ajax/post/'+postID+'/'+sectionID+'/',
				cache:true,
				contentType: 'html/text'
			}).done(function(data){
				postSnippetAJAXLock = false;
				if(data.length>0){
					var time = new Date().getTime();
					$('body').append('<div id="post_snippet_card_'+time+'" class="post_snippet_card_popup" data-level="'+postSnippetLevel+'">'+data+'</div>');
					$('#post_snippet_card_'+time).css('top',postSnippetY+10);
					$('#post_snippet_card_'+time).css('left',postSnippetX+10);
					$('#post_snippet_card_'+time).css('z-index',1000+postSnippetLevel);
					postSnippetLevel++;
					initCards();
				}
				postSnippetX = -1;
				postSnippetY = -1;
			});
		}
		//$('#link_preview_iframe_'+time).bind('load',function(){
		//$('#popup').show();
		//});
	});
	$('body').bind('click',function(){
		$('.post_snippet_card_popup').remove();
		postSnippetX = -1;
		postSnippetY = -1;
		postSnippetLevel = 1;
	});
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