<?php
require_once 'table-filter-item.php';
require_once 'table-sorting-item.php';

$table = [];
$index = 1;
$args = isset($args) ? $args : null;
$title = get_data_from_template('title', $args);
$hide_payments = get_data_from_template('hide_payments', $args);
$constructor_index = get_data_from_template('index', $args);
$custom_table = get_data_from_template('custom', $args);
$all_casino_link = get_data_from_template('all-casino-link', $args);
$filter = get_data_from_template('filter', $args);
$hidden_index = get_field('hide_rows_after', 'options');
$all_casinos_table = get_field('all_casinos_table', 'option');
$heading_id = 'toc_content_'.$constructor_index.'_heading_0';
$page_id = get_queried_object_id();
//Get Table Items
if ($custom_table) {
    $table = $custom_table;
} elseif(is_tax()) {
    $table = get_table_for_taxonomy_page($all_casinos_table);
} else {
    $table = $all_casinos_table;
}

$providers_def = $filter['providers'];
$payments_def = $filter['payments'];
$sorting_def = $filter['sorting'];

$result = table_filter_controller($table, $sorting_def ,[
	'payments' => $payments_def,
	'software' => $providers_def
]);
$filtered_table = $result['data'];
//Return Table
if ($filtered_table) {
	$count = $result['count']; ?>
        <div
		    data-casinos="<?php echo serialize($table) ?>"
		    data-default-providers="<?php echo $providers_def ? json_encode($providers_def) : '' ?>"
		    data-default-payments="<?php echo $payments_def ? json_encode($payments_def) : '' ?>"
		    data-default-sorting="<?php echo $sorting_def ?: '' ?>"
		    data-all-items-link="<?php echo $all_casino_link['link'] ?: '' ?>"
		    data-all-items-name="<?php echo $all_casino_link['link'] ? $all_casino_link['name'] : '' ?>"
		    data-loaded="false"
		    class="table with_payments table_with_filter">
        <div class="container">
            <?php echo $title ? '<h2 id="'.$heading_id.'">'.$title.'</h2>' : ''; ?>
	        <div class="table_filter">
		        <div class="table_filter_items">
			        <strong>Filter:</strong>
			        <?php
			        echo table_filter_item([
				        'title' => 'Provider',
				        'taxonomy' => 'casino-provider'
			        ]);
			        echo table_filter_item([
				        'title' => 'Payment',
				        'taxonomy' => 'casino-payment'
			        ]);
			        ?>
		        </div>
		        <div class="table_order_items">
			        <?php
			        echo table_sorting_item([
					        'title' => 'Sort By',
					        'data' => [
						        [
							        'title' => 'Name',
							        'slug' => 'name'
						        ],
						        [
							        'title' => 'Games Count',
							        'slug' => 'games_count'
						        ],
						        [
							        'title' => 'Newest First',
							        'slug' => 'newest_first'
						        ]
					        ]
			        ]); ?>
		        </div>
	        </div>
            <table>
                <thead>
                <tr>
                    <th class="heading_rating">№</th>
                    <th class="heading_casino">Casino</th>
                    <th class="heading_bonus">Bonus</th>
                    <th class="heading_play">Play</th>
                    <th class="heading_review">Review</th>
                    <th class="heading_deposit">Deposit Methods</th>
                </tr>
                </thead>
                <tbody>
	                <?php
	                $hidden = false;
	                $index_for_hidden_row = 1;
	                foreach($filtered_table as $table_item):
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
			                if( $all_casino_link['link'] && $all_casino_link['name'] ) { ?>
				                <a href="<?php echo $all_casino_link['link'] ?>"><?php echo $all_casino_link['name'] ?></a>
			                <?php } else { ?>
				                <a href="<?php echo site_url() . '/online-casinos/' ?>">All casino</a>
			                <?php } ?>
		                </td>
		                <?php if($count > $hidden_index) { ?>
			                <td data-count="<?php echo $hidden_index ?>" class="expand_table i-angle-down">
				                More casino
			                </td>
		                <?php } ?>
	                </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php }