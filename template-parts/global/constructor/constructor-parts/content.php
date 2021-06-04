<?php
$args = isset($args) ? $args : null;
$content_first_part = get_data_from_template('first_part_visible', $args);
$content_second_part = get_data_from_template('second_part_hidden', $args);
$index = get_data_from_template('index', $args);
$content = set_toc_heading_id($content_first_part,$content_second_part, $index);
if (count($content) > 0) { ?>
    <div class="content_block">
        <div class="container">
            <div class="content_block_first_part">
                <?php echo $content['first'] ?>
            </div>
            <?php if ($content['second']) { ?>
                <div class="content_block_second_part hidden">
                    <?php echo $content['second'] ?>
                </div>
                <span class="content_button">Read More</span>
            <?php } ?>
	        <hr>
        </div>
    </div>
<?php }