<?php
require_once 'SQL.php';

function table_filtering() {
	$index = 1;
	$page_id = get_queried_object_id();
	$hidden_index = get_field('hide_rows_after', 'options');

	$data = isset($_POST["tableFilterData"]) ? unserialize( stripslashes( $_POST['tableFilterData'] ) ) : null;

	$payments = json_decode($_POST["tableFilterPayments"]);
	$software = json_decode($_POST["tableFilterSoftware"]);
	$sorting = isset($_POST["tableSorting"]) ? $_POST["tableSorting"] : null;

	$result = table_filter_controller($data, $sorting ,[
		'payments' => $payments,
		'software' => $software
	]);

	$items_page_link = isset($_POST["itemsPageLink"]) ? $_POST["itemsPageLink"] : '';
	$items_page_name = isset($_POST["itemsPageName"]) ? $_POST["itemsPageName"] : '';
 ?>

	<tbody>
	<?php
	$hidden = false;
	$index_for_hidden_row = 1;
	foreach($result['data'] as $table_item):
		if($page_id !== $table_item) {
			$index_for_hidden_row > $hidden_index && $hidden = true;
			get_template_part('template-parts/global/constructor/constructor-parts/table/table-item', 'table-item', [
					'table-item' => $table_item,
					'highlighted' => $index < 4,
					'index' => $index++,
					'hidden' => $hidden,
					'hide_payments' => false
			]);
			$index_for_hidden_row ++;
		}
		?>
	<?php endforeach; ?>
	<tr class="table_buttons_wrap">
		<td class="for_button">
			<?php
			if( $items_page_link && $items_page_name ) { ?>
				<a href="<?php echo $items_page_link ?>"><?php echo $items_page_name ?></a>
			<?php } else { ?>
				<a href="<?php echo site_url() . '/online-casinos/' ?>">All casino</a>
			<?php } ?>
		</td>
		<?php if($result['count'] > $hidden_index) { ?>
			<td data-count="<?php echo $hidden_index ?>" class="expand_table i-angle-down">
				More casino
			</td>
		<?php } ?>
	</tr>
	</tbody>

	<?php die();
}
add_action('wp_ajax_table_filtering', 'table_filtering');
add_action('wp_ajax_nopriv_table_filtering', 'table_filtering');