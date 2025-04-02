<?php
/**
 * Blog Carousel
 */

$carousel_title  = get_sub_field( 'blog_carousel_title' );
$carousel_blogs  = get_sub_field( 'blog_carousel_blogs_slider' );
$carousel_button = get_sub_field( 'blog_carousel_button' );

if ( ! empty( $carousel_blogs ) ) {
	?>
	<section class="module module-blog-carousel-block">
		<?php
		if ( ! empty( $carousel_title ) ) {
			?>
			<h2 class="module-title font-h1">
				<span class="font-h1 font-color-green">Appart_</span>
				<?php echo esc_html( $carousel_title ); ?>
			</h2>
			<?php
		}
		?>
		<div class="blog-carousel-wrapper">
			<?php
			$index_number = wp_rand( 10, 200 );

			$json_array = array(
				'slidesPerView'  => 2,
				'spaceBetween'   => 24,
				'direction'      => 'horizontal',
				'navigation'     => array(
					'nextEl' => '.swiper-button-next-blog-' . $index_number,
					'prevEl' => '.swiper-button-previous-blog-' . $index_number,
				),
				'breakpoints'    => array(
					'768' => array(
						'slidesPerView' => 3,
						'spaceBetween'  => 0,
					),
				),
				'allowTouchMove' => true,
				'loop'           => false,
			);
			?>
			<div class="swiper" data-slider-options=<?php echo wp_json_encode( $json_array ); ?>>
				<div class="swiper-wrapper">
					<?php
					foreach ( $carousel_blogs as $post ) { //phpcs:ignore
						setup_postdata( $post );
						?>
						<div class="swiper-slide">
							<a href="<?php echo esc_url( get_the_permalink() ); ?>">
								<div class="blog-thumbnail-img">
									<?php
									while ( have_rows( 'general' ) ) {
										the_row();

										$image = get_sub_field( 'image' );
										if ( ! empty( $image ) ) {
											?>
											<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_html( $image['alt'] ); ?>" class="image" />
											<?php
										}
									}
									?>
								</div>
							</a>
							<span><?php echo get_the_date( 'j F Y' ); ?></span>
							<a class="blog-slider-link" href="<?php echo esc_url( get_the_permalink() ); ?>">
								<h1><?php echo esc_html( get_the_title() ); ?></h1>
							</a>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<div class="swiper-button-wrap">
				<div class="swiper-button-next swiper-button-next-blog-<?php echo esc_attr( $index_number ); ?>"></div>
				<div class="swiper-button-prev swiper-button-previous-blog-<?php echo esc_attr( $index_number ); ?>"></div>
			</div>
		</div>
		<?php
		if ( $carousel_button && ! empty( $carousel_button['url'] ) && ! empty( $carousel_button['title'] ) ) {
			$link_url    = $carousel_button['url'];
			$link_title  = $carousel_button['title'];
			$link_target = $carousel_button['target'] ? $carousel_button['target'] : '_self';
			?>
			<div class="blog-carousel-button">
				<a href="<?php echo esc_url( $link_url ); ?>" class="button button-small button-white" target="<?php echo esc_attr( $link_target ); ?>">
					<?php echo esc_html( $link_title ); ?>
					<span></span>
				</a>
			</div>
			<?php
		}
		?>
	</section>
	<?php
	wp_reset_postdata();
}

