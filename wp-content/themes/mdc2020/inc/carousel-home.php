<?php

$HomeCarousel = get_post(4740);
if (has_block('gallery', $HomeCarousel->post_content)) {
	$post_blocks = parse_blocks($HomeCarousel->post_content);
	$images = $post_blocks[0]['attrs']['ids'];
}
//var_dump($images);
if ( empty($images) ) {
	// no attachments here
} else {
	$Carouselcontent = '<div class="swiper-container swiper-big-home">';
	    $Carouselcontent .= '<div class="swiper-wrapper">';
	foreach ( $images as $attachment_id ) {
		$Carouselcontent .= '<div data-background="'.wp_get_attachment_image_src( $attachment_id, 'large' )[0].'" class="swiper-slide swiper-lazy">';
		$Carouselcontent .= '<div class="swiper-lazy-preloader"></div>';
		$Carouselcontent .= '</div>';
	}
	$Carouselcontent .= '</div>';
	$Carouselcontent .= '</div>';
}
?>
<section id="cover" class="section section-home section-home-cover">
	<?php echo $Carouselcontent; ?>
</section>