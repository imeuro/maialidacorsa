<?php
/*
Template Name: Home Page
Template Post Type: page
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}	
get_header(); ?>

	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main', 'tpl-mdc-homepage' ); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );

			?>
			


			<section id="latestNews" class="section section-home section-home-latestnews">
				<?php include("inc/latestnews-home.php"); ?>
			</section>

			<section id="latestPhotos" class="section section-home section-home-latestphotos">
				<?php include("inc/latestphotos-home.php"); ?>
			</section>


			<section id="infoUtili" class="section section-home section-home-infoutili">
				<div class="inside-article">
		
					<header class="section-header">
						<h2 class="section-title" itemprop="headline">INFO UTILI</h2>
					</header><!-- .section-header -->
		
					<div class="section-summary" itemprop="text">
						

					</div><!-- .section-summary -->

					<footer class="section-meta"></footer><!-- .section-meta -->
				</div><!-- .inside-article -->
			</section>



			<?php

			/**
			 * generate_after_main_content hook.
			 *
			 * @since 0.1
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
