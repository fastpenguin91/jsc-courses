<?php
/**
 * Created by PhpStorm.
 * User: johncurry
 * Date: 6/28/17
 * Time: 10:40 PM
 */

class Jsc_Courses_Public {

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jsc-courses-public.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'jsc-courses-ajax-handle', plugin_dir_url( __FILE__ ) . 'js/solve_lesson_ajax.js', array( 'jquery' ) );
		wp_localize_script( 'jsc-courses-ajax-handle', 'solve_lesson_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	public function get_single_lesson_template($single_template) {

		global $post;
		if ($post->post_type == 'lessons') {
			$single_template = dirname( __FILE__ ) . '/templates/single-lesson.php';
		}
		return $single_template;
	}



}