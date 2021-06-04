<?php
$languages = get_field('languages', 'option');
$object = get_queried_object();
$id = $object->ID ?: $object->taxonomy . '_' .$object->term_id;
$hreflangs = get_field('links_hreflang', $id);
if ($languages && count($languages) && $hreflangs && count($hreflangs) || is_front_page()) { ?>
	<nav id="languageMenu">
		<span class="activeItem">
			<img src="<?php echo get_field('current_language_icon', 'option') ?>" alt="<?php echo get_field('current_language', 'option') ?>">
		</span>
		<ul>
			<?php foreach($languages as $language):
				$slug = get_slug_by_hreflang_code($language['hreflang']);
				if ($slug || is_front_page()) { ?>
					<li>
						<a target="_blank" rel="nofollow noopener" href="<?php echo $language['domain'] . $slug ?>">
							<img src="<?php echo $language['icon'] ?>" alt="<?php echo $language['country'] ?>">
						</a>
					</li>
				<?php } ?>
			<?php endforeach; ?>
		</ul>
	</nav>
<?php }