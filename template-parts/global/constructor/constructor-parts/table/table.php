<?php
$args = isset($args) ? $args : null;
$top3 = get_data_from_template('top-3', $args);
$title = get_data_from_template('title', $args);
$hide_payments = get_data_from_template('hide_payments', $args);
$constructor_index = get_data_from_template('index', $args);
$custom_table = get_data_from_template('custom', $args);
$all_casino_link = get_data_from_template('all-casino-link', $args);
$show_all = get_data_from_template('show-all', $args);
$table = [];
$index = 1;
$hidden_index = get_field('hide_rows_after', 'options');
$all_casinos_table = get_field('all_casinos_table', 'option');
$heading_id = 'toc_content_'.$constructor_index.'_heading_0';
$page_id = get_queried_object_id();
//Get Table Items
if ($custom_table) {
    $table = $custom_table;
} elseif(is_tax()) {
    $table = get_table_for_taxonomy_page($all_casinos_table);
} elseif (is_author()) {
	global $author;
	$table = filter_casinos_by_author($author, $all_casinos_table);
}
else {
    $table = $all_casinos_table;
}
//Add Top 3 block
if ($top3) {
    if (count($table) > 3) {
        $table = array_slice($table, 3, count($table));
    }
    $index = 4;
    $hidden_index = $hidden_index - 3;
}


//Return Table
if ($table) { ?>
    <div class="table <?php echo !$hide_payments ? 'with_payments' : 'without_payments' ?>">
        <?php if ($top3) { ?>
            <?php get_template_part('/template-parts/global/constructor/constructor-parts/top-3-casino', null, [
                'title' => $title,
                'index' => $constructor_index
            ]);
        } ?>
        <div class="container">
            <?php echo !$top3 && $title ? '<h2 id="'.$heading_id.'">'.$title.'</h2>' : '';
	            if ($top3) { ?>
	            	<div class="table_advantages">
			            <span class="table_advantage">Secure</span>
			            <span class="table_advantage">Verified</span>
			            <span class="table_advantage">Trusted</span>
		            </div>
	            <?php }
	        ?>
            <table>
                <thead>
                <tr>
                    <th class="heading_rating">№</th>
                    <th class="heading_casino">Casino</th>
                    <th class="heading_bonus">Bonus</th>
                    <th class="heading_play">Play</th>
                    <th class="heading_review">Review</th>
                    <?php echo !$hide_payments ? '<th class="heading_deposit">Deposit Methods</th>' : ''?>
                </tr>
                </thead>
                <tbody>
                <?php
                $hidden = false;
                $index_for_hidden_row = 0;
                foreach($table as $table_item):
	                if($page_id !== $table_item && (get_post_status($page_id) === 'publish' || is_author())) {
	                	if (!$show_all) {
			                $index_for_hidden_row >= $hidden_index && $hidden = true;
		                }
		                get_template_part('template-parts/global/constructor/constructor-parts/table/table-item', 'table-item', [
				                'table-item' => $table_item,
			                    'highlighted' => !$top3 && $index < 4,
				                'index' => $index++,
				                'hidden' => $hidden,
			                    'hide_payments' => $hide_payments
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
	                <?php if(count($table) > $hidden_index && !$show_all) { ?>
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