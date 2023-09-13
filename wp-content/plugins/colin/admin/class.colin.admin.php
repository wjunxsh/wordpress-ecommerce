<?php

class ColinAdmin {
    public static function init() {
        add_action('admin_menu', array( 'ColinAdmin', 'colin_options_page' ) );
    }
    public static function colin_options_page() {
        add_menu_page(
           'Colin菜单标题',
           'Colin菜单',
           'manage_options',
           'colin_test',
           array('ColinAdmin','wporg_options_page_html'),
           plugin_dir_url(__FILE__) . 'images/colin.icon.jpeg',
           20
        );
     }
    public static function wporg_options_page_html() {
        // check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
            <div class=wrap>
                <h1><?= esc_html(get_admin_page_title()); ?></h1>
                <form action=options.php method=post>
                <?php
                // output security fields for the registered setting wporg_options
                settings_fields('colin_options');
                // output setting sections and their fields
                // (sections are registered for wporg, each field is registered to a specific section)
                do_settings_sections('colin_test');
                // output save settings button
                submit_button('保存设置');
                ?>
                </form>
            </div>
        <?php
    }


}