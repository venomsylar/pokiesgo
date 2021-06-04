<?php
/**
 * Class CustomPostType
 */
class CustomPostType extends WPStructuralElements
{
    private $name;
    private $slug;
    private $icon;
    private $archive;
    private $public;
    private $supports;

    public function __construct($name, $slug, $icon = 'dashicons-admin-page', $archive = false, $public = true, $supports = array( 'title', 'editor', 'thumbnail' ))
    {
        $this->name = $name;
        $this->slug = strtolower($slug);
        $this->icon = $icon;
        $this->archive = $archive;
        $this->public = $public;
        $this->supports = $supports;
        $this->registration();
    }

    protected function registration()
    {
        register_post_type($this->slug, $this->get_post_type_props());
    }

    protected function get_post_type_props()
    {
        $this->labelsArray = array(
            'name' => $this->name,
            'singular_name' => $this->name,
            'menu_name' => $this->name
        );
        $this->dataArray = array(
            'labels'                => $this->labelsArray,
            'public'                => $this->public,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'supports'              => $this->supports,
            'rewrite'               => array( 'slug' => $this->slug ),
            'has_archive'           => $this->archive,
            'hierarchical'          => true,
            'show_in_nav_menus'     => true,
            'capability_type'       => 'page',
            'query_var'             => true,
            'menu_icon'             => $this->icon,
        );
        return $this->dataArray;
    }
}
