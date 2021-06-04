/*table expand*/
const slotExpand = () => {
	const button = $('.slot_expand');
	button.on('click',function () {
		const expandCount = $(this).attr('data-count');
		if ($(this).hasClass('active')) {
			$(this).text('Load more');
			let top = $(button).parent().parent().parent().offset().top;
			$('html, body').animate({scrollTop: top}, 700);
		} else {
			$(this).text('Show less');
		}
		console.log($(this).parent().parent().find('.hidden_slot'));
		$(this).parent().parent().find('.slots_list_item').each(function(index, element) {
			if(index >= expandCount){
				$(this).toggleClass('hidden_slot');
			}
		});
		$(this).toggleClass('active');
	});
};

export default slotExpand;