<?php
$args = isset($args) ? $args : null;
$accordion_type = get_data_from_template('accordion-type', $args);
$accordion_schema_type = get_data_from_template('accordion-schema-type', $args);
$accordion_data = get_data_from_template('accordion-data', $args);
$index = get_data_from_template('index', $args);
$heading_id = 'toc_content_'.$index.'_heading_0';
$taxonomy = '';
switch ($accordion_type) {
    case 'taxonomy': {
        switch ($accordion_data) {
            case 'provider' : {
                $group = get_field('providers_accordion', 'option');
                $taxonomy = 'casino-provider';
            } break;
            case 'payment': {
                $group = get_field('payments_accordion', 'option');
                $taxonomy = 'casino-provider';
            } break;
            default : {
                $group = [];
                $taxonomy = '';
            }
        }
        $heading = $group['title'];
        $subtitle = $group['subtitle'];
        $list = $group['list'];
    } break;
    case 'custom' : {
        $list = $accordion_data['data'];
        $heading = $accordion_data['title'];
        $subtitle = $accordion_data['subtitle'];
    } break;
    default : {
        $heading = '';
        $subtitle = '';
        $list = '';
        $taxonomy = '';
    }
}
if(is_array($list)) { ?>
    <section class="accordion">
        <div class="container">
	        <?php echo $heading ? '<h2 id="'.$heading_id.'">'.$heading.'</h2>' : '';
	        echo $subtitle ? $subtitle : '';
	        if($accordion_schema_type) { ?>
	        <dl class="accordion_wrap">
		        <?php foreach($list as $item):
			        $title = $item['title'];
			        $info = $item['info']; ?>
		        <dt class="accordion_item">
				        <div class="accordion_item_type" itemscope itemtype="https://schema.org/FAQPage">
					        <div class="accordion_items_cope" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
						        <div class="accordion_itemprop" itemprop="name">
							        <h5 class="accordion_title"><?php echo $title ?></h5>
						        </div>
						        <div class="accordion_items_cope_info" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
							        <div class="accordion_itemprop_info" itemprop="text">
								        <div class="accordion_info"><?php echo $info ?></div>
							        </div>
						        </div>
					        </div>
				        </div>
			        </dt>
		        <?php endforeach; ?>
	        </dl>
	        <?php } else { ?>
		        <dl class="accordion_wrap">
			        <?php foreach($list as $item):
				        if ($accordion_type === 'taxonomy') {
					        $title = $item->name;
					        $short_name = get_field('short_name', $taxonomy . '_' . $item->term_id);
					        $title = $short_name ? $short_name : $title;
					        $info = get_field('short_description', $taxonomy . '_' . $item->term_id);
				        } else {
					        $title = $item['title'];
					        $info = $item['info'];
				        } ?>
				        <dt class="accordion_item">
					        <div class="accordion_item_type">
						        <div class="accordion_items_cope">
							        <div class="accordion_itemprop">
								        <h5 class="accordion_title"><?php echo $title ?></h5>
							        </div>
							        <div class="accordion_items_cope_info">
								        <div class="accordion_itemprop_info">
									        <div class="accordion_info"><?php echo $info ?></div>
								        </div>
							        </div>
						        </div>
					        </div>
				        </dt>
			        <?php endforeach; ?>
		        </dl>
	        <?php } ?>
        </div>
    </section>
<?php } ?>