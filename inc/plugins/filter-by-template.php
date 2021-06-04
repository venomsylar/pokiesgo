<?php
/*
Plugin Name: Filter Page by Template
Description: See list of pages or any type of posts by filtering based on used template. Page template filter dropdown for post/page listing. New column in page list that shows template name.
Plugin URI: http://onetarek.com
Author: oneTarek
Author URI: http://onetarek.com
Version: 1.2
*/

class FilterPagesByTemplate
{
    public function __construct()
    {
        add_action('restrict_manage_posts', array( $this, 'filter_dropdown' ));
        add_filter('request', array( $this, 'filter_post_list' ));
    }

    public function filter_dropdown()
    {
        if ($GLOBALS['pagenow'] === 'upload.php') {
            return;
        }

        $template = isset($_GET['page_template_filter']) ? $_GET['page_template_filter'] : "all";
        $default_title = apply_filters('default_page_template_title', __('Default Template'), 'meta-box'); ?>
        <select name="page_template_filter" id="page_template_filter">
            <option value="all">All Page Templates</option>
            <option value="all_missing" style="color:red" <?php echo ($template == 'all_missing')? ' selected="selected" ' : ""; ?>>All Missing Page Templates</option>
            <option value="default" <?php echo ($template == 'default')? ' selected="selected" ' : ""; ?>><?php echo esc_html($default_title); ?></option>
            <?php page_template_dropdown($template); ?>
        </select>
        <?php
    }

    public function filter_post_list($vars)
    {
        if (! isset($_GET['page_template_filter'])) {
            return $vars;
        }

        $template = trim($_GET['page_template_filter']);

        if ($template == "" || $template == 'all') {
            return $vars;
        }

        if ($template == 'all_missing') {
            $templates = wp_get_theme()->get_page_templates(null, 'page');
            $template_files = array_keys($templates);
            $template_files[] = 'default';
            $vars = array_merge(
                $vars,
                array(
                    'meta_query' => array(
                        array(
                            'key'     => '_wp_page_template',
                            'value'   => $template_files,
                            'compare' => 'NOT IN',
                        )
                    ),
                )
            );
        } else {
            $vars = array_merge(
                $vars,
                array(
                    'meta_query' => array(
                        array(
                            'key'     => '_wp_page_template',
                            'value'   => $template,
                            'compare' => '=',
                        ),
                    ),
                )
            );
        }

        return $vars;
    }
}

new FilterPagesByTemplate();
