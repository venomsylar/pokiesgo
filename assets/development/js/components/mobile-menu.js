export default function getMobileMenu() {
	let menu = $('.js_main_menu'),
		menuButton = $('.js_hamburger'),
		body = $('body');
	menu.find('li.menu-item-has-children').append('<span class="subMenuButton i-angle-down"></span>');

	$(document).on('click touchstart', function (e) {
		let selector = $('#main_menu,#menu_open');
		if (!selector.is(e.target) && selector.has(e.target).length === 0) {
			selector.removeClass('opened');
			menuButton.removeClass('opened');
			body.removeClass('shadow');
		}
	});

	menuButton.on('click', function () {
		menu.toggleClass('opened');
		$(this).parent().toggleClass('opened');
		$(this).toggleClass('opened');
		body.toggleClass('shadow');
	});

	$('.subMenuButton').on('click', function () {
		if ($(this).hasClass('open')) {
			$(this).removeClass('open').prev().slideUp(300);
		} else {
			$(this).prev().slideDown(300);
			$(this).addClass('open');
		}
	});
}