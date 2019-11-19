$(function(){
	$("#count_good").on('click', goodQuestion);
	$(".answer-good").on('click', goodAnswer);
});

// good question
function goodQuestion() {
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url     : '/question/good_question',
		type    : 'POST',
		dataType: 'json',
		success: function(data){
			if (data['status_code'] === 200) {
				if (data['user_status'] === 1) {
					$('#count_good').addClass("question-good");
				} else {
					$('#count_good').removeClass("question-good");
				}
				$('#count_good').find('p').text(data['good_count']);
			}
		}
	});
}

// good answer
function goodAnswer() {
	var good_answer = $(this);
	var answer_id = good_answer.parents('.answer-list').find('.answer-id').val();
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url     : '/question/good_answer',
		data    : { 'answer_id' : answer_id },
		type    : 'POST',
		dataType: 'json',
		success: function(data){
			if (data['status_code'] === 200) {
				if (data['user_status'] === 1) {
					good_answer.addClass("question-good");
				} else {
					good_answer.removeClass("question-good");
				}
				good_answer.find('p').text(data['good_count']);
			}
		}
	});
}