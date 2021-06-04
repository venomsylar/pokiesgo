<?php
/**
 * @param $arguments
 * @return false|string
 */
function venom_shortcode_content_btn($arguments)
{
    ob_start(); ?>
    <div class="for_button_schortcode">
        <a href="<?php echo isset($arguments['link']) ? $arguments['link'] : site_url(); ?>"
           class="inline_button <?php echo isset($arguments['class']) ? $arguments['class'] : ''; ?>"
            <?php echo isset($arguments['target']) ? 'target="'.$arguments['target'].'" rel="nofollow noopener"' : false; ?>>
            <?php echo isset($arguments['text']) ? $arguments['text'] : 'Learn More'; ?>
        </a>
    </div>
    <?php return ob_get_clean();
}
add_shortcode("button", "venom_shortcode_content_btn");

/**
 * Custom Pagination
 *
 * @return false|string
 */
function venom_shortcode_custom_pagination()
{
    ob_start();
    get_template_part('template-parts/global/shortcodes/custom-pagination');
    return ob_get_clean();
}
add_shortcode('custom-pagination', 'venom_shortcode_custom_pagination');

function breadcrumbs_shortcode($atts, $content = null) {
    if (function_exists('bcn_display')) {
        // Return the output as a string so we can control when it's displayed
        $output = bcn_display( true );
    } else {
        // Function doesn't exist so we return an empty string
        $output = '';
    }
    return '<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/"><div class="container"> ' . $output . '</div></div>';
}
add_shortcode('breadcrumbs', 'breadcrumbs_shortcode');


function venom_shortcode_inline_video($arguments)
{
	ob_start();
	get_template_part('template-parts/global/shortcodes/inline-video', 'inline-video', [
		'id' => $arguments['id'],
		'float' => isset($arguments['float']) ? $arguments['float'] : ''
	]);
	return ob_get_clean();
}
add_shortcode('inline-video', 'venom_shortcode_inline_video');

function venom_shortcode_top3($arguments)
{
	ob_start();
	get_template_part('template-parts/global/constructor/constructor-parts/top-3-casino-small', 'top-3-casino-small' , [
		'float' => isset($arguments['float']) ? $arguments['float'] : ''
	]);
	return ob_get_clean();
}
add_shortcode('top3-casino-small', 'venom_shortcode_top3');