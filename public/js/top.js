$(function(){

	// Dropdown set
	$('.dropdown-menu .dropdown-item').on('click', setDropdownList);

	// Dropdown TAB-key
	$("body").keyup(keyPressTabKey);

	// Remove class when out of focus
	$('#refine').blur(removeClass);
	$('#sort').blur(removeClass);

	// Sort questions
	$('#sort').change(sortQuestions);

	// tooltip
	$('.sns-auth-span').tooltip({
		title		: '※ 対応予定',
		placement	: 'bottom',
		trigger		: 'hover'
	});
	
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
	var arg  = new Object;
	url = location.search.substring(1).split('&');
	for(i=0; url[i]; i++) {
		var k = url[i].split('=');
		arg[k[0]] = k[1];
	}
	var q = arg.q;
	if(q == null){
		href = "?sort=" + $('#sort').val();
	}else{
		href = "?q=" + q + "&sort=" + $('#sort').val();;
	}
	location.href = href;
}