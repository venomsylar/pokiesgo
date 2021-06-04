const taxAccordion = () => {
	const accordion = $('.accordion');
	const accordionTitle = accordion.find('.accordion_title');
	accordionTitle.click(function() {
		const accParent = $(this).parents().eq(4);
		const accParentTitle = accParent.find('.accordion_title');
		if($(this).hasClass('opened')) {
			accParentTitle.removeClass('opened');
			$(this).parent().next().slideToggle(300);
			accParent.find('.accordion_items_cope_info').slideUp(300);
		} else {
			accParent.find('.accordion_items_cope_info').slideUp(300);
			$(this).parent().next().slideToggle(300);
			accParentTitle.removeClass('opened');
			$(this).addClass('opened');
		}
	});
}
export default taxAccordion;