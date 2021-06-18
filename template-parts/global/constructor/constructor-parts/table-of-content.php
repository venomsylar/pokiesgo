<?php
$args = isset($args) ? $args : null;
$toc_headings = [];
$constructor_toc_headings = [];
$left_side_text = get_data_from_template('left_side_text', $args);
$id = get_queried_object_id();
$index = 0;
if (is_tax()) {
    $entity_id = 'term_id';
    $table = 'termmeta';
    $term = get_term( $id );
    $taxonomy = $term->taxonomy;
    $constructor = get_field('constructor', $taxonomy . '_' . $id);
} else {
    $entity_id = 'post_id';
    $constructor = get_field('constructor', $id);
    $table = 'postmeta';
}

if (is_array($constructor)) {
    foreach ($constructor as $constructor_item) {
        switch ($constructor_item['acf_fc_layout']) {
            case 'providers_or_payments' : {
                if ($constructor_item['accordion_category'] === 'provider') {
                    $constructor_toc_headings[$index][0] = get_field('providers_accordion', 'option')['title'];
                } elseif ($constructor_item['accordion_category'] === 'payment') {
                    $constructor_toc_headings[$index][0] = get_field('payments_accordion', 'option')['title'];
                }
            } break;
            case 'categories';
            case 'table_of_content';
            case 'content_block';
            case 'slots';
            case 'single_bonus';
            case 'author';
            case 'news_block';
            case 'advantages';
            case 'all_bonus_list': break;
            default : {
            	if ($constructor_item['title']) {
		            $constructor_toc_headings[$index][0] = $constructor_item['title'];
	            }
            }
        }
        $index++;
    }
}

$constructor_count = get_data_from_template('constructor_count', $args);

$visible_content = get_toc_headings('_first_part_visible', $table, $entity_id);
$hidden_content = get_toc_headings('_second_part_hidden', $table, $entity_id);

$visible_headings = set_toc_headings_array($visible_content);
$hidden_headings = set_toc_headings_array($hidden_content);

for ($i = 0; $i <= $constructor_count; $i++) {
    $array = array_merge(
        check_heading_by_key($visible_headings, $i),
        check_heading_by_key($hidden_headings, $i),
        check_heading_by_key($constructor_toc_headings, $i));
    $toc_headings[$i] = $array;
}

if (count($toc_headings) > 0) { ?>
    <div class="table_of_content_block <?php echo $left_side_text ? 'float' : '' ?>">
        <div class="container">
	        <?php if($left_side_text) { ?>
		        <div class="table_of_content_text">
			        <?php echo $left_side_text ?>
		        </div>
	        <?php } ?>
	        <div class="table_of_content_wrap">
		        <h2>Contents</h2>
		        <div class="table_of_content">
			        <ul>
				        <?php
				        $index_for_hide = 1;
				        foreach ($toc_headings as $key => $heading): ?>
					        <?php
					        if (count($heading) > 0) {
						        if (count($heading) > 1) {
							        foreach ($heading as $k => $h) { ?>
								        <li class="<?php echo $index_for_hide > 5 ? 'hide' : '' ?>">
									        <a href="<?php echo '#toc_content_' . $key . '_heading_' . $k . '' ?>"><?php echo $h ?></a>
								        </li>

							        <?php $index_for_hide++; }
						        } else { ?>
							        <li class="<?php echo $index_for_hide > 5 ? 'hide' : '' ?>">
								        <a href="<?php echo '#toc_content_' . $key . '_heading_0' ?>"><?php echo $heading[0] ?></a>
							        </li>
						        <?php $index_for_hide++; }
					        }
					        ?>
				        <?php endforeach; ?>
			        </ul>
			        <?php
			            if ($index_for_hide > 5) { ?>
				            <button class="toc_show_toggle hide">Show more</button>
			            <?php }
			        ?>
		        </div>
	        </div>
        </div>
    </div>
<?php } ?>