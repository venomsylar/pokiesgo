<?php
$args = isset($args) ? $args : null;
$item = get_data_from_template('item', $args);
$id = get_data_from_template('id', $args);
$casino_id = get_data_from_template('casino_id', $args);
$index = get_data_from_template('index', $args);
$image = get_the_post_thumbnail_url($casino_id, '180x80');
$default_image = get_field('default_image', 'option')['sizes']['180x80'];
$title = get_the_title($casino_id);
$bonus_type = $item['bonus_type'];
$bonus_value = $item['bonus_value'];
$show_more = $item['show_more'];
$additional_information = $item['additional_information'];

if (count($item) > 0) { ?>
    <div class="casino_bonus_item">
        <div class="casino_bonus_item_position">
            <span class="circled_position"><?php echo $index ?></span>
        </div>
        <div class="casino_bonus_item_image">
            <button data-casino-id="<?php echo $casino_id ?>">
                <img src="<?php echo $image ? $image : $default_image ?>" alt="<?php echo $title ?>">
            </button>
        </div>
	    <div class="casino_bonus_item_name">
		    <strong><?php echo $bonus_type ?></strong>
		    <span>
                <?php
                if($id === $casino_id) {
	                echo $title;
                } else { ?>
	                <a href="<?php echo get_the_permalink($casino_id); ?>"><?php echo $title ?></a>
                <?php }
                ?>
            </span>
	    </div>
        <div class="casino_bonus_item_info">
            <strong><?php echo $bonus_value ?></strong>
            <?php if($show_more) { ?>
                <span class="show_info">T&Cs Apply</span>
                <div class="casino_bonus_item_additional_info">
                    <?php echo $additional_information ?>
                </div>
            <?php } else { ?>
                <span>bonus money</span>
            <?php } ?>
        </div>
        <div class="casino_bonus_item_button">
	        <button class="button" data-casino-id="<?php echo $casino_id ?>">
		        <span class="anim"></span>
		        <span>Use Bonus</span>
	        </button>
        </div>
    </div>
<?php }