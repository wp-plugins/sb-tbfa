<?php
function sb_tbfa_check_core() {
    $activated_plugins = get_option('active_plugins');
    $sb_core_installed = in_array('sb-core/sb-core.php', $activated_plugins);
    return $sb_core_installed;
}

function sb_tbfa_get_plugin_data($path) {
    if(!function_exists('get_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    if(!file_exists($path)) {
        return array();
    }
    $data = get_plugin_data($path);
    return $data;
}

function sb_tbfa_get_plugin_sb_core_data() {
    $data = sb_tbfa_get_plugin_data(ABSPATH . 'wp-content/plugins/sb-core/sb-core.php');
    return $data;
}

function sb_tbfa_is_core_valid() {
    $data = sb_tbfa_get_plugin_sb_core_data();
    $current_core_version = isset($data['Version']) ? $data['Version'] : '';
    if(version_compare($current_core_version, SB_TBFA_USE_CORE_VERSION, '>=')) {
        return true;
    }
    return false;
}

function sb_tbfa_activation() {
    do_action('sb_tbfa_activation');
}
register_activation_hook(SB_TBFA_FILE, 'sb_tbfa_activation');

function sb_tbfa_not_valid_core_message() {
    return sprintf('<div class="error"><p><strong>' . __('Error', 'sb-tbfa') . ':</strong> ' . __('SB TBFA only run with %1$s, please update it via updates page or download it manually.', 'sb-tbfa') . '.</p></div>', sprintf('<a target="_blank" href="%1$s" style="text-decoration: none">SB Core version %2$s</a>', 'https://wordpress.org/plugins/sb-core/', SB_TBFA_USE_CORE_VERSION));
}

function sb_tbfa_check_admin_notices() {
    if(!empty($GLOBALS['pagenow']) && 'plugins.php' === $GLOBALS['pagenow']) {
        if(!sb_tbfa_check_core()) {
            unset($_GET['activate']);
            printf('<div class="error"><p><strong>' . __('Error', 'sb-tbfa') . ':</strong> ' . __('The plugin with name %1$s has been deactivated because of missing %2$s plugin', 'sb-tbfa') . '.</p></div>', '<strong>SB TBFA</strong>', sprintf('<a target="_blank" href="%s" style="text-decoration: none">SB Core</a>', 'https://wordpress.org/plugins/sb-core/'));
            deactivate_plugins(SB_TBFA_BASENAME);
        }
    }
    if(!sb_tbfa_is_core_valid()) {
        echo sb_tbfa_not_valid_core_message();
    }
}
add_action('admin_notices', 'sb_tbfa_check_admin_notices', 0);

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