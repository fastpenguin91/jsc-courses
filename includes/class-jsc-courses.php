<?php
/**
 * Created by PhpStorm.
 * User: johncurry
 * Date: 6/27/17
 * Time: 6:17 PM
 */

class Jsc_Courses {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Jsc_Courses_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;



	public function __construct() {

		$this->plugin_name = 'jsc-courses';
		$this->version = '1.0.0';


		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies(){
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jsc-courses-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-jsc-courses-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-jsc-courses-public-db.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-jsc-courses-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jsc-courses-shortcodes.php';

		$this->loader = new Jsc_Courses_Loader();
	}

	private function define_public_hooks(){
		$jsc_courses_public = new Jsc_Courses_Public( $this->get_plugin_name(), $this->get_version() );
		$jsc_courses_public_db = new Jsc_Courses_Public_Db();

		$this->loader->add_action('wp_enqueue_scripts', $jsc_courses_public, 'enqueue_scripts' );
		$this->loader->add_action('wp_enqueue_scripts', $jsc_courses_public, 'enqueue_styles' );

		$this->loader->add_filter('single_template', $jsc_courses_public, 'get_single_lesson_template' );

		$this->loader->add_action('wp_ajax_solve_lesson_ajax_hook', $jsc_courses_public_db, 'solve_lesson_function' );
		$this->loader->add_action('wp_ajax_reset_lesson_ajax_hook', $jsc_courses_public_db, 'reset_lesson_function' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$jsc_courses_admin = new Jsc_Courses_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_post_update_lesson_position', $jsc_courses_admin, 'jsc_update_position' );
		$this->loader->add_action( 'admin_post_test_custom_post', $jsc_courses_admin, 'jsc_create_section' );
		$this->loader->add_action( 'admin_enqueue_scripts', $jsc_courses_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $jsc_courses_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $jsc_courses_admin, 'create_lesson' );
		$this->loader->add_action( 'admin_menu', $jsc_courses_admin, 'add_menu' );
		$this->loader->add_action('wp_ajax_prepare_section_lessons_html', $jsc_courses_admin, 'prepare_section_lessons_html' );
//die('this function is called before the admin page is rendered');
		$courses_shortcodes = new Jsc_Courses_Shortcodes();

		$this->loader->add_action('init', $courses_shortcodes, 'register_shortcodes' );
	}

	public function get_plugin_name(){
		return $this->plugin_name;
	}

	public function get_version(){
		return $this->version;
	}

	public function run(){
		$this->loader->run();
	}
}