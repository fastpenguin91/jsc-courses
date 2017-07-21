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


// TODO change the database name to something shorter!
// TODO admin page needs to add a section to the table
// TODO admin page adds sections_lessons to the table when lesson is added to a section

class Jsc_Courses_Shortcodes {

	public function register_shortcodes( $atts ) {
		add_shortcode( 'jsc-courses-show-section', array( $this, 'display_sc_section' ) );
	}

	public function load_dependencies(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jsc-courses-dba.php';
	}

	// Display the results of the shortcode
	// TODO Getting the title of the section in every result is redundant. Find a better way.
	public function display_sc_section( $atts ){

		$a = shortcode_atts( array(
			'section' => 'section id required'
		), $atts );

		$results = Jsc_Courses_Dba::prepare_shortcode_results($a['section']);

		$section_title = $results[0]->title;

		$html = "<div class='jsc-course-section'><h1>$section_title</h1>";

		for ($i = 0; $i < count($results); $i++ ) {
			$html .= "<a href='" . get_post_permalink( $results[$i]->ID ) . "'><div class='challenge_list_item'>" . $results[$i]->post_title . "</div></a>";
		}

		$html .="</div>";

		return $html;
	}

}

$jsc_courses_shortcodes = new Jsc_Courses_Shortcodes();
$jsc_courses_shortcodes->load_dependencies();