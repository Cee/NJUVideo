function fix() {
    var window_width = $('body').width();
    $('#navBar').css("width", window_width);
}

$(document).ready(function () {
	fix();
	$(window).resize(function () {
		fix();
	});
})