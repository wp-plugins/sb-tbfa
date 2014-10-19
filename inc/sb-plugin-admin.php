<?php
function sb_tbfa_menu() {
    SB_Admin_Custom::add_submenu_page('SB TBFA', 'sb_tbfa', array('SB_Admin_Custom', 'setting_page_callback'));
}
add_action('sb_admin_menu', 'sb_tbfa_menu');

function sb_tbfa_tab($tabs) {
    $tabs['sb_tbfa'] = array('title' => 'SB TBFA', 'section_id' => 'sb_tbfa_section', 'type' => 'plugin');
    return $tabs;
}
add_filter('sb_admin_tabs', 'sb_tbfa_tab');

function sb_tbfa_setting_field() {
    SB_Admin_Custom::add_section('sb_tbfa_section', __('SB TBFA options page', 'sb-tbfa'), 'sb_tbfa');
    SB_Admin_Custom::add_setting_field('sb_tbfa_bootstrap', 'Bootstrap', 'sb_tbfa_section', 'sb_tbfa_bootstrap_callback', 'sb_tbfa');
    SB_Admin_Custom::add_setting_field('sb_tbfa_font_awesome', 'Font Awesome', 'sb_tbfa_section', 'sb_tbfa_font_awesome_callback', 'sb_tbfa');
}
add_action('sb_admin_init', 'sb_tbfa_setting_field');

function sb_tbfa_bootstrap_callback() {
    $name = 'sb_options[tbfa][bootstrap]';
    $options = SB_Option::get();
    $value = isset($options['tbfa']['bootstrap']) ? $options['tbfa']['bootstrap'] : 1;
    $description = __('You can turn on or turn off Twitter Bootstrap loaded on your site.', 'sb-tbfa');
    $id = 'sb_tbfa_bootstrap';
    $args = array(
        'id' => $id,
        'name' => $name,
        'value' => $value,
        'description' => $description
    );
    SB_Field::switch_button($args);
}

function sb_tbfa_font_awesome_callback() {
    $name = 'sb_options[tbfa][font_awesome]';
    $options = SB_Option::get();
    $value = isset($options['tbfa']['font_awesome']) ? $options['tbfa']['font_awesome'] : 1;
    $description = __('You can turn on or turn off Font Awesome loaded on your site.', 'sb-tbfa');
    $id = 'sb_tbfa_font_awesome';
    $args = array(
        'id' => $id,
        'name' => $name,
        'value' => $value,
        'description' => $description
    );
    SB_Field::switch_button($args);
}

function sb_tbfa_sanitize($input) {
    $data = $input;
    $data['tbfa']['bootstrap'] = isset($input['tbfa']['bootstrap']) ? $input['tbfa']['bootstrap'] : 1;
    $data['tbfa']['font_awesome'] = isset($input['tbfa']['font_awesome']) ? $input['tbfa']['font_awesome'] : 1;
    return $data;
}
add_filter('sb_options_sanitize', 'sb_tbfa_sanitize');