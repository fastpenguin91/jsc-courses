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

/* Phony Database

SELECT *
FROM lessons
INNER JOIN sections_lessons ON lessons.id=sections_lessons.lessons_id
INNER JOIN sections ON sections_lessons.sections_id=sections.id
WHERE sections_lessons.sections_id = 1
ORDER BY sections_lessons.position

*/
// TODO change the database name to something shorter!
// TODO admin page needs to add a section to the table
// TODO admin page adds sections_lessons to the table when lesson is added to a section
/* With WordPress Database.
SELECT wp_jsc_courses_sections.title, wp_posts.ID, wp_posts.post_title, wp_posts.post_type, wp_jsc_courses_sections_lessons.position
FROM wp_posts
INNER JOIN wp_jsc_courses_sections_lessons ON wp_posts.ID=wp_jsc_courses_sections_lessons.lessons_id
INNER JOIN wp_jsc_courses_sections ON wp_jsc_courses_sections_lessons.sections_id = wp_jsc_courses_sections.id
WHERE post_type = 'lessons' AND wp_jsc_courses_sections.id = 1
ORDER BY wp_jsc_courses_sections_lessons.position;
*/

class Jsc_Courses_Shortcodes {

	public function add_shortcodes(){
		add_action('init', array( $this, 'register_shortcodes' ) );
	}

	public function register_shortcodes( $atts ) {
		add_shortcode( 'bartag', array( $this, 'bartag_func' ) );
	}

	public function bartag_func(){

		global $wpdb;

		$results = $wpdb->get_results( 'SELECT wp_jsc_courses_sections.title, wp_posts.ID, wp_posts.post_title
FROM wp_posts
INNER JOIN wp_jsc_courses_sections_lessons ON wp_posts.ID=wp_jsc_courses_sections_lessons.lessons_id
INNER JOIN wp_jsc_courses_sections ON wp_jsc_courses_sections_lessons.sections_id = wp_jsc_courses_sections.id
WHERE post_type = \'lessons\' AND wp_jsc_courses_sections.id = 1
ORDER BY wp_jsc_courses_sections_lessons.position;' );


		$section_title = $results[0]->title;

		//die(var_dump( get_post_permalink( $results[0]->ID ) ) );

		$anotherTest = count($results);

		$html = "<div class='jsc-course-section'><h1>$section_title</h1>";

		for ($i = 0; $i < $anotherTest; $i++ ) {
			$html .= "<a href='" . get_post_permalink( $results[$i]->ID ) . "'><div class='challenge_list_item'>" . $results[$i]->post_title . "</div></a>";
		}

		$html .="</div>";

		return $html;
	}

}

$jsc_courses_shortcodes = new Jsc_Courses_Shortcodes();
$jsc_courses_shortcodes->add_shortcodes();