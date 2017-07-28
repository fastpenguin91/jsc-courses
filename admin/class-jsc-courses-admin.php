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
		wp_register_style('custom-courses-admin-css', plugin_dir_url( __FILE__ ) . '/css/jsc-courses-admin.css');
		wp_enqueue_style('custom-courses-admin-css');
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'jsc-courses-sections-handle', plugin_dir_url( __FILE__ ) . 'js/dragndrop.js', array( 'jquery' ) );
		wp_localize_script( 'jsc-courses-sections-handle', 'dragDropData', array() );

		wp_enqueue_script( 'ajax-script', plugin_dir_url( __FILE__ ) . 'js/solve_challenge_ajax.js', array( 'jquery' ) );
		wp_localize_script( 'ajax-script', 'ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => '11111' ) );
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

	}

	public function prepare_post_args($post_arrays){
		$insert_array = array();
		$update_array = array();
		$array_count = count($post_arrays['lesson_positions']);

		for ($i = 0; $i < $array_count; $i++) {

			if ($post_arrays['sl_ids'][$i] == '') {
				array_push($insert_array, array(
					'post_id'         => $post_arrays['post_ids'][$i],
					'lesson_position' => $post_arrays['lesson_positions'][$i],
					'sl_id'           => $post_arrays['sl_ids'][$i],
					'section_id'  => $post_arrays['section_ids'][$i]
					)
				);

			} else {
				array_push( $update_array, array(
					'post_id'         => $post_arrays['post_ids'][$i],
					'lesson_position' => $post_arrays['lesson_positions'][$i],
					'sl_id'           => $post_arrays['sl_ids'][$i],
					'section_id'  => $post_arrays['section_ids'][$i]
					)
				);

			}
		}
		$post_hash = array($insert_array, $update_array);
		return $post_hash;
	}

	public function prepare_sql_string($prepared_post_params){
		global $wpdb;
		$insert_array = $prepared_post_params[0];
		$existing_values = $prepared_post_params[1];

		$insert_sql_string = 'INSERT INTO ' . $wpdb->prefix . 'jsc_courses_sections_lessons (sections_id, lessons_id, position) VALUES ';
		$update_sql_string = 'UPDATE ' . $wpdb->prefix . 'jsc_courses_sections_lessons SET position = CASE ';

		// The UPDATE sql string requires the ids to be placed in a WHERE IN ( ) clause at the end of the statement.
		$update_sql_string_end = '';



		for ($i = 0; $i < count($insert_array); $i++) {
			$insert_sql_string .= '( ' . $insert_array[$i]['section_id'] . ', ' . $insert_array[$i]['post_id'] . ', ' . $insert_array[$i]['lesson_position'] . ')';

			// if NOT at the end of the loop, add comma.
			if ($i < ( count($insert_array) - 1) ) {
				$insert_sql_string .= ',';
			}
		}

		for ($i = 0; $i < count($existing_values); $i++) {
			$update_sql_string .= 'WHEN sl_id = ' . $existing_values[$i]['sl_id'] . ' THEN ' . $existing_values[$i]['lesson_position'] . ' ' ;
			$update_sql_string_end .= $existing_values[$i]['sl_id'];

			// if NOT at the end of the loop, add comma.
			if ($i < ( count($existing_values) - 1) ) {
				$update_sql_string_end .= ',';
			} else {
				$update_sql_string .= ' END WHERE sl_id IN (' . $update_sql_string_end . ');';
			}
		}

		$sql_strings = array($insert_sql_string, $update_sql_string);

		return $sql_strings;

	}

	public function jsc_update_position(){
		global $wpdb;

		//match sl_id with new_position
		$post_arrays = array(
			'post_ids'         => $_POST['post_ids'],
			'lesson_positions' => $_POST['lesson_positions'],
			'sl_ids'           => $_POST['sl_ids'],
			'section_ids'      => $_POST['section_ids']
		);

		$prepared_post_params = $this->prepare_post_args($post_arrays);

		$sql_strings = $this->prepare_sql_string($prepared_post_params);

		$wpdb->query($sql_strings[0]);
		$wpdb->query($sql_strings[1]);

		wp_redirect( admin_url() );
		exit;

	}


	public function get_section_lessons($section_id){
		global $wpdb;

		return $wpdb->get_results("SELECT wp_posts.ID, wp_posts.post_title, wp_jsc_courses_sections.section_id, wp_jsc_courses_sections_lessons.position, wp_jsc_courses_sections_lessons.sl_id
FROM wp_posts
INNER JOIN wp_jsc_courses_sections_lessons ON wp_posts.ID=wp_jsc_courses_sections_lessons.lessons_id
INNER JOIN wp_jsc_courses_sections ON wp_jsc_courses_sections_lessons.sections_id=wp_jsc_courses_sections.section_id
WHERE post_type='lessons' AND wp_jsc_courses_sections.section_id =" . $section_id . "
ORDER BY wp_jsc_courses_sections_lessons.position");
	}

	public function get_all_lessons(){
		global $wpdb;

		return $wpdb->get_results("SELECT wp_posts.ID, wp_posts.post_title
FROM wp_posts 
INNER JOIN wp_jsc_courses_sections_lessons ON wp_posts.ID=wp_jsc_courses_sections_lessons.lessons_id
INNER JOIN wp_jsc_courses_sections ON wp_jsc_courses_sections_lessons.sections_id=wp_jsc_courses_sections.section_id
WHERE post_type='lessons' AND wp_jsc_courses_sections.section_id = 2");

	}

	public function add_position_fields($section_lessons, $section_id){
		//$section_lessons = self::get_section_lessons(1);
		$html = '';

		for ($i = 0; $i < count($section_lessons); $i++) {
			$html .= "<div ondragleave='dragleave_handler(event);' ondrop='drop_handler(event);' ondragover='dragover_handler(event);' id='" . $section_lessons[$i]->ID . "' draggable='true' ondragstart='dragstart_handler(event);' class='admin-lesson'><strong>" . $section_lessons[$i]->post_title . "</strong>";
			$html .= "<input class='lesson_position' type='number' name='lesson_positions[]' value='". $section_lessons[$i]->position . "' >";
			$html .= 'post_id: ' . $section_lessons[$i]->ID . ' sl_id: ' . $section_lessons[$i]->sl_id . "<input type='hidden' name='post_ids[]' value='". $section_lessons[$i]->ID ."'>";
			$html .= "<input type='hidden' name='sl_ids[]' value='". $section_lessons[$i]->sl_id . "'>";
			$html .= "<input type='hidden' name='section_ids[]' value='" . $section_id . "'></div>";
		}

		return $html;
	}

	public function add_all_position_fields(){
		$all_lessons = self::get_all_lessons();
		$html = '';

		for ($i = 0; $i < count($all_lessons); $i++) {
			$html .= "<div ondragleave='dragleave_handler(event);' ondrop='drop_handler(event);' ondragover='dragover_handler(event);' id='" . $all_lessons[$i]->ID . "' draggable='true' ondragstart='dragstart_handler(event);' class='admin-lesson'><strong>" . $all_lessons[$i]->post_title . "</strong>";
			$html .= "<input class='lesson_position' type='number' name='lesson_positions[]' value='". $all_lessons[$i]->position . "' >";
			$html .= 'post_id: ' . $all_lessons[$i]->ID . ' sl_id: ' . $all_lessons[$i]->sl_id . "<input type='hidden' name='post_ids[]' value='". $all_lessons[$i]->ID ."'>";
			$html .= "<input type='hidden' name='sl_ids[]' value='". NULL . "'>";
			$html .= "<input type='hidden' name='section_ids[]' value='1'></div>";
		}

		return $html;
	}

	public function get_all_sections(){
		global $wpdb;

		return $wpdb->get_results("SELECT title, section_id FROM wp_jsc_courses_sections");
	}

	public function display_all_sections(){
		$sections = self::get_all_sections();
		$html = '';

		for ($i = 0; $i < count($sections); $i++) {
			$html .= "<div onclick='select_section(". $sections[$i]->section_id . ");' class='admin-lesson'>" . $sections[$i]->title . "</div>";
		}

		return $html;
	}


	public function prepare_section_lessons_html(){ //was my_action
		global $wpdb; // this is how you get access to the database

		//Takes the section_id
		$whatever = $_POST['whatever'];

		//creates an array of all the lessons in that section
		$lessons_array = self::get_section_lessons($whatever);

		//turns the lessons into an HTML string
		$section_lessons_html = self::add_position_fields($lessons_array, $whatever);


		// sends string of all lessons to be placed in the section
		echo $section_lessons_html;

		wp_die(); // this is required to terminate immediately and return a proper response
	}


}