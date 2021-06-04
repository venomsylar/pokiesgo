import dynamicSelect from './components/dynamic-modules/dynamic-select';
import dynamicGoogleRating from './components/dynamic-modules/dynamic-google-rating'
import getMobileMenu from './components/mobile-menu';
import showScrollTop from './components/scroll-to-top';
import detectBrowserAndOS from './components/crossbrowsering';
import privacyPolicy from './components/privacy-policy';
import contactForm7 from './components/contact-form-7';
import toReferral from './components/referral';
import contentReadMore from './components/content';
import tableExpand from './components/expand-table';
import slotExpand from './components/slots-expand';
import taxAccordion from './components/accordion';
import slot from './components/slot';
import tableOfContent from './components/table-of-content';
import popUps from './components/pop-up';
import languageMenu from './components/language-menu';

import tableFilteringHandler from './components/filter/table-filtering-handler';
import tableFilterItemHandler from './components/filter/table-filter-item-handler';
import tableFiltering from './components/filter/table-filtering';

jQuery(document).ready(async () => {
	// TableFilter
	tableFiltering();
	tableFilteringHandler();
	tableFilterItemHandler($('[datatype="casino-provider"] .table_filter_item_title'));
	tableFilterItemHandler($('[datatype="casino-payment"] .table_filter_item_title'));
	tableFilterItemHandler($('.table_sorting_item_title'));
	//Lang menu
	languageMenu();
	//Popup
	popUps();
	//Browser detect
	detectBrowserAndOS();
	/*Menu*/
	getMobileMenu();
	//Slot
	slot();
	//table of content
	tableOfContent();
	/*Privacy*/
	privacyPolicy();
	//Contact Form 7
	contactForm7();
	//Buttons functional
	toReferral();
	//Content Read More
	contentReadMore();
	//Expand Table
	tableExpand();
	//Expand Slots
	slotExpand();
	//Provider Accordion
	taxAccordion(0);
	//Dynamic elements
	await showScrollTop();
	await dynamicSelect();
	await dynamicGoogleRating();
});
