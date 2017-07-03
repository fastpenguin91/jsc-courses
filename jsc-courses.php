<?php

/*
Plugin Name: Jsc Courses
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: johncurry
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

register_activation_hook( __FILE__, 'activate_jsc_courses' );

/**
 * Runs all necessary setup code for plugin
 */
function activate_jsc_courses(){
	require_once( plugin_dir_path( __FILE__ ) . '/includes/class-jsc-courses-activator.php' );
	$jsc_courses_activator = new Jsc_Courses_Activator();
	$jsc_courses_activator->activatePlugin();
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jsc-courses.php';

function run_jsc_courses(){
	$plugin = new Jsc_Courses();
	$plugin->run();
}

run_jsc_courses();
