<?php

class ACFMessageFilter
{
    private $key;
    private $tab_key;
    private $message;

    public function __construct($message_field_key, $tab_key, $message = false)
    {
        $this->key = $message_field_key;
        $this->tab_key = $tab_key;
        $this->message = $message;
        $this->filter();
        if(is_admin()) {
            add_action( 'admin_enqueue_scripts', array( $this, 'filter_script' ) );
        }
        try {
            if(stristr($this->key, 'field_') === false || stristr($this->tab_key, 'field_') === false) {
                throw new Exception('not valid key, example: field_5d76666901f5e');
            }
        } catch (Exception $e) {
            echo 'Error in class ACFMessageFilter: ',  $e->getMessage(), "\n";
        }
    }

    public function filter_script() {
        wp_enqueue_script( 'acf-message-filter', get_template_directory_uri() . '/inc/classes/ACFMessageFilter/acf-message-filter.js');
    }

    private function set_option_page_message() {
        if(!$this->message) {
            $message = 'This field is global, you can edit it in Theme Settings <a href="/wp-admin/admin.php?page=theme-general-settings" target="_blank" rel="nofollow" data-tab-key="' .$this->tab_key. '" class="select_tab_links"><strong><ins>Edit field</ins></strong></a>';
        } else {
            $message = $this->message . ' <a href="/wp-admin/admin.php?page=theme-general-settings" target="_blank" rel="nofollow" data-tab-key="' .$this->tab_key. '" class="select_tab_links"><strong><ins>Edit field</ins></strong></a>';
        }
        return $message;
    }

    public function filter_query($args)
    {
        $args['message'] = $this->set_option_page_message();
        return $args;
    }

    private function filter()
    {
        add_filter('acf/load_field/key='.$this->key.'', array( $this, 'filter_query' ), 10, 3);
    }
}