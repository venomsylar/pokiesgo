<?php
require_once 'cyr-to-lat.php';
require_once 'lowercase-url.php';
if(is_admin()) {
    require_once 'duplicator.php';
    require_once 'filter-by-template.php';
    require_once 'scroll-to-top.php';
    require_once 'admin-pages-table/admin-pages-table.php';
}