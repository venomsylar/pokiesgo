<?php
$website = get_field('web_site_tittle');
$bonus = get_field('bonus_casino');
$count = get_field('games_count_casino');
$categories = wp_get_post_terms(get_the_ID(), 'casino-category');
$providers = wp_get_post_terms(get_the_ID(), 'casino-provider');
$payments = wp_get_post_terms(get_the_ID(), 'casino-payment');

$other_categories = get_field('other_categories');
$other_providers = get_field('other_providers');
$other_payments = get_field('other_payments');
?>
<section class="casino_review_box">
    <div class="container">
        <h2><?php echo get_the_title()?> review</h2>
        <div class="casino_review_box_items">
            <div class="casino_review_box_item flex_align_center_sm">
                <div class="casino_review_label">Website Title</div>
                <div class="casino_review_value">
                    <button data-casino-id="<?php echo get_the_ID() ?>"><?php echo $website ?></button>
                </div>
            </div>
            <div class="casino_review_box_item flex_align_center_sm">
                <div class="casino_review_label">Welcome Bonus</div>
                <div class="casino_review_value"><?php echo $bonus?></div>
            </div>
            <div class="casino_review_box_item flex_align_center_sm">
                <div class="casino_review_label">Count of Games</div>
                <div class="casino_review_value"><?php echo $count ?></div>
            </div>
	        <?php get_template_part('/template-parts/single-casino/casino-review-taxonomy', null, [
	        		'label' => 'Casino Categories',
	        		'terms' => $categories,
				    'other_terms' => $other_categories,
				    'taxonomy' => 'casino-category',
			        ]
	        ); ?>
	        <?php get_template_part('/template-parts/single-casino/casino-review-taxonomy', null, [
	        		'label' => 'Casino Providers',
					'terms' => $providers,
					'other_terms' => $other_providers,
					'taxonomy' => 'casino-provider',
			        ]
	        ); ?>
	        <?php get_template_part('/template-parts/single-casino/casino-review-taxonomy', null, [
	        		'label' => 'Payments',
					'terms' => $payments,
					'other_terms' => $other_payments,
					'taxonomy' => 'casino-payment',
			        ]
	        ); ?>
        </div>
	    <div class="for_play">
		    <button class="button" data-casino-id="<?php echo get_the_ID() ?>">
			    <span class="anim"></span>
			    <span>Play <em>Now</em></span>
		    </button>
	    </div>
    </div>
</section>
