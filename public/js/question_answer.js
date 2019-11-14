$(function(){

	$("#answer_button").on('click', answerToModal);
	$("#answer_post").on('click', checkWriteAnswer);

});

// answer to modal
function answerToModal() {
	var answer_word = $('#answer_area').val()
	var word_count = answer_word.length;

	// 文字数チェック
	if(word_count < 5 || word_count > 2000) {
		alert('5文字以上2000文字以下で入力してください。')
		return false;
	}

	$('#answer_content_label').text(answer_word);
	$('#answer_content').val(answer_word);
}

// check & write answer
function checkAnswer() {

	// 回答の値と文字数を取得
	var answer_content = $('#answer_content').val();
	var word_count = answer_content.length;

	// 文字数チェック
	if(word_count < 5 || word_count > 2000) {
		alert('5文字以上2000文字以下で入力してください。')
		$('#modal_answer').modal('hide');

	// 文字数OK時submit
	} else {

		var page_id = location.pathname.match( /[^/]+$/i )[0];
		var answer_form = $('#answer');
		answer_form.append($('<input />', {
			type: 'hidden',
			name: 'page_id',
			value: page_id,
		}));

		answer_form.submit();
	}
}