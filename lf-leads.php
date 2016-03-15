<?php
/**
 * Plugin Name: LeadFerry Leads
 * Description: Integrates with multiple form plugins to capture lead info and displays lead profiles on WordPress
 * Version: 0.1.0
 * Author: LeadFerry
 * Author URI: https://leadferry.com/
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */
/*
    LeadFerry Leads - WordPress plugin to capture lead info for LeadFerry users and display lead profiles
    Copyright (C) 2016  LeadFerry (https://leadferry.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

define('LEADFERRY_PLUGIN', __FILE__);
define('LEADFERRY_SLUG', basename(__FILE__, '.php'));
define('LEADFERRY_URL', plugin_dir_url(__FILE__));
define('LEADFERRY_PATH', plugin_dir_path(__FILE__));
define('LEADFERRY_LIB_URL', LEADFERRY_URL . 'vendor/');
define('LEADFERRY_LIB_PATH', LEADFERRY_PATH . 'vendor/');
define('LF_PREFIX', 'lf_');

include_once(dirname(__FILE__) . '/leads/leads.php');