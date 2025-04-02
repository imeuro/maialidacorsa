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
		<main id="main" <?php generate_do_element_classes( 'main', 'tpl-archive tpl-archive-albums' ); ?>>
			
			<section id="latestNews" class="section section-home section-home-latestnews">
				<div class="inside-article">
					<header class="section-header">
						<h2 class="section-title" itemprop="headline">RADUNI UFFICIALI</h2>			
					</header><!-- .section-header -->

					<div class="section-summary" itemprop="text">
						<?php MDCAlbums_categories_and_posts( 'raduni-ufficiali' ); ?>
					</div>
				</div>

				<div class="inside-article">
					<header class="section-header">
						<h2 class="section-title" itemprop="headline">PARTECIPAZIONI</h2>			
					</header><!-- .section-header -->


					<div class="section-summary" itemprop="text">
						<?php MDCAlbums_categories_and_posts( 'partecipazioni' ); ?>
					</div>
				</div>
			</section>


			<?php
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
