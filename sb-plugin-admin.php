<?php
function sb_tbfa_menu() {
    sb_add_submenu_page("SB TBFA", "sb_tbfa", "sb_admin_setting_callback");
}
add_action("sb_admin_menu", "sb_tbfa_menu");

function sb_tbfa_tab($tabs) {
    $tabs["sb_tbfa"] = array('title' => "SB TBFA", 'section_id' => "sb_tbfa_section", "type" => "plugin");
    return $tabs;
}
add_filter("sb_admin_tabs", "sb_tbfa_tab");

function sb_tbfa_setting_field() {
    sb_add_setting_section("sb_tbfa_section", __("SB TBFA options page", "sbteam"), "sb_tbfa");
    sb_add_setting_field("sb_tbfa_bootstrap", "Bootstrap", "sb_tbfa_section", "sb_tbfa_bootstrap_callback", "sb_tbfa");
    sb_add_setting_field("sb_tbfa_font_awesome", "Font Awesome", "sb_tbfa_section", "sb_tbfa_font_awesome_callback", "sb_tbfa");
}
add_action("sb_admin_init", "sb_tbfa_setting_field");

function sb_tbfa_bootstrap_callback() {
    $name = "sb_tbfa_bootstrap";
    $options = get_option("sb_options");
    $value = isset($options["tbfa"]["bootstrap"]) ? $options["tbfa"]["bootstrap"] : 1;
    $description = __("You can turn on or turn off Twitter Bootstrap loaded on your site.", "sbteam");
    $enable = (bool) $value;
    $class = "switch-button";
    $class_on = $class . ' on';
    $class_off = $class . ' off';
    if($enable) {
        $class_on .= " active";
    } else {
        $class_off .= " active";
    }
    ?>
    <fieldset class="sbtheme-switch">
        <div class="switch-options">
            <label data-switch="on" class="<?php echo $class_on; ?> left"><span><?php _e("On", "sbteam"); ?></span></label>
            <label data-switch="off" class="<?php echo $class_off; ?> right"><span><?php _e("Off", "sbteam"); ?></span></label>
            <input type="hidden" value="<?php echo $value; ?>" name="<?php echo esc_attr("sb_options[tbfa][bootstrap]"); ?>" id="<?php echo $name; ?>" class="checkbox checkbox-input">
            <p class="description"><?php echo $description; ?></p>
        </div>
    </fieldset>
<?php
}

function sb_tbfa_font_awesome_callback() {
    $name = "sb_tbfa_font_awesome";
    $options = get_option("sb_options");
    $value = isset($options["tbfa"]["font_awesome"]) ? $options["tbfa"]["font_awesome"] : 1;
    $description = __("You can turn on or turn off Font Awesome loaded on your site.", "sbteam");
    $enable = (bool) $value;
    $class = "switch-button";
    $class_on = $class . ' on';
    $class_off = $class . ' off';
    if($enable) {
        $class_on .= " active";
    } else {
        $class_off .= " active";
    }
    ?>
    <fieldset class="sbtheme-switch">
        <div class="switch-options">
            <label data-switch="on" class="<?php echo $class_on; ?> left"><span><?php _e("On", "sbteam"); ?></span></label>
            <label data-switch="off" class="<?php echo $class_off; ?> right"><span><?php _e("Off", "sbteam"); ?></span></label>
            <input type="hidden" value="<?php echo $value; ?>" name="<?php echo esc_attr("sb_options[tbfa][font_awesome]"); ?>" id="<?php echo $name; ?>" class="checkbox checkbox-input">
            <p class="description"><?php echo $description; ?></p>
        </div>
    </fieldset>
<?php
}

function sb_tbfa_sanitize($input) {
    $data = $input;
    $data["tbfa"]["bootstrap"] = isset($input["tbfa"]["bootstrap"]) ? $input["tbfa"]["bootstrap"] : 1;
    $data["tbfa"]["font_awesome"] = isset($input["tbfa"]["font_awesome"]) ? $input["tbfa"]["font_awesome"] : 1;
    return $data;
}
add_filter("sb_options_sanitize", "sb_tbfa_sanitize");