<?php
/**
 * Class WPStructuralElements
 */
abstract class WPStructuralElements
{
    protected $labelsArray;
    protected $dataArray;
    abstract protected function get_post_type_props();
    abstract protected function registration();
}
