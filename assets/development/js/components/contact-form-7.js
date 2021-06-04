export default function contactForm7() {
	$(document).on('click', '.wpcf7-not-valid-tip', function () {
		$(this).prev().trigger('focus');
		$(this).fadeOut(500, function () {
			$(this).remove();
		});
	});
}