import tableFiltering from "./table-filtering";

const tableFilteringHandler = () => {
	$('.table_filter input').on('change', function() {
		tableFiltering();
	});
	$('.table_filter .table_sorting_item li').on('click', function() {
		$('.table_sorting_item li').not(this).removeClass('active');
		$(this).toggleClass('active');
		tableFiltering();
	});
}
export default tableFilteringHandler;