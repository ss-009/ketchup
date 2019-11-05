$(function(){

	$("answer_post").on('click', answerCheck);


});

// Check word count
function answerCheck() {
	alert($('answer_area').val());
	var word_count = $('answer_content').text().length;
	if(word_count < 5 || word_count > 2000) {
		alert('5文字以上2000文字以下で入力してください。')
	} else {

	}
}