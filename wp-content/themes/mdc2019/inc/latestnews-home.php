				<div class="inside-article">
		
					<header class="section-header">
						<h2 class="section-title" itemprop="headline"><a href="<?php echo get_site_url(null, '/news/'); ?>" rel="bookmark">ULTIME NEWS</a></h2>			
					</header><!-- .section-header -->
		
					<div class="section-summary" itemprop="text">
						<?php
						// WP_Query arguments
						$args = array(
							'post_type'              => array( 'post'),
							'post_status'            => array( 'publish' ),
							'posts_per_page'         => '5',
							'order'                  => 'DESC',
						);

						// The Query
						$news_query = new WP_Query( $args );

						// The Loop
						if ( $news_query->have_posts() ) {
							while ( $news_query->have_posts() ) {
								$news_query->the_post();
						?>
						<div class="item-latest-news">
							<figure>
								<?php if ( has_post_thumbnail() ) : ?>
								    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								        <?php the_post_thumbnail('thumbnail'); ?>
								    </a>
								<?php endif; ?>
							</figure>
							<div class="text-latest-news">
								<h3 class="entry-title" itemprop="headline"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
								<?php the_excerpt(); ?>
							</div>
						</div>
						<?php
							}
						} else {
							// no posts found
						}

						// Restore original Post Data
						wp_reset_postdata();
						?>
					</div><!-- .section-summary -->

					<footer class="section-meta"></footer><!-- .section-meta -->
				</div><!-- .inside-article -->