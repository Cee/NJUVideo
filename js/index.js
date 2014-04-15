function fix() {
    var window_width = $('body').width();
    var container_width = $('.container').width();
    var carousel_height = $('.carousel-inner').height();
    var banner_margin_left = (window_width - container_width) / 2;
    var banner_top = carousel_height - 125;
    if (banner_top < 0) {
        banner_top = 0;
    }
    $('.banner-logo').css("margin-left", banner_margin_left);
    $('.banner-logo').css("top", banner_top);
    $('#navBar').css("width", window_width);
}

$(document).ready(function () {
	fix();
	$(window).resize(function () {
		fix();
	});
})