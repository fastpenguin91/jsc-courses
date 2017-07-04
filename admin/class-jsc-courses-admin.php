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

	}

	public function enqueue_scripts() {

	}
}