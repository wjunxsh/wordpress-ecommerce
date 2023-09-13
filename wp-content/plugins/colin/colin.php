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
define( 'COLIN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
require_once( COLIN_PLUGIN_DIR . 'class.akismet.php' );
if ( is_admin() ) {
    require_once( COLIN_PLUGIN_DIR . 'admin/class.colin.admin.php' );
	add_action( 'init', array( 'Akismet_Admin', 'init' ) );
}

//初始化插件,激活
register_activation_hook( __FILE__, array( 'Colin', 'plugin_activation' ) );
//撤销激活
register_deactivation_hook( __FILE__, array( 'Colin', 'plugin_deactivation' ) );
