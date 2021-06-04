<?php
$id = get_the_ID();
$image = get_the_post_thumbnail_url($id, '300x133');
$default_image = get_field('default_image', 'option')['sizes']['300x133'];
$title = get_the_title();
$bonus = get_field('bonus_casino');
$games_count = get_field('games_count_casino');
$features_casino = get_field('features_casino');
$payments = wp_get_post_terms($id, 'casino-payment');
$providers = wp_get_post_terms($id, 'casino-provider');
$google_rating = get_post_meta($id, 'g_rating_value');
$referral_link_casino = get_field('referral_link_casino');
?>

<section class="casino_top container">
	<h1><?php echo $title ?></h1>
    <div class="casino-info flex_md">
        <?php
            if ($image || $default_image) { ?>
                <div class="casino_image_and_rating">
	                <figure>
		                <img src="<?php echo $image ? $image : $default_image ?>" alt="<?php echo $title ?>">
	                </figure>
                </div>
            <?php }
            if($features_casino && $title) { ?>
                <div class="casino_first_info">
                    <div class="casino_features">
                        <?php echo $features_casino ?>
                    </div>
                </div>
            <?php }
            if ($referral_link_casino) { ?>
                <div class="casino_second_info">
	                <div class="casino_bonus_and_button">
		                <?php
		                if($bonus) { ?>
			                <div class="casino_bonus">
				                <span>Bonus:</span>
				                <strong><?php echo $bonus ?></strong>
			                </div>
		                <?php } ?>
		                <button class="button" data-casino-id="<?php echo $id ?>">
			                <span class="anim"></span>
			                <span>Play now</span>
		                </button>
	                </div>
                </div>
            <?php } ?>
    </div>
</section>
