const tableFilterItemHandler = (selector) => {
	selector.on('click', function() {
		$(this).toggleClass('active');
		$(this).next().toggleClass('active');
	});

	const close = (e) => {
		const nextEl = selector.next();
		if ((!selector.is(e.target) && selector.has(e.target).length === 0) && (!nextEl.is(e.target) && nextEl.has(e.target).length === 0)) {
			nextEl.removeClass('active');
			nextEl.prev().removeClass('active');
		}
	}

	$(document).on('mouseup', function (e) {
		close(e);
	});
	$(document).on('scroll', function (e) {
		close(e);
	});
}

export default tableFilterItemHandler;