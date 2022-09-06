<?php
/* PageSpeed Ninja Caching */
defined('ABSPATH') || die();
define('PAGESPEEDNINJA_CACHE_DIR', '/home/slowrise/public_html/wp-content/plugins/psn-pagespeed-ninja/cache');
define('PAGESPEEDNINJA_CACHE_PLUGIN', '/home/slowrise/public_html/wp-content/plugins/psn-pagespeed-ninja');
define('PAGESPEEDNINJA_CACHE_RESSDIR', '/home/slowrise/public_html/wp-content/plugins/psn-pagespeed-ninja/ress');
define('PAGESPEEDNINJA_CACHE_DEVICEDEPENDENT', true);
define('PAGESPEEDNINJA_CACHE_TTL', 604800);
define('PAGESPEEDNINJA_CACHE_GZIP', 1);
include '/home/slowrise/public_html/wp-content/plugins/psn-pagespeed-ninja/public/advanced-cache.php';
