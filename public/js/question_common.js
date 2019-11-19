$(function(){
	$(".reply-display").on('click', displayOrHiddenReply);
	$(".reply-button").on('click', replyToModal);
	$("#reply_post").on('click', writeReply);
});

// show or hide replies
function displayOrHiddenReply() {
	var reply = $(this).parents('.answer-reply').find('.reply-list');
	if (reply.css('display') == 'block') {
		reply.slideUp(400);
	} else {
		reply.slideDown(400);
	}
}

// reply to modal
function replyToModal() {
	var reply_word = $(this).parents('.reply-write-content').find('.reply-area').val();
	word_count = reply_word.length;
	if(word_count < 5 || word_count > 1000) {
		alert('5文字以上1000文字以下で入力してください。')
		return false;
	}
	$('#answer_id').val($(this).parents('.reply-write-content').find('.answer-id').val());
	$('#reply_content_label').text(reply_word);
	$('#reply_content').val(reply_word);
}

// write reply
function writeReply() {
	// 返信の値と文字数を取得
	var reply_content = $('#reply_content').val();
	var word_count = reply_content.length;
	// 文字数チェック
	if(word_count < 5 || word_count > 1000) {
		alert('5文字以上1000文字以下で入力してください。')
		return false;
	// 文字数OK時submit
	} else {
		// ページIDを取得しフォームに追加する
		var page_id = location.pathname.match( /[^/]+$/i )[0];
		var reply_form = $('#reply');
		reply_form.append($('<input />', {
			type: 'hidden',
			name: 'page_id',
			value: page_id,
		}));
		reply_form.submit();
	}
}