<?php

/**
 * Template Name: Single Challenge
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */


if ( is_user_logged_in() ) {
	$user = wp_get_current_user();
}
get_header();
global $wpdb;
$db_name = $wpdb->prefix . 'jsc_lesson_user';
// TODO remove the jsc and use namespaces instead?
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php

			// Start the loop.
			while ( have_posts() ) : the_post();
				$lesson_id = (int) get_the_ID();
				$single_users_lesson = $wpdb->get_results( "SELECT * FROM $db_name WHERE user_id = $user->ID AND lesson_id = $lesson_id");
                //$the_content = get_the_content();

                // Include the single post content template.
				get_template_part( 'template-parts/content', 'single' );
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

				?>

				<h1 class="jsc-title"><?php the_title();?></h1>
				<div class="jsc-fullwidth-container">
                    <span class="jsc-section-header">Description:</span>
                    <p class="jsc-section-content">
						<?php echo get_the_content();?>
                    </p>

				</div>
				<?php
				if ( is_user_logged_in() ) {

					if ( empty($single_users_lesson) ) { ?>
						<br>
						<div id="formArea">
							<form id="theForm">
								<input type="hidden" name="lesson_id" value="<?php echo $lesson_id; ?>">
								<!-- this puts the action solve_lesson_ajax_hook into the serialized form -->
								<input name="action" type="hidden" value="solve_lesson_ajax_hook" />&nbsp;
								<input id="submit_button" value="Solve Lesson" type="button" onClick="submit_me(<?php echo $user->ID;?>, <?php echo $lesson_id;?>);" />
							</form>
						</div>

						<?php
					} else {
						?>
						<div id="formArea">
							<br><span class="challengeIsSolved" id="solveChallenge">Lesson is Solved!</span>
							<form style="display:inline-block;" id="theForm">
								<input type="hidden" name="lesson_id" value="<?php echo $lesson_id; ?>">
								<!-- this puts the action reset_lesson_ajax_hook into the serialized form -->
								<input name="action" type="hidden" value="reset_lesson_ajax_hook" />&nbsp;
								<input id="reset_button" value = "Reset Lesson?" type="button" onClick="resetLesson(<?php echo $user->ID;?>, <?php echo $lesson_id;?>);" />
							</form>
						</div>
						<?php
					}
				} else {
					?>
					<div style="text-align: center;">
						<h3 class="user-message">You must have an account and be logged in to solve challenges!</h3>

						<div style="text-align: center;">
							<a href="<?php echo wp_registration_url(); ?>">
								<div class="btn-main">
									<h3>Create an Account</h3>
								</div>
							</a>

							<a href="<?php echo wp_login_url(home_url()); ?>">
								<div class="btn-main">
									<h3>Log In</h3>
								</div>
							</a>
						</div>
					</div>
					<?php
				}
				// End of the loop.
			endwhile;
			?>

		</main><!-- .site-main -->

		<?php //get_sidebar( 'content-bottom' ); ?>

	</div><!-- .content-area -->

<?php// get_sidebar(); ?>
<?php get_footer(); ?>