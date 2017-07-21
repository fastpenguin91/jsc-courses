<?php
/**
 * Created by PhpStorm.
 * User: johncurry
 * Date: 7/4/17
 * Time: 12:50 PM
 */

?>

<h1>Create a NEW Section Shortcode</h1> <br>

<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . 'class-jsc-courses-admin.php'; ?>


    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
        <h3>Section Title:</h3> <br>
        <input type="text" name="section_title"> <br>
        <input type="hidden" name="action" value="test_custom_post">
        <input type="submit" value="submit">
    </form>

    <h3>Select a Lesson to Edit:</h3>

    <form id="theForm">
        <input type="hidden" name="challenge_id" value="149">
        <!-- this puts the action solve_challenge_ajax_hook into the serialized form -->
        <!--<input name="action" type="hidden" value="solve_challenge_ajax_hook" />&nbsp;-->
        <input id="submit_button" value="Solve Challenge" type="button" onClick="submit_me(3, 149);" />
    </form>

<div id="lessonsGoHere">Test area</div>

    <!--<form id="selectSectionForm">-->

    <?php //echo Jsc_Courses_Admin::display_all_sections(); ?>

  <!--  </form> -->

    <h1>You are editing the PHP Basics Section</h1>
    <h3>Section Lessons:</h3> <br>


<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="sectionForm">
<input type='hidden' name='action' value='update_lesson_position'>
<input type="submit" value="submit">
<?php

echo Jsc_Courses_Admin::add_position_fields();

?>

</form>

<h2>Add a Lesson</h2>

<?php

echo Jsc_Courses_Admin::add_all_position_fields();