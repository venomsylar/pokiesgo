import tableExpand from "../expand-table";

const tableFiltering = () => {
	const getCheckedItems = (array) => {
		const result = [];
		array.each(function() {
			const item = $(this)[0];
			if (item.checked) {
				result.push(parseInt($(this).attr('data-term-id')));
			}
		})
		return result;
	}
	const checkDefaultFilter = ($array, $checked_array) => {
		$array.each(function () {
			const term_id = $(this).attr('data-term-id');
			if ($checked_array && $checked_array.includes(parseInt(term_id))) {
				$(this).attr('checked', 'checked');
			}
		});
	}

	const table = $('.table_with_filter table thead');
	const table_with_filter = $('.table_with_filter');
	const table_body = $('.table_with_filter table');
	const table_data = table_with_filter.attr('data-casinos');
	const items_page_link = table_with_filter.attr('data-all-items-link');
	const items_page_name = table_with_filter.attr('data-all-items-name');
	const loaded = table_with_filter.attr('data-loaded');
	const payments = $('[datatype="casino-payment"] input');
	const software = $('[datatype="casino-provider"] input');
	const sorting = $('[datatype="sorting"] li.active').attr('data-slug');
	const checkedPayments = getCheckedItems(payments);
	const checkedSoftware = getCheckedItems(software);

	const default_payments_attr = table_with_filter.attr('data-default-payments');
	const default_providers_attr = table_with_filter.attr('data-default-providers');
	const default_sorting = table_with_filter.attr('data-default-sorting');
	const default_providers = default_providers_attr ? JSON.parse(default_providers_attr) : '';
	const default_payments = default_payments_attr ? JSON.parse(default_payments_attr) : '';

	//default checking
	if (default_sorting) {
		$(`[datatype="sorting"] li[data-slug=${default_sorting}]`).addClass('active');
	}
	if (default_payments) {
		checkDefaultFilter(payments, default_payments);
	}
	if (default_providers) {
		checkDefaultFilter(software, default_providers);
	}
	//data
	const data = {
		'action': 'table_filtering',
		'tableFilterData': table_data,
		'itemsPageLink': items_page_link,
		'itemsPageName': items_page_name,
		'tableFilterPayments': JSON.stringify(checkedPayments),
		'tableFilterSoftware': JSON.stringify(checkedSoftware),
		'tableFilterDefaultPayments': JSON.stringify(default_payments),
		'tableFilterDefaultProviders': JSON.stringify(default_providers),
		'tableFilterDefaultSorting': default_sorting,
		'tableSorting': sorting || ''
	};
	loaded === 'true' ? table_body.addClass('loading') : '';
	$.ajax({
		url: '/wp-admin/admin-ajax.php',
		data:data,
		type:'POST',
		success:function(data) {
			loaded === 'true' ? table.next().remove() : '';
			table_with_filter.attr('data-default-payments', '');
			table_with_filter.attr('data-default-providers', '');
			table_with_filter.attr('data-default-sorting', '');
			loaded === 'true' ? table.after(data) : '';
			loaded === 'true' ? table_body.removeClass('loading') : '';
			loaded === 'false' ? table_with_filter.attr('data-loaded', 'true') : '';
		}
	});
}
export default tableFiltering;