const languageMenu = () => {
	$('#languageMenu .activeItem').on('click', function () {
		$(this).next().toggleClass('active');
	});
};

export default languageMenu;