<?php
// Include used custom classes
require_once 'inc/classes/index.php';

// Theme configuration
require_once('inc/common/configuration.php');

// Recommended plugins installer
require_once('inc/plugins/index.php');

// Register theme shortcodes
require_once('inc/common/shortcodes.php');

// Enqueuing styles and js
require_once 'inc/common/enqueue.php';

// WP misc registration
require_once 'inc/common/registration.php';

// Custom helper functions
require_once 'inc/common/custom-functions.php';

require_once('inc/common/filters.php');

require_once('inc/common/filter-by-taxonomy.php');

require_once('inc/plugins/term-edit-button/term-edit-button.php');

require_once('inc/common/term-auto-check.php');

require_once 'template-parts/global/constructor/constructor-parts/table/table-filter/table-filter.php';
require_once 'template-parts/global/constructor/constructor-parts/table/table-filter/table-filter-item.php';
require_once 'template-parts/global/constructor/constructor-parts/table/table-filter/table-sorting-item.php';