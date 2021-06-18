<?php
$args = isset($args) ? $args : null;
global $post;
$author_id = $post->post_author;
$photo = $image = get_avatar_url($author_id, ['size'=>'thumbnail']) ?: get_field('default_image', 'option')['sizes']['thumbnail'];

$author_user_firstname = get_the_author_meta('user_firstname', $author_id);
$author_user_lastname = get_the_author_meta('user_lastname', $author_id);
$text = get_the_author_meta('description', $author_id);
$name = $author_user_firstname . ' ' . $author_user_lastname;
$author_user_url = get_author_posts_url($author_id);
$position = get_field('position', 'user_'.$author_id);
$social = get_field('some', 'user_'.$author_id);

if ($photo && $name && $position && $text) { ?>
	<div class="author_box">
		<div class="container">
			<div class="author_wrap flex_md">
				<figure class="author_info flex_align_top_wrap">
					<div class="author_info_img">
						<img src="<?php echo $photo ?>" alt="<?php echo $name ?>" />
					</div>
					<div class="author_info_text">
						<h6><a href="<?php echo $author_user_url ?>"><?php echo $name ?></a></h6>
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