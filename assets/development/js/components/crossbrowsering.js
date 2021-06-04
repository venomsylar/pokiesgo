import { detect } from 'detect-browser';

/**
 * Detect Browser and OS
 */

export default function detectBrowserAndOS() {
	let siteBody = $('body');
	const browser = detect();
	if (browser) {
		siteBody.attr('data-browser', browser.name);
		siteBody.attr('data-browser-version', browser.version);
		siteBody.attr('data-os', browser.os);
		if (browser.name === 'ie' && Math.round(parseInt(browser.version)) <= 10) {
			updateYourBrowser(Math.round(parseInt(browser.version)));
		}
	}
}

/**
 * Warning for browser update
 */
function updateYourBrowser($BrowserVersion) {
	$('body').append(
			'<div class="browser_update_alert">' +
			'<div class="browser_update_alert_wrap">' +
			'<h3>Your browser (Internet Explorer ' + $BrowserVersion + ') is out of date. <br> Upgrade your browser to improve the security, speed and performance of this site.</h3>' +
			'<p><a target="_blank" rel="nofollow noopener" href="https://www.microsoft.com/en-us/download/internet-explorer.aspx">Click to update</a></p>' +
			'</div>' +
			'</div>'
	);
}