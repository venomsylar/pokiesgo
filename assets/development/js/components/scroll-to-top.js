export default async function showScrollTop() {
	let toTop = $('#to_top');

	function scrollAction() {
		let windowScroll = $(window).scrollTop();
		windowScroll > 100 ? toTop.addClass('active') : toTop.removeClass('active');
	}

	toTop.on('click', 'a', function (e) {
		e.preventDefault();
		let id = $(this).attr('href'),
				top = $(id).offset().top;
		$('html, body').animate({scrollTop: top}, 1000);
	});
	scrollAction();
	$(window).scroll(function () {
		scrollAction();
	});
}