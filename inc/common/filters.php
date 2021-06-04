<?php
/**
 * @return bool
 * js and css for 404 page
 */
function venom_is_404_template() {
    return is_404();
}

add_filter('wp-encore/is-required/404', 'venom_is_404_template');

/**
 * @return bool
 * js and css for casino page
 */
function venom_is_casino_template() {
	return is_singular('casino');
}

add_filter('wp-encore/is-required/casino', 'venom_is_casino_template');