<?php
/**
 * Created by PhpStorm.
 * User: johncurry
 * Date: 7/4/17
 * Time: 12:50 PM
 */

?>

<h1>Create a Section Shortcode</h1> (Then You can add lessons)<br>



<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
    Section Title: <br>
    <input type="text" name="section_title"> <br>
    <strong>Section Lessons:</strong> <br>
    <input type="hidden" name="action" value="test_custom_post">
    <input type="submit" value="submit">
</form>

<h1>You are editing the PHP Basics Section</h1>

<?php
global $wpdb;

$section_lessons = $wpdb->get_results("SELECT wp_posts.ID, wp_posts.post_title, wp_jsc_courses_sections.section_id, wp_jsc_courses_sections_lessons.position
FROM wp_posts
INNER JOIN wp_jsc_courses_sections_lessons ON wp_posts.ID=wp_jsc_courses_sections_lessons.lessons_id
INNER JOIN wp_jsc_courses_sections ON wp_jsc_courses_sections_lessons.sections_id=wp_jsc_courses_sections.section_id
WHERE post_type='lessons' AND wp_jsc_courses_sections.section_id = 1
ORDER BY wp_jsc_courses_sections_lessons.position");

//die(var_dump($section_lessons));

$count_lessons = count($section_lessons);
//TODO Create form with a position and the title of each lesson
//TODO learn javascript and dragging/dropping

?>
<form id="sectionForm">
<?php

//echo "<input type='hidden' name='section_id' value='" . $section_lessons[0]->section_id . "'";
for ($i = 0; $i < $count_lessons; $i++) {
    echo "<div ondragleave='dragleave_handler(event);' ondrop='drop_handler(event);' ondragover='dragover_handler(event);' id='" . $section_lessons[$i]->ID . "' draggable='true' ondragstart='dragstart_handler(event);' class='admin-lesson'><strong>" . $section_lessons[$i]->post_title . "</strong>";
    echo "<input type='number' name='post_" . $section_lessons[$i]->ID ."' value='". $section_lessons[$i]->position . "' ></div>";
	//echo '<div class="dropzone" id="target" ondragleave="dragleave_handler(event);" ondrop="drop_handler(event);" ondragover="dragover_handler(event);"></div>';
}
?>

</form>

<?php
//    TODO Create list of lesson ids to store in database as a "section"
    // TODO Access & display these lessons via shortcode