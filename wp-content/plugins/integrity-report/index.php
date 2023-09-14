<?php
/*
Plugin Name: Integrity Report
Description: This is a plugin that show a integrity report form and sends data to pr via SMTP.
Version: 1.0.2
Author: Anker DTC IT
*/

// Integrity Report Agree Bar
define( 'INTEGRITY_REPORT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
require_once( INTEGRITY_REPORT_PLUGIN_DIR . 'action.php' );
require_once( INTEGRITY_REPORT_PLUGIN_DIR . 'shortcode.php' );
IntegrityReportAction::init();
IntegrityReportShortcode::init();