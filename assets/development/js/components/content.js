const contentReadMore = () => {
	const button = $('.content_button');
	button.on('click', function() {
		$(this).prev().toggleClass('hidden');
		$(this).text() === 'Read More' ? $(this).text('Read Less') : $(this).text('Read More');
	});
}

export default contentReadMore;