<?php
$args = isset($args) ? $args : null;
$slots_list = get_data_from_template('list', $args);
$hidden_count = 10;
if (count($slots_list) > 0) { ?>
    <div class="slots_list">
        <div class="container flex_wrap ">
            <?php foreach($slots_list as $key => $slot): ?>
               <div class="slots_list_item  <?php echo $key >= $hidden_count ? 'hidden_slot' : false ?>">
                  <?php
                  $taxonomy = 'casino-slots';
                  $term_id = $slot->term_id;
                  $name = $slot->name;
                  $link = get_term_link($slot);
                  $image = get_field('slot_image',$taxonomy . '_' . $term_id);
                  $casino = get_field('redirect_to_casino',$taxonomy . '_' . $term_id);
                  ?>
                   <figure>
                       <?php echo $image ? '<img src="'.$image['sizes']['430x314'].'" alt="'.$image['alt'].'" />' : false; ?>
                   </figure>
                   <strong><a href="<?php echo get_term_link($term_id) ?>"><?php echo $name ?></a></strong>
                   <div class="buttons">
                       <div class="for_link">
                           <a href="<?php echo $link ?>" class="play_free button">
	                           <span class="anim"></span>
	                           <span>Play Free</span>
                           </a>
                       </div>
                   </div>
               </div>
            <?php endforeach; ?>
	        <div class="slot_buttons_wrap">
		        <div class="for_button">
			        <a href="<?php echo site_url() . '/best-online-casino-slots/' ?>">View all</a>
		        </div>
		        <?php if(count($slots_list) > $hidden_count) { ?>
			        <div data-count="<?php echo $hidden_count ?>" class="slot_expand i-angle-down">
				        Load more
			        </div>
		        <?php } ?>
	        </div>
        </div>
    </div>
<?php }