$(function(){
	$(".best-answer").on('click', decisionBestAnswer);
});

// Determine the best answer.
function decisionBestAnswer() {

	var answer_content = $(this).parents('.answer-list').find('.answer-content');
	var answer_id = $(this).parents('.answer-list').find('.answer-id');
	var user_id = $(this).parents('.answer-list').find('.user-id');

	$('#best_answer_content_label').text(answer_content.text());
	$('#best_answer_id').val(answer_id.val());
	$('#user_id').text(user_id.text());

	// // コメントの文字数を取得
	// var answer_content = $('#best_answer_content_label').val();
	// var word_count = answer_content.length;

	// // 文字数チェック
	// if(word_count < 3 || word_count > 2000) {
	// 	alert('5文字以上2000文字以下で入力してください。')
	// 	$('#modal_answer').modal('hide');

	// // 文字数OK時submit
	// } else {

	// 	// ページIDを取得しフォームに追加する
	// 	var page_id = location.pathname.match( /[^/]+$/i )[0];
	// 	var answer_form = $('#answer');
	// 	answer_form.append($('<input />', {
	// 		type: 'hidden',
	// 		name: 'page_id',
	// 		value: page_id,
	// 	}));

	// 	answer_form.submit();
	// }
}