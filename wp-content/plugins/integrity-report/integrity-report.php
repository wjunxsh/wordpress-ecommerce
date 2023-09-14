<?php
/*
Plugin Name: Integrity Report
Description: This is a plugin that show a integrity report form and sends data to pr via SMTP.
Version: 1.0
Author: Anker DTC IT
*/

// Integrity Report Agree Bar

// process submit form
define( 'INTEGRITY_REPORT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
require_once( INTEGRITY_REPORT_PLUGIN_DIR . 'claaa.integrity-report.backend.php' );
require_once( INTEGRITY_REPORT_PLUGIN_DIR . 'class.integrity-report.front.php' );
IntegrityReportBackend::init();
IntegrityReportFront::init();