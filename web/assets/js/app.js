window.onload = function() {
	appInit();
};

function appInit(){
	checkAJAX();
	initScrollButtons();
	initPostForm();
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
		console.log('debug');
		$('.upload_media').click();
	});
}

function reqAJAX(subURI = '/', method = 'GET', params = {}, async = false){
	var URI = '/ajax/'+subURI;
	var res = {};
	$.ajax({
		method:method,
		url:URI,
		data:JSON.stringify(params),
		cache:false,
		dataType:'json',
		contentType: 'application/json',
		async:async
	}).done(function(data){
		if(
			data.status !== 'undefined' &&
			data.status &&
			data.data !== 'undefined'
		){
			res = data.data;
		}
		res = data;
	});
	return res;
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