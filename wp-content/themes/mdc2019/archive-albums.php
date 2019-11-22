<?php
/**
 * The template for displaying Archive pages.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
			<?php
			do_action( 'generate_before_main_content' );

			$args_raduniufficiali = array(
				'child_of'			=> 4609,
				'depth'				=> 2,
				'echo'				=> false,
				'post_type'			=> 'albums',
				'post_status'		=> 'publish',
				'sort_column'		=> 'post_title',
				'title_li'			=> '',
				'sort_order'		=> 'desc'
			);
			$args_partecipazioni = array(
				'child_of'			=> 46,
				'depth'				=> 2,
				'echo'				=> false,
				'post_type'			=> 'albums',
				'post_status'		=> 'publish',
				'sort_column'		=> 'post_title',
				'title_li'			=> '',
				'sort_order'		=> 'desc'
			);

			?>
			<section id="latestNews" class="section section-home section-home-latestnews">
				<div class="inside-article">
					<header class="section-header">
						<h2 class="section-title" itemprop="headline">RADUNI UFFICIALI</h2>			
					</header><!-- .section-header -->

					<div class="section-summary" itemprop="text">
						<?php 
						$raduniufficiali = get_pages($args_raduniufficiali);
						if (!empty($raduniufficiali)) {
							foreach ($raduniufficiali as $r) { 
								if($r->post_content && $r->post_content == '[gallery]') {
									echo '</ul><ul class="mdc-fotolist"><li class="mdc-fotolist-title"><h3 class="mdc-fotolist-year">'.$r->post_title.'</h3></li><ul>';
								} else {
									$fotolist_thumb = get_the_post_thumbnail($r->ID,'medium');
									echo '<li class="mdc-fotolist-item"><a href="'. get_permalink($r->ID).'">'.$fotolist_thumb.'<span>'.$r->post_title.'</span></a></li>';
								}

							 }
							 echo '</ul>';
						}
						?>
					</div>
				</div>

				<div class="inside-article">
					<header class="section-header">
						<h2 class="section-title" itemprop="headline">PARTECIPAZIONI</h2>			
					</header><!-- .section-header -->

					<div class="section-summary" itemprop="text">
						<?php 
						$partecipazioni = get_pages($args_partecipazioni);
						if (!empty($partecipazioni)) {
							foreach ($partecipazioni as $r) { 
								if($r->post_content && $r->post_content == '[gallery]') {
									echo '</ul><ul class="mdc-fotolist"><li class="mdc-fotolist-title"><h3 class="mdc-fotolist-year">'.$r->post_title.'</h3></li><ul>';
								} else {
									$fotolist_thumb = get_the_post_thumbnail($r->ID,'medium');
									echo '<li class="mdc-fotolist-item"><a href="'. get_permalink($r->ID).'">'.$fotolist_thumb.'<span>'.$r->post_title.'</span></a></li>';
								}

							 }
							 echo '</ul>';
						}
						?>
					</div>
				</div>
			</section>



			<?php
			/* origgy
			if ( have_posts() ) :

				do_action( 'generate_archive_title' );

				while ( have_posts() ) : the_post();

					get_template_part( 'content', get_post_format() );

				endwhile;

				do_action( 'generate_after_loop' );

				generate_content_nav( 'nav-below' );

			else :

				get_template_part( 'no-results', 'archive' );

			endif;
			*/

			do_action( 'generate_after_main_content' );
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();

get_footer();
