$(function(){
	$(".best-answer").on('click', choiceBestAnswer);
	$("#best_answer_post").on('click', decisionBestAnswer);
});

// Choice the best answer.
function choiceBestAnswer() {
	var answer_content = $(this).parents('.answer-list').find('.answer-content');
	var answer_id = $(this).parents('.answer-list').find('.answer-id');
	var user_id = $(this).parents('.answer-list').find('.user-id');
	$('#best_answer_content_label').text(answer_content.text());
	$('#best_answer_id').val(answer_id.val());
	$('#user_id').text(user_id.text());
}

// Determine the best answer.
function decisionBestAnswer() {
	// コメントの文字数を取得
	var last_comment = $('#last_comment').val();
	var word_count = last_comment.length;
	// 文字数チェック
	if(word_count < 5 || word_count > 40) {
		alert('5文字以上40文字以下で入力してください。')
	// 文字数OK時submit
	} else {
		// ページIDを取得しフォームに追加する
		var page_id = location.pathname.match( /[^/]+$/i )[0];
		var best_answer_form = $('#best_answer');
		best_answer_form.append($('<input />', {
			type: 'hidden',
			name: 'page_id',
			value: page_id,
		}));
		best_answer_form.submit();
	}
}