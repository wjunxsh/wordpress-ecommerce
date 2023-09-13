<?php
Class Colin {
    public static function init() {

    }
    public static function plugin_activation() {
        //如果插件有表结构，可以在这里调用数据库创建
        self::initTable();
    }
    public static function plugin_deactivation() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'colin_test'; // 你的表格名
        $sql = "DROP TABLE $table_name;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
    public static function initTable(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'colin_test'; // 你的表格名

        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            name tinytext NOT NULL,
            text text NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
}