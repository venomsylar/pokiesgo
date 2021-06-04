<?php
$args = isset($args) ? $args : null;
$photo = get_data_from_template('photo', $args);
$name = get_data_from_template('name', $args);
$position = get_data_from_template('position', $args);
$text = get_data_from_template('text', $args);
$social = get_data_from_template('social', $args);

if ($photo && $name && $position && $text) { ?>
	<div class="author">
		<div class="container">
			<div class="author_wrap flex_md">
				<figure class="author_info flex_align_top_wrap">
					<div class="author_info_img">
						<img src="<?php echo $photo['sizes']['thumbnail'] ?>" alt="<?php echo $photo['alt'] ?>" />
					</div>
					<div class="author_info_text">
						<h6><?php echo $name ?></h6>
						<span><?php echo $position ?></span>
						<?php
						if ($social) { ?>
							<div class="social_media">
								<?php foreach ($social as $sm) { ?>
									<a class="i-<?php echo $sm['icon'] ?>" target="_blank" rel="nofollow noopener" href="<?php echo $sm['link'] ?>"></a>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</figure>
				<div class="author_text">
					<?php echo $text ?>
				</div>
			</div>
		</div>
	</div>
<?php }