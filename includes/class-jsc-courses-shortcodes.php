<?php
/**
 * Created by PhpStorm.
 * User: johncurry
 * Date: 7/8/17
 * Time: 5:55 PM
 */

/*
 * For some reason I am unable to include this class via the /includes/class-jsc-courses and still have the shortcodes
 * be registered.
*/

class Jsc_Courses_Shortcodes {

	public function add_shortcodes(){
		add_action('init', array( $this, 'register_shortcodes' ) );
	}

	public function register_shortcodes( $atts ) {
		//die('still works!');
		add_shortcode( 'bartag', array( $this, 'bartag_func' ) );
	}

	public function bartag_func(){
		$a = shortcode_atts( array(
			'foo' => 'something great',
			'bar' => 'something else awesome',
		), $atts );

		return "foo = {$a['foo']}";
	}

}

$jsc_courses_shortcodes = new Jsc_Courses_Shortcodes();
$jsc_courses_shortcodes->add_shortcodes();