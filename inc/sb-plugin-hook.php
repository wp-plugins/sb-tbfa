<?php
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