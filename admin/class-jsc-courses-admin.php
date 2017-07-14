<?php
/**
 * Created by PhpStorm.
 * User: johncurry
 * Date: 6/27/17
 * Time: 6:20 PM
 */

class Jsc_Courses_Admin {

	public function __construct(){
	}

	public function add_menu(){
		add_menu_page(
			'JSC Courses',
			'JSC Courses',
			'read',
			'jsc-courses/admin/templates/courses-admin.php'
		);
	}

	public function create_lesson(){
		$labels = array(
			'name'          => 'Lessons',
			'singular_name' => 'Lesson',
			'add_new'       => 'Add New Lesson',
			'edit_item'     => 'Edit Lesson',
			'new_item'      => 'New Lesson',
			'view_item'     => 'View Lesson',
			'view_items'    => 'View Lessons',
			'all_items'     => 'All Lessons',
			'menu_name'     => 'Lessons'
		);

		$args = array(
			'labels'       => $labels,
			'description'  => 'Manage your Lessons',
			'public'       => true,
			'show_in_menu' => true
		);

		register_post_type( 'Lessons', $args );
	}

	public function enqueue_styles(){
		//die(var_dump(plugins_url() . '/jsc-courses/admin/css' ) );
		wp_register_style('custom-courses-admin-css', plugin_dir_url( __FILE__ ) . '/css/jsc-courses-admin.css');
		wp_enqueue_style('custom-courses-admin-css');
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'jsc-courses-sections-handle', plugin_dir_url( __FILE__ ) . 'js/dragndrop.js', array( 'jquery' ) );
		wp_localize_script( 'jsc-courses-sections-handle', 'dragDropData', array() );
	}

	public function jsc_create_section() {
		global $wpdb;
		$title_name = sanitize_text_field( $_POST['section_title'] );

		$data = array(
			'title' => $title_name
		);

		$table = $wpdb->prefix . 'jsc_courses_sections';

		$wpdb->insert( $table, $data );

		wp_redirect( admin_url() );
		exit;

		//die('yeaaaaah died in the create section function');
	}

	public function jsc_update_position(){
		die(var_dump($_POST) );
	}
}