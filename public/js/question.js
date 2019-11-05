$(function(){

	$("#answer_button").on('click', textToModal);
	$("#answer_post").on('click', answerCheck);

});

// Text to modal
function textToModal() {
	var answer_word = $('#answer_area').val()
	$('#answer_content_label').text(answer_word);
	$('#answer_content').val(answer_word);
}

// Check word count
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