<?php
/*
Plugin Name: Colin test
Plugin URI: https://www.wjun365.com/
Description: Colin test
Version: 20230912
Author: Colin.wu
Author URI: https://www.wjun365.com/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {URI to Plugin License}.

*/

function pluginprefix_install() {

}
function pluginprefix_deactivation() {}

function wporg_custom() {
    // 执行某些操作
}
add_action('init', 'wporg_custom');

function wporg_filter_title($title) {
    return '文章：' . $title . '已被修改。';
}
add_filter('the_title', 'wporg_filter_title');

//初始化插件,激活
register_activation_hook( __FILE__, 'pluginprefix_install' );
//撤销激活
register_deactivation_hook( __FILE__, 'pluginprefix_deactivation' );
