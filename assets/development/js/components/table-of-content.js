const tableOfContent = () => {
	if($('.table_of_content_block').length > 0) {
		let readMoreContent = $('.content_block_second_part');
		$('.table_of_content a').on("click", function (event) {
			event.preventDefault();
			let toc_id = $(this).attr("href");

			const readMoreContentCurrent = readMoreContent.find(toc_id).parent();
			if(readMoreContentCurrent) {
				if(readMoreContentCurrent.hasClass('hidden')) {
					readMoreContentCurrent.next().click();
				}
			}
			let top = $(toc_id).offset().top;
			$('html, body').animate({scrollTop: top}, 1000);
		});
	}

	$('.toc_show_toggle').on('click', function () {
		const button = $(this);
		if (button.hasClass('hide')) {
			button.text('Show less');
			button.removeClass('hide');
		} else {
			button.text('Show more');
			button.addClass('hide');
		}
		$(this).prev().find('li').each(function(index, element) {
			if(index > 4){
				$(this).toggleClass('hide');
			}
		});
	});
};
export default tableOfContent;