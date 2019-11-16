$(function(){
	$("#count_good").on('click', goodQuestion);
	// $("#best_answer_post").on('click', decisionBestAnswer);
});

// good question
function goodQuestion() {

	var question_id = location.pathname.match( /[^/]+$/i )[0];

	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url     : '/question/good_question',
		data    : {
			'question_id' : question_id
		},
		type    : 'POST',
		dataType: 'json',
		success: function(data){
			console.log(data);
		}
	});

}