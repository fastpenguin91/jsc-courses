<?php
/**
 * Created by PhpStorm.
 * User: johncurry
 * Date: 6/28/17
 * Time: 6:55 PM
 */

class Jsc_Courses_Dba {


	/**
	 * @return string
	 * Returns a string that is prepared as an SQL query for WordPress
	 * Probably want to refactor this and pass in an array of options so it can be re-used for other queries
	 */
	public function getSqlString(){
		global $wpdb;
		global $cc_jsc_courses_db_version;
		$table_name = $wpdb->prefix . 'jsc_lesson_user';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        lesson_id mediumint(9) NOT NULL,
        user_id mediumint(9) NOT NULL,
        PRIMARY KEY  (id)
      ) $charset_collate;";

		return $sql;
	}


	/**
	 * @param $sql
	 * Inserts the sql into the dbDelta function to run the query
	 */
	public function insertSql($sql){
		global $wpdb;
		global $cc_jsc_courses_db_version;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		add_option( 'cc_jsc_db_version', $cc_jsc_courses_db_version );
	}
}