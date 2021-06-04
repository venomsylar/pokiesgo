<?php
$id = get_queried_object_id();

if (is_single() || is_home() || is_page_template('tpl-contacts.php')) {
	get_template_part('template-parts/global/constructor/constructor-parts/top-3-casino-small', 'top-3-casino-small');
}

if (is_single() || is_home()) {
	get_template_part('/template-parts/global/sidebar/most-popular-posts', 'most-popular-posts');
}