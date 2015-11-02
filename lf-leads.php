<?php
/**
 * Plugin Name: LeadFerry Lead Profiles
 * Description: LeadFerry Lead Profiles Plugin
 * Version: 0.0.1
 * Author: LeadFerry
 */

define('LEADFERRY_PLUGIN', __FILE__);
define('LEADFERRY_SLUG', basename(__FILE__, '.php'));
define('LEADFERRY_URL', plugin_dir_url(__FILE__));
define('LEADFERRY_PATH', plugin_dir_path(__FILE__));
define('LEADFERRY_LIB_URL', LEADFERRY_URL . 'vendor/');
define('LEADFERRY_LIB_PATH', LEADFERRY_PATH . 'vendor/');
define('LF_PREFIX', 'lf_');

include_once(dirname(__FILE__) . '/leads/leads.php');