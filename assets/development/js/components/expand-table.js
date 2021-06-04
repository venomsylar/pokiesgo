/*table expand*/
const tableExpand = () => {
	$(document).on('click', '.expand_table',function () {
		const expandCount = $(this).attr('data-count');
		if ($(this).hasClass('active')) {
			$(this).text('More casino');
			let top = $(this).closest('.table').offset().top;
			$('html, body').animate({scrollTop: top}, 700);
		} else {
			$(this).text('Less casino');
		}
		$(this).parent().parent().find('tr:not(.table_buttons_wrap)').each(function(index, element) {
			if(index > expandCount){
				$(this).toggleClass('hidden_row');
				$(this).next('.table_spacer').toggleClass('hidden_row');
			}
		});
		$(this).toggleClass('active');
	});
};

export default tableExpand;