$(function(){

	// Judgment active flg
	judgmentActiveFlg();

	// Dropdown set
	$('.dropdown-menu .dropdown-item').on('click', setDropdownList);

	// Dropdown TAB-key
	$("body").keyup(keyPressTabKey);

	// Remove class when out of focus
	$('#refine').blur(removeClass);
	$('#sort').blur(removeClass);

	// Sort questions
	$('#sort').change(sortQuestions);
	
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
	var flg = returnFlg();
	if(flg == null){
		href = "?sort=" + $('#sort').val();
	}else{
		href = "?flg=" + flg + "&sort=" + $('#sort').val();;
	}
	location.href = href;
}

/* Judgment active flg */
function judgmentActiveFlg() {
	var flg = returnFlg();
	if(flg == 'a' || flg == 'b'){
		$('#flg_q').removeClass("flg-active");
		if(flg == 'a') {
			$('#flg_a').addClass("flg-active");
		} else if (flg == 'b') {
			$('#flg_b').addClass("flg-active");
		}
	}
}

/* Return flg */
function returnFlg() {
	var arg  = new Object;
	url = location.search.substring(1).split('&');
	for(i=0; url[i]; i++) {
		var k = url[i].split('=');
		arg[k[0]] = k[1];
	}
	var flg = arg.flg;
	return flg;
}