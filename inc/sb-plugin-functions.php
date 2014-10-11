<?php
function sb_tbfa_check_core() {
    $activated_plugins = get_option('active_plugins');
    $sb_core_installed = in_array('sb-core/sb-core.php', $activated_plugins);
    if(!$sb_core_installed) {
        $sb_plugins = array(SB_TBFA_BASENAME);
        $activated_plugins = get_option('active_plugins');
        $activated_plugins = array_diff($activated_plugins, $sb_plugins);
        update_option('active_plugins', $activated_plugins);
    }
    return $sb_core_installed;
}

sb_tbfa_check_core();

function sb_tbfa_activation() {
    if(!sb_tbfa_check_core()) {
        wp_die(sprintf(__('You must install and activate plugin %1$s first! Click here to %2$s.', 'sb-tbfa'), '<a href="https://wordpress.org/plugins/sb-core/">SB Core</a>', sprintf('<a href="%1$s">%2$s</a>', admin_url('plugins.php'), __('go back', 'sb-tbfa'))));
    }
    do_action('sb_tbfa_activation');
}
register_activation_hook(SB_TBFA_FILE, 'sb_tbfa_activation' );

function sb_tbfa_settings_link($links) {
    if(sb_tbfa_check_core()) {
        $settings_link = sprintf('<a href="admin.php?page=sb_tbfa">%s</a>', __('Settings', 'sb-tbfa'));
        array_unshift($links, $settings_link);
    }
    return $links;
}
add_filter('plugin_action_links_' . SB_TBFA_BASENAME, 'sb_tbfa_settings_link');

function sb_tbfa_textdomain() {
    load_plugin_textdomain('sb-tbfa', false, SB_TBFA_DIRNAME . '/languages/');
}
add_action('plugins_loaded', 'sb_tbfa_textdomain');

function sb_tbfa_style_and_script() {
    $options = SB_Option::get();
    $loaded = isset($options['tbfa']['bootstrap']) ? $options['tbfa']['bootstrap'] : 1;
    if((bool)$loaded) {
        wp_register_style('bootstrap-style', SB_TBFA_URL . '/inc/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('bootstrap-style');
        
        wp_register_script('bootstrap', SB_TBFA_URL . '/inc/bootstrap/js/bootstrap.min.js', array('jquery'), false, true);
        wp_enqueue_script('bootstrap');
    }

    $loaded = isset($options['tbfa']['font_awesome']) ? $options['tbfa']['font_awesome'] : 1;
    if((bool)$loaded) {
        wp_register_style('font-awesome-style', SB_TBFA_URL . '/inc/font-awesome/css/font-awesome.min.css');
        wp_enqueue_style('font-awesome-style');
    }
}
add_action('wp_enqueue_scripts', 'sb_tbfa_style_and_script');

require SB_TBFA_INC_PATH . '/sb-plugin-load.php';