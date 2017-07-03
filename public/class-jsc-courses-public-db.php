<?php
/**
 * Created by PhpStorm.
 * User: johncurry
 * Date: 6/28/17
 * Time: 11:50 PM
 */

class Jsc_Courses_Public_Db {

	function solve_lesson_function(){
		global $wpdb;
		$user = wp_get_current_user();
		$lesson_id = (int) $_POST['lesson_id'];
		$wpdb->insert(
			$wpdb->prefix . 'jsc_lesson_user',
			array(
				'user_id' => $user->ID,
				'lesson_id' => $lesson_id
			)
		);

		die();
	}

	function reset_lesson_function(){
		global $wpdb;

		$user = wp_get_current_user();
		$lesson_id = (int) $_POST['lesson_id'];
		$wpdb->delete(
			$wpdb->prefix . 'jsc_lesson_user',
			array(
				'user_id' => $user->ID,
				'lesson_id' => $lesson_id
			)
		);
		die();
	}
}