<?php
/*
Plugin Name: SB TBFA
Plugin URI: http://hocwp.net/
Description: SB TBFA is a plugin that allows to load Twitter Bootstrap and Font Awesome on your WordPress site.
Author: SB Team
Version: 1.0.0
Author URI: http://hocwp.net/
*/

define("SB_TBFA_PATH", untrailingslashit(plugin_dir_path( __FILE__ )));

//add_filter("sb_admin_test", "__return_true");

function sb_tbfa_style_and_script() {
    $options = get_option("sb_options");
    $loaded = isset($options["tbfa"]["bootstrap"]) ? $options["tbfa"]["bootstrap"] : 1;
    if((bool)$loaded) {
        wp_register_style("bootstrap-style", plugins_url("inc/bootstrap/css/bootstrap.min.css", __FILE__));
        wp_enqueue_style("bootstrap-style");
        wp_register_script("bootstrap", plugins_url("inc/bootstrap/js/bootstrap.min.js", __FILE__), array("jquery"), false, true);
        wp_enqueue_script("bootstrap");
    }

    $loaded = isset($options["tbfa"]["font_awesome"]) ? $options["tbfa"]["font_awesome"] : 1;
	if((bool)$loaded) {
        wp_register_style("font-awesome-style", plugins_url("inc/font-awesome/css/font-awesome.min.css", __FILE__));
        wp_enqueue_style("font-awesome-style");
    }
}
add_action("wp_enqueue_scripts", "sb_tbfa_style_and_script");

function sb_tbfa_settings_link($links) { 
  $settings_link = '<a href="admin.php?page=sb_tbfa">Settings</a>';
  array_unshift($links, $settings_link); 
  return $links; 
}
add_filter("plugin_action_links_".plugin_basename(__FILE__), 'sb_tbfa_settings_link' );

require_once(SB_TBFA_PATH."/admin/sb-admin.php");
require SB_TBFA_PATH . "/sb-plugin-admin.php";
?>
