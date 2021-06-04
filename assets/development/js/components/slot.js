const slot = () => {
	$('.slot_iframe .play_free').on('click', function () {
		const iframe = $(this).parent().next();
		const url = iframe.attr('data-slot-url');
		iframe.attr('src', url);
		iframe.addClass('active');
		$(this).parent().remove();
	});
};
export default slot;