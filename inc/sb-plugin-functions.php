<?php
function sb_tbfa_check_core() {
    $activated_plugins = get_option('active_plugins');
    $sb_core_installed = in_array('sb-core/sb-core.php', $activated_plugins);
    return $sb_core_installed;
}

function sb_tbfa_activation() {
    do_action('sb_tbfa_activation');
}
register_activation_hook(SB_TBFA_FILE, 'sb_tbfa_activation');

function sb_tbfa_check_admin_notices() {
    if(!sb_tbfa_check_core()) {
        unset($_GET['activate']);
        printf('<div class="error"><p><strong>' . __('Error', 'sb-tbfa') . ':</strong> ' . __('The plugin with name %1$s has been deactivated because of missing %2$s plugin', 'sb-tbfa') . '.</p></div>', '<strong>SB TBFA</strong>', sprintf('<a target="_blank" href="%s" style="text-decoration: none">SB Core</a>', 'https://wordpress.org/plugins/sb-core/'));
        deactivate_plugins(SB_TBFA_BASENAME);
    }
}
if(!empty($GLOBALS['pagenow']) && 'plugins.php' === $GLOBALS['pagenow']) {
    add_action('admin_notices', 'sb_tbfa_check_admin_notices', 0);
}

if(!sb_tbfa_check_core()) {
    return;
}

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