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


			$about = get_post(4876); // chi siamo
			?>
			
			<section id="about" class="section section-home section-home-about">
				<div class="inside-article">
		
					<header class="section-header">
						<h2 class="section-title" itemprop="headline"><?php echo $about->post_title; ?></h2>
					</header><!-- .section-header -->
		
					<div class="section-summary" itemprop="text">
						<a href="<?php echo get_permalink($about->id); ?>" title="<?php echo $about->post_title; ?>">
							<img width="300" height="228" src="https://www.maialidacorsa.it/wp-content/uploads/2020/02/100-minista-1-300x228.png" class="attachment-medium size-medium" alt="100% MINISTA - Maiali Da Corsa" loading="lazy" srcset="https://www.maialidacorsa.it/wp-content/uploads/2020/02/100-minista-1-300x228.png 300w, https://www.maialidacorsa.it/wp-content/uploads/2020/02/100-minista-1.png 595w" sizes="(max-width: 300px) 100vw, 300px">
						</a>
						<p><?php echo get_the_excerpt($about->id); ?></p>
						
					</div><!-- .section-summary -->

					<footer class="section-meta"></footer><!-- .section-meta -->
				</div><!-- .inside-article -->
			</section>


			<section id="latestNews" class="section section-home section-home-latestnews">
				<?php include("inc/latestnews-home.php"); ?>
			</section>

			<section id="latestPhotos" class="section section-home section-home-latestphotos">
				<?php include("inc/latestphotos-home.php"); ?>
			</section>

			<?php /*
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
			*/ ?>



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
