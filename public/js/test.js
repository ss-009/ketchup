$(function(){

	$('#test_button').on('click',function(){
		$.ajax({
			url		: 'api/test',
			data	: {
				id  	: 'test_id',
				name	: 'test_name'
			},
			type	: 'POST',
			dataType: 'json',
			success: function(data){
				console.log(data);
			}
		});	
	});

	$('#upload_button').on('click',function(){
		// フォームデータを取得
		var formdata = new FormData($('#upload_form').get(0));
		// Ajaxでアップロード
		$.ajax({
			url         : 'api/upload',
			type        : 'POST',
			dataType    : 'text',
			data        : formdata,
			contentType : false,
			processData : false,
		})
		.done(function(data, textStatus, jqXHR){
			console.log(data);
		})
		.fail(function(jqXHR, textStatus, errorThrown){
			console.log('fail');
		});
	});
});