<?php
$args = isset($args) ? $args : null;
$active = isset($args['active']) ? $args['active'] : null;
$id = isset($args['id']) ? $args['id'] : null;
$rating_value = get_field('google_rating',$id) ? get_field('google_rating',$id) : 0;
$rating_count = get_post_meta($id, 'g_rating_count', true) ? get_post_meta($id, 'g_rating_count', true) : 0;
if (isset($rating_value) & isset($id)) { ?>
    <div class="g_rating_block">
        <div class="stars_rating <?php echo $active ? 'g_rating' : '' ?>">
            <div class="stars_inner g_rating_inner" style="width: <?php echo $rating_value * 20 ?>%"></div>
        </div>
        <?php if($active) { ?>
            <div class="rating_count">
                <div class="count_number" data-id="<?php echo $id; ?>">
                    <span><?php echo $rating_count; ?></span>
                </div>
                <span>Votes</span>
            </div>
        <?php } ?>
    </div>
<?php } ?>