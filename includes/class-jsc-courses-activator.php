<?php

class Jsc_Courses_Activator {

	public function __construct() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jsc-courses-dba.php';
		$this->jsc_courses_dba = new Jsc_Courses_Dba();

	}

	public function activatePlugin(){
		$this->createLessonUserTable();
	}


	/**
	 * runs the code in a Database access class that creates the LessonUser table
	 */
	public function createLessonUserTable() {
		$sql = $this->jsc_courses_dba->getSqlString();
		$this->jsc_courses_dba->insertSql($sql);
	}
}