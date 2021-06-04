import Cookies from "js-cookie";
export default function privacyPolicy() {
	let privacyBlock = $('#privacy'),
			privacyBlockClose = privacyBlock.find('.privacy_close');
	!Cookies.get('privacy') ? privacyBlock.show() : false;
	privacyBlockClose.on('click', () => {
		privacyBlock.addClass('hide');
		Cookies.set('privacy', 'true', {expires: 1});
	});
}