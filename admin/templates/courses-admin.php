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

<?php
$args = array(
	'post_type' => 'lessons'
);

$lessons = get_posts( $args );

for ( $i = 0; $i < count($lessons); $i++ ) {
	?>
<div class="admin-lesson">
	<span class="admin-lesson-title"><?php echo $lessons[$i]->post_title;?></span>
</div>
<?php
//    TODO Create list of lesson ids to store in database as a "section"
    // TODO Access & display these lessons via shortcode
}