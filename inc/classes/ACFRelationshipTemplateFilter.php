<?php
/**
 * Class ACFFilter
 */

class ACFRelationshipTemplateFilter
{
    private $key;
    private $template_name;
    private $field_type;

    public function __construct($key, $template_name, $field_type)
    {
        $this->key = $key;
        $this->template_name = $template_name;
        $this->field_type = $field_type;
        $this->filter();
    }

    public function filter_query($args)
    {
        // show only pages with this special template
        $args['meta_key'] = '_wp_page_template';
        $args['meta_value'] = $this->template_name;
        return $args;
    }

    private function filter()
    {
        add_filter('acf/fields/'.$this->field_type.'/query/key='.$this->key.'', array( $this, 'filter_query' ), 10, 3);
    }
}
