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

	}

	public function prepare_post_args($post_arrays){
		//die(var_dump($post_arrays));
		//$post_hash = array();
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
		//die(var_dump($post_hash));
		return $post_hash;
	}

	public function prepare_sql_string($prepared_post_params){
		global $wpdb;
		$insert_array = $prepared_post_params[0];
		$existing_values = $prepared_post_params[1];
		//die(var_dump($insert_array));
		$count_insert = count($insert_array);
		//die(var_dump($count_insert));
		$count_update = count($existing_values);
		$insert_sql_string = 'INSERT INTO ' . $wpdb->prefix . 'jsc_courses_sections_lessons (sections_id, lessons_id, position) VALUES ';
		$update_sql_string = 'UPDATE ' . $wpdb->prefix . 'jsc_courses_sections_lessons SET position = CASE ';
		$update_sql_string_end = '';

		/*UPDATE wp_jsc_courses_sections_lessons
SET position = CASE
    WHEN sl_id = '1' THEN 1
    WHEN sl_id = '2' THEN 2
END
WHERE sl_id IN (1,2);*/


		for ($i = 0; $i < $count_insert; $i++) {
			//die(var_dump($insert_array));
			//$insert_sql_string .= "hello, ";
			$insert_sql_string .= '( ' . $insert_array[$i]['section_id'] . ', ' . $insert_array[$i]['post_id'] . ', ' . $insert_array[$i]['lesson_position'] . ')';
			//var_dump($i);
			//var_dump($count_insert);
			// if NOT at the end of the loop, add comma.
			if ($i < ($count_insert - 1) ) {
				$insert_sql_string .= ',';
			}
		}

		for ($i = 0; $i < $count_update; $i++) {
			//die(var_dump($insert_array));
			//$insert_sql_string .= "hello, ";
			$update_sql_string .= 'WHEN sl_id = ' . $existing_values[$i]['sl_id'] . ' THEN ' . $existing_values[$i]['lesson_position'] . ' ' ;
			$update_sql_string_end .= $existing_values[$i]['sl_id'];
			//var_dump($i);
			//var_dump($count_update);
			// if NOT at the end of the loop, add comma.
			if ($i < ($count_update - 1) ) {
				$update_sql_string_end .= ',';
			} else {
				$update_sql_string .= ' END WHERE sl_id IN (' . $update_sql_string_end . ');';
			}
		}

		$sql_strings = array($insert_sql_string, $update_sql_string);

		return $sql_strings;

		//die(var_dump($update_sql_string));

		//SQL Statement up to the update portion.
		/*INSERT INTO wp_jsc_courses_sections_lessons
		(sl_id, sections_id, lessons_id, position)
VALUES
('', '100', '100', '100'),
('1', '1', '57', '1'),
('2', '1', '58', '2'),
('', '101', '101', '101')
ON DUPLICATE KEY UPDATE position=*/




		/*UPDATE wp_jsc_courses_sections_lessons
SET position = CASE
    WHEN sl_id = '1' THEN 1
    WHEN sl_id = '2' THEN 2
END
WHERE sl_id IN (1,2);


INSERT INTO wp_jsc_courses_sections_lessons
		(sl_id, sections_id, lessons_id, position)
VALUES
('', '100', '100', '100'),
('1', '1', '57', '1'),
('2', '1', '58', '2'),
('', '101', '101', '101')
ON DUPLICATE KEY UPDATE position=*/


		/*INSERT INTO wp_jsc_courses_sections_lessons
		(sl_id, sections_id, lessons_id, position)
VALUES
('', '100', '100', '100'),
	('1', '1', '57', '100'),
	('2', '1', '58', '200'),
	('', '101', '101', '101')
ON DUPLICATE KEY UPDATE wp_jsc_courses_sections_lessons
SET position = CASE
    WHEN sl_id = '1' THEN 100
    WHEN sl_id = '2' THEN 200
END
WHERE sl_id IN (1,2); */


	}

	public function jsc_update_position(){
		global $wpdb;
		//match sl_id with new_position
		//die(var_dump($_POST));
		$post_arrays = array(
			'post_ids'         => $_POST['post_ids'],
			'lesson_positions' => $_POST['lesson_positions'],
			'sl_ids'           => $_POST['sl_ids'],
			'section_ids'      => $_POST['section_ids']
		);

		$prepared_post_params = $this->prepare_post_args($post_arrays);

		$sql_strings = $this->prepare_sql_string($prepared_post_params);

		//die(var_dump($sql_strings));

		//die(var_dump($sql_strings[1]));

		$wpdb->query($sql_strings[0]);
		$wpdb->query($sql_strings[1]);

		wp_redirect( admin_url() );
		exit;


		//ON DUPLICATE (sl_id) Primary KEY UPDATE
		//$elem_count = count($_POST);


	}
}