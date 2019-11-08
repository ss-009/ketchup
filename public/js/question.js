$(function(){

	$("#answer_button").on('click', textToModal);
	$("#answer_post").on('click', answerCheck);
	$(".reply-display").on('click', replyDisplayHidden);

});

// text to modal
function textToModal() {
	var answer_word = $('#answer_area').val()
	$('#answer_content_label').text(answer_word);
	$('#answer_content').val(answer_word);
}

// check word count
function answerCheck() {
	var answer_content = $('#answer_content').val();
	var word_count = answer_content.length;
	if(word_count < 5 || word_count > 2000) {
		alert('5文字以上2000文字以下で入力してください。')
		$('#modal_answer').modal('hide');
	} else {
		var formDataArray = $('#answer').serializeArray(); 
		$('#answer').submit();
	}
}

// display or hidden
function replyDisplayHidden() {
	var reply = $(this).parents('.answer-reply').find('.reply-list');
	if (reply.css('display') == 'block') {
		reply.slideUp(400);
	} else {
		reply.slideDown(400);
	}
}

