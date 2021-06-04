<?php
$term = get_queried_object();
$term_id = $term->term_id;
$title = $term->name;
$taxonomy = 'casino-slots';
$iframe = get_field('iframe_url', $taxonomy . '_' . $term_id);
$button_text = get_field('button_text_slots', $taxonomy . '_' . $term_id);
$redirect_to_casino = get_field('redirect_to_casino', $taxonomy . '_' . $term_id);
$slot_provider = get_field('slot_provider', $taxonomy . '_' . $term_id);
$slot_provider_name = get_term( $slot_provider )->name ?: null;
$slot_image = get_field('slot_image', $taxonomy . '_' . $term_id);
?>

<section class="slot_top_info">
    <div class="container">
	    <h1><?php echo $title ?></h1>
        <div class="slot_top_info_wrap flex_lg">
	        <div class="slot_iframe_wrap">
		        <div class="slot_iframe">
			        <div class="slot_iframe_bg cover" style="background-image: url('<?php echo $slot_image['sizes']['free'];?>')"></div>
			        <div class="slot_iframe_buttons">
				        <div class="slot_iframe_divider">
					        <button class="button" data-casino-id="<?php echo $redirect_to_casino ?>">
						        <span class="anim"></span>
						        <span>Play for Real</span>
					        </button>
				        </div>
				        <button class="play_free button3" >
					        <span class="anim"></span>
					        <span>Play Free</span>
				        </button>
			        </div>
			        <iframe src="" data-slot-url="<?php echo $iframe ?>" frameborder="0"></iframe>
		        </div>
		        <button data-casino-id="<?php echo $redirect_to_casino ?>" class="slot_iframe_subtitle">Play for real money with casino bonus!</button>
	        </div>
	        <div class="slot_top_info_block">
		        <div class="slot_info">
			        <h2><?php echo $title ?> Details</h2>
			        <?php $slot_provider ? '<div class="slot_provider"><a href="'. get_term_link($slot_provider) .'">'. $slot_provider_name .'</a></div>' : '' ?>
			        <div class="slot_casino">
				        <strong>Type: </strong><a href="<?php the_permalink($redirect_to_casino); ?>"><?php echo get_the_title($redirect_to_casino); ?></a>
			        </div>
			        <button class="button" data-casino-id="<?php echo $redirect_to_casino ?>">
				        <span class="anim"></span>
				        <span>Play for Real Money</span>
			        </button>
		        </div>
		        <div class="table_bonus">
			        <?php get_template_part('/template-parts/global/constructor/constructor-parts/top-3-casino-small');?>
		        </div>
	        </div>
        </div>
    </div>
</section>