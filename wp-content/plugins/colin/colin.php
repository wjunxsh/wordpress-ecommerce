<?php
/*
Plugin Name: Colin Plugin Test
Plugin URI: https://www.wjun365.com/plugins/colin/
Description: Basic WordPress Plugin Test by colin
Version: 20230731
Author: colin.wu
Author URI: https://www.wjun365.com/plugins/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/

/*
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

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'COLIN__VERSION', '1.0' );
define( 'COLIN__MINIMUM_WP_VERSION', '6.2' );
define( 'COLIN__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

register_activation_hook( __FILE__, array( 'Colin', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Colin', 'plugin_deactivation' ) );
require_once( COLIN__PLUGIN_DIR . 'class.colin.php' );


function wb_no_wordpress_errors(){
  return 'Something went wrong!';
  }
  add_filter( 'login_errors', 'wb_no_wordpress_errors' );
