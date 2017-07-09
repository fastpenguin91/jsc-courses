<?php
/**
 * Created by PhpStorm.
 * User: johncurry
 * Date: 7/4/17
 * Time: 12:50 PM
 */

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