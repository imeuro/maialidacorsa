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
			<?php
			do_action( 'generate_before_main_content' );

			$args_raduniufficiali = array(
				'echo'				=> false,
				'post_type'			=> 'albums',
				'category_name'		=> 'raduni-ufficiali',
				'post_status'		=> 'publish',
				'sort_column'		=> 'post_title',
				'title_li'			=> '',
				'sort_order'		=> 'desc'
			);
			$args_partecipazioni = array(
				'echo'				=> false,
				'post_type'			=> 'albums',
				'category_name'		=> 'partecipazioni',
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
						$raduniufficiali = new WP_Query($args_raduniufficiali);
						if (!empty($raduniufficiali)) {
							echo '<ul class="mdc-fotolist">';
							$i=0;
							foreach ($raduniufficiali as $r) { 
								//var_dump($r->ID);
								// if (has_children('albums',$r->ID)) {
									if($r->post_content && $r->post_content == '[gallery]') {
										
										if($i!==0) {
											echo '</ul></li></ul>';
										}								
										echo '<li class="mdc-fotolist-title-year"><h3 class="mdc-fotolist-year">'.$r->post_title.'</h3><ul class="mdc-fotolist-thumbs"><li><ul>';
									} else {
										$fotolist_thumb_url = get_the_post_thumbnail_url($r->ID,'medium_large');
										echo '<li class="mdc-fotolist-item"><a style="background-image:url('.$fotolist_thumb_url.');" href="'. get_permalink($r->ID).'"><span>'.$r->post_title.'</span></a></li>';
									}
									$i++;
								// }
							 }
							 echo '</li></ul>';
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
						$partecipazioni = new WP_Query($args_partecipazioni);
						if (!empty($partecipazioni)) {
							echo '<ul class="mdc-fotolist">';
							$p=0;
							print_r($partecipazioni);
							die();
							foreach ($partecipazioni as $r) { 

								if($r->post_content && $r->post_content == '[gallery]') {
									if($p!==0) {
										echo '</ul></li></ul>';
									}									
									echo '<li class="mdc-fotolist-title-year"><h3 class="mdc-fotolist-year">'.$r->post_title.'</h3><ul class="mdc-fotolist-thumbs"><li><ul>';
								} else {
									$fotolist_thumb_url = get_the_post_thumbnail_url($r->ID,'medium_large');
									echo '<li class="mdc-fotolist-item"><a style="background-image:url('.$fotolist_thumb_url.');" href="'. get_permalink($r->ID).'"><span>'.$r->post_title.'</span></a></li>';
								}
								$p++;
							 }
							 echo '</li></ul>';
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
