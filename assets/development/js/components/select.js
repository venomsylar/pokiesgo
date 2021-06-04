$('select.js-ui-selector').each(function () {
	let $this = $(this), numberOfOptions = $(this).children('option').length;

	$this.addClass('select-hidden');
	$this.wrap('<div class="select"></div>');
	$this.after('<div class="select-styled"></div>');

	let $styledSelect = $this.next('div.select-styled');
	let selectedID = $(this).attr('data-select-id');
	$styledSelect.text($this.find('option[value="' + selectedID + '"]').text());

	let $list = $('<ul />', {
		'class': 'select-options'
	}).insertAfter($styledSelect);

	for (let i = 0; i < numberOfOptions; i++) {
		$('<li />', {
			text: $this.children('option').eq(i).text(),
			rel: $this.children('option').eq(i).val()
		}).appendTo($list);
	}

	let $listItems = $list.children('li');

	$styledSelect.click(function (e) {
		e.stopPropagation();
		$('div.select-styled.active').not(this).each(function () {
			$(this).removeClass('active').next('ul.select-options').hide();
		});
		$(this).toggleClass('active').next('ul.select-options').toggle();
	});

	$listItems.click(function (e) {
		e.stopPropagation();
		$styledSelect.text($(this).text()).removeClass('active');
		$this.val($(this).attr('rel')).attr('data-select-id', $(this).attr('rel'));
		$list.hide();
	});

	$(document).click(function () {
		$styledSelect.removeClass('active');
		$list.hide();
	});
});