$(function(){

	// Dropdown set
	$('.dropdown-menu .dropdown-item').on('click', setDropdownList)

	// Dropdown TAB-key
	$("body").keyup(keyPressTabKey);

	// Remove class when out of focus
	$('#refine').blur(removeClass);
	$('#sort').blur(removeClass);

	// Sort questions
	$('#sort').change(sortQuestions);

	// Click page navigation
	if($('.page-link').length) {
		$('.page-link').on('click', clickPageNavigation)
	}

	// tooltip
	$('.sns-auth-span').tooltip({
		title		: '※ 対応予定',
		placement	: 'bottom',
		trigger		: 'hover'
	});

	// For sort
	// $('.page-link').removeAttr('href');
});

/* Set dropdown list */
function setDropdownList() {
	var select = $('.dropdown-toggle', $(this).closest('.dropdown'));
	select.text($(this).data('name'));
}

/* Display a border when the tab key is pressed and the dropdown is selected */
function keyPressTabKey(e) {
	if (e.keyCode === 9) {
		if ($('#refine').is(':focus') === true) {
			$('#refine').addClass("form-control-focus");
		} else if ($('#sort').is(':focus') === true) {
			$('#sort').addClass("form-control-focus");
		}
	}
}

/* Remove class when out of focus */
function removeClass() {
	$(this).removeClass("form-control-focus");
}

/* Sort questions */
function sortQuestions() {
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		url     : '/question/sort_question',
		data    : { 'sort' : $('#sort').val() },
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

/* Click page navigation */
function clickPageNavigation() {

	// $('.pagination').find('.active').removeClass('active');
	// $(this).addClass('active');

	// var click = $(this).text();

	// if(active !== 1 && click === '<') {
	// 	next_active = active - 1;
	// }
	// if(active !== 4 && click === '>') {
	// 	next_active = active + 1;
	// }

	// if($('.page-num').text() == next_active) {
	// 	$(this).addClass('active');
	// }

	// var active = $('.pagination').find('.active').text();


	// $.ajax({
	// 	headers: {
	// 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 	},
	// 	url     : '/question/sort_question',
	// 	data    : { 'sort' : $('#sort').val() },
	// 	type    : 'POST',
	// 	dataType: 'json',
	// 	success: function(data){
	// 		if (data['status_code'] === 200) {
	// 			if (data['user_status'] === 1) {
	// 				$('#count_good').addClass("question-good");
	// 			} else {
	// 				$('#count_good').removeClass("question-good");
	// 			}
	// 			$('#count_good').find('p').text(data['good_count']);
	// 		}
	// 	}
	// });
}