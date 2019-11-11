$(function(){

	$("#answer_button").on('click', textToModal);
	$("#answer_post").on('click', checkAnswer);
	$(".reply-display").on('click', displayOrHiddenReply);
	$(".reply-button").on('click', writeReply);

});

// text to modal
function textToModal() {
	var answer_word = $('#answer_area').val()
	$('#answer_content_label').text(answer_word);
	$('#answer_content').val(answer_word);
}

// check answer, word count.
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

		// ページIDを取得しフォームに追加する
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

// show or hide replies
function displayOrHiddenReply() {
	var reply = $(this).parents('.answer-reply').find('.reply-list');
	if (reply.css('display') == 'block') {
		reply.slideUp(400);
	} else {
		reply.slideDown(400);
	}
}

// write reply
function writeReply() {

	// 返信の値と文字数を取得
	var reply_content = $(this).parents('.reply-write-content').find('.reply-area').val();
	var word_count = reply_content.length;

	// 文字数チェック
	if(word_count < 5 || word_count > 2000) {
		alert('5文字以上2000文字以下で入力してください。')
		return false;
	
	// 文字数OK時submit
	} else {

		// ページIDを取得しフォームに追加する
		var page_id = location.pathname.match( /[^/]+$/i )[0];
		var reply_form = $(this).parents('.reply-write-content').find('.reply');
		reply_form.append($('<input />', {
			type: 'hidden',
			name: 'page_id',
			value: page_id,
		}));

		reply_form.submit();
	}
}