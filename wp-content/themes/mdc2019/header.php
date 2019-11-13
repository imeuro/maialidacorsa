<?php
/**
 * The template for displaying the header.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php generate_do_microdata( 'body' ); ?>>
	<?php
	/**
	 * wp_body_open hook.
	 *
	 * @since 2.3
	 */
	do_action( 'wp_body_open' );

	/**
	 * generate_before_header hook.
	 *
	 * @since 0.1
	 *
	 * @hooked generate_do_skip_to_content_link - 2
	 * @hooked generate_top_bar - 5
	 * @hooked generate_add_navigation_before_header - 5
	 */
	do_action( 'generate_before_header' );

	/**
	 * generate_header hook.
	 *
	 * @since 1.3.42
	 *
	 * @hooked generate_construct_header - 10
	 */
	do_action( 'generate_header' );

	/**
	 * generate_after_header hook.
	 *
	 * @since 0.1
	 *
	 * @hooked generate_featured_page_header - 10
	 */
	do_action( 'generate_after_header' );
	?>

	<?php 
	//** get the carousel for the homepage **//
	if (is_home() || is_front_page()) {

		$HomeCarousel = get_post(4638);
		$Carouselcontent = $HomeCarousel->post_content;
		$Carouselcontent = apply_filters('the_content', $Carouselcontent);
		$Carouselcontent = str_replace(']]>', ']]>', $Carouselcontent);
		?>
		<script>
		let Checkran_autoH;
		let Set_autoH = function() {
			if (typeof Swiper === "function") {
				Swiper.autoHeight = true;
				Checkran_autoH = 'ok';
				clearInterval(run_autoH);
			}
			console.log('Set_autoH: '+Checkran_autoH);
		}
		let run_autoH = setInterval(Set_autoH, 500);
		let Check_autoH = function() {
			if( Checkran_autoH == 'ok') {
				clearInterval(run_autoH);
			}
			console.log('Check_autoH: '+Checkran_autoH);
		}
		
		</script>
		<section id="cover" class="section section-home section-home-cover">
			<?php echo $Carouselcontent; ?>
		</section>
		<?php
	}
	?>

	<div id="page" class="hfeed site grid-container container grid-parent">
		<div id="content" class="site-content">
			<?php
			/**
			 * generate_inside_container hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_inside_container' );
