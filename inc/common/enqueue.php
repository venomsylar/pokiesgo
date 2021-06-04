<?php
/**
 * Enqueue scripts and styles.
 */

function venom_enqueue_scripts_and_styles()
{
	$epJsonFile = get_template_directory() . '/assets/dist/entrypoints.json';

	if ( file_exists($epJsonFile) ) {
		$encoreKernel = new \PR\WP\Encore\Kernel($epJsonFile);
		$encoreKernel->enqueueAssets();
	}
}
add_action('wp_enqueue_scripts', 'venom_enqueue_scripts_and_styles');

add_filter('wp-encore/is-required/main', '__return_true');

function venom_filter_endpoint_path($filePath, $file) {
	return "/$file";
}
add_filter('wp-encore/css/file-path', 'venom_filter_endpoint_path', 2, 10);
add_filter('wp-encore/js/file-path', 'venom_filter_endpoint_path', 2, 10);


add_action( 'wp_enqueue_scripts', 'jquery_script_method' );
function jquery_script_method() {
    wp_deregister_script( 'jquery' );
}
