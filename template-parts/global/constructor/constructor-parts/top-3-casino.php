<?php
$args = isset($args) ? $args : null;
$title = get_data_from_template('title', $args);
$index = get_data_from_template('index', $args);
$all_casinos = get_field('all_casinos_table', 'option');
$top_three_casinos = array_slice($all_casinos, 0, 3);
$heading_id = 'toc_content_'.$index.'_heading_0';
if (is_array($top_three_casinos)) { ?>
    <div class="top_3_casino">
        <div class="container">
	        <?php echo $title ? '<h2 id="'.$heading_id.'">'.$title.'</h2>' : ''; ?>
            <div class="top_3_casino_items">
                <?php $index = 1; ?>
                <?php foreach ($top_three_casinos as $id): ?>
                    <?php
                    $casino_name = get_the_title($id);
                    $google_rating = get_post_meta($id, 'g_rating_value');
                    $image = get_the_post_thumbnail_url($id, '180x80');
                    $bonus = get_field('bonus_casino', $id);
                    $games_count = get_field('games_count_casino', $id);
                    $payments = wp_get_post_terms($id, 'casino-payment');
                    $hide_review = get_field('hide_review_in_table',$id);
                    ?>
                    <div class="top_3_casino_item">
                        <div class="top_3_casino_item_top">
                            <span class="casino_item_position"><?php echo $index++ ?></span>
	                        <span class="casino_item_bonus">
		                        <strong>Bonus: <?php echo $bonus ?></strong>
	                        </span>
                        </div>
                        <div class="top_3_casino_item_bottom">
                            <figure class="casino_item_logo">
                                <img src="<?php echo $image ?>" alt="<?php echo $casino_name ?>">
                            </figure>
	                        <button class="button" data-casino-id="<?php echo $id ?>">
		                        <span class="anim"></span>
		                        <span>Play Now</span>
	                        </button>
                            <span class="casino_item_games">
                        <strong>Games: <?php echo $games_count ?></strong>
                    </span>
                            <?php
                            if(is_array($payments)) {
	                            $payment_count = count($payments);
	                            $payments = $payment_count > 6 ? array_slice($payments, 0, 5) : $payments;
                            	?>
                                <div class="casino_item_payments">
                                    <?php foreach($payments as $payment): ?>
                                        <div class="casino_item_payment">
                                            <?php
                                            $taxonomy = 'casino-payment';
                                            $payment_id = $payment->term_id;
                                            $payment_name = $payment->name;
                                            $payment_image = get_field('payment_image', $taxonomy . '_' . $payment_id);
                                            ?>
                                            <img src="<?php echo $payment_image['sizes']['180x80'] ?>" alt="<?php echo $payment_name ?>">
                                        </div>
                                    <?php endforeach; ?>
	                                <?php echo $payment_count > 6 ? '<span class="more">+'.($payment_count - 5).'</span>' : null; ?>
                                </div>
                            <?php } ?>
                            <?php if(!$hide_review) { ?>
                                <div class="casino_item_read_review">
                                    <a href="<?php echo get_the_permalink($id) ?>"><?php echo $casino_name ?> review</a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php }