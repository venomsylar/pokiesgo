<?php
/**
 * Class CustomTaxonomy
 */

class CustomTaxonomy extends WPStructuralElements
{
    private $post_type;
    private $name;
    private $slug;
    private $public;
    private $hierarchical;

    public function __construct($post_type, $name, $slug, $public = true, $hierarchical = true)
    {
        $this->post_type = $post_type;
        $this->name = $name;
        $this->slug = $slug;
        $this->public = $public;
        $this->hierarchical = $hierarchical;
        $this->registration();
    }

    protected function registration()
    {
        register_taxonomy(strtolower($this->slug), strtolower($this->post_type), $this->get_post_type_props());
    }

    protected function get_post_type_props()
    {
        $this->labelsArray = array(
            'name'                          => $this->name,
            'singular_name'                 => $this->name,
            'search_items'                  => 'Search '.$this->name,
            'popular_items'                 => 'Popular '.$this->name,
            'all_items'                     => 'All '.$this->name.'s',
            'parent_item'                   => 'Parent '.$this->name,
            'edit_item'                     => 'Edit '.$this->name,
            'update_item'                   => 'Update '.$this->name,
            'add_new_item'                  => 'Add New '.$this->name,
            'new_item_name'                 => 'New '.$this->name,
            'separate_items_with_commas'    => 'Separate '.$this->name.'s with commas',
            'add_or_remove_items'           => 'Add or remove '.$this->name.'s',
            'choose_from_most_used'         => 'Choose from most used '.$this->name.'s'
        );

        $this->dataArray = array(
            'label'                         => $this->name,
            'labels'                        => $this->labelsArray,
            'public'                        => $this->public,
            'hierarchical'                  => $this->hierarchical,
            'show_in_nav_menus'             => true,
            'args'                          => array( 'orderby' => 'term_order' ),
            'query_var'                     => true,
            'show_ui'                       => true,
            'rewrite'                       => true,
            'show_admin_column'             => true
        );

        return $this->dataArray;
    }
}
