<?php
/*
Plugin Name: SB TBFA
Plugin URI: http://hocwp.net/
Description: SB TBFA is a plugin that allows to load Twitter Bootstrap and Font Awesome on your WordPress site.
Author: SB Team
Version: 1.1.0
Author URI: http://hocwp.net/
Text Domain: sb-tbfa
Domain Path: /languages/
*/

if(defined('SB_THEME_VERSION') && version_compare(SB_THEME_VERSION, '1.7.0', '>=')) {
    return;
}

define('SB_TBFA_USE_CORE_VERSION', '1.5.9');

define('SB_TBFA_FILE', __FILE__);

define('SB_TBFA_PATH', untrailingslashit(plugin_dir_path(SB_TBFA_FILE)));

define('SB_TBFA_URL', plugins_url('', SB_TBFA_FILE));

define('SB_TBFA_INC_PATH', SB_TBFA_PATH . '/inc');

define('SB_TBFA_BASENAME', plugin_basename(SB_TBFA_FILE));

define('SB_TBFA_DIRNAME', dirname(SB_TBFA_BASENAME));

require SB_TBFA_INC_PATH . '/sb-plugin-load.php';
