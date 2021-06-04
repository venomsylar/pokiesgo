<?php
$args = isset($args) ? $args : null;
$id = get_data_from_template('table-item', $args);
$hide_payments = get_data_from_template('hide_payments', $args);
$position = get_data_from_template('index', $args);
$hidden = get_data_from_template('hidden', $args);
$highlighted = get_data_from_template('highlighted', $args);


$image = get_the_post_thumbnail_url($id, '180x80');
$default_image = get_field('default_image', 'option')['sizes']['180x80'];
$title = get_the_title($id);
$bonus = get_field('bonus_casino',$id);
$games_count = get_field('games_count_casino',$id);
$payments = wp_get_post_terms($id, 'casino-payment');
$hide_review = get_field('hide_review_in_table',$id);
?>
<tr class="<?php echo $hidden ? 'hidden_row' : false; echo $highlighted ? ' highlighted' : false ?>">
    <td class="table_position">
        <span class="circled_position"><?php echo $position ?></span>
    </td>
    <td class="table_image">
        <button data-casino-id="<?php echo $id ?>">
            <img src="<?php echo $image ? $image : $default_image ?>" alt="<?php echo $title ?>">
        </button>
    </td>
    <td class="table_bonus">
        <span><?php echo $bonus ?></span>
    </td>
    <td class="table_play">
        <button class="button" data-casino-id="<?php echo $id ?>">
	        <span class="anim"></span>
	        <span>Play <em>Now</em></span>
        </button>
    </td>
    <td class="table_review">
        <?php if(!$hide_review) { ?>
            <a href="<?php echo get_the_permalink($id) ?>"><?php echo $title ?> review</a>
        <?php } else { ?>
            <span><?php echo $title ?> review</span>
        <?php } ?>
    </td>
	<?php
	if(!$hide_payments) { ?>
		<td class="table_payments">
			<div class="table_payments_wrap">
				<?php if(is_array($payments)) { ?>
					<?php
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
			</div>
		</td>
	<?php } ?>
</tr>
