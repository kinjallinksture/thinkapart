<?php
/**
 * Industries
 */

$our_work_industries_title = get_sub_field( 'our_work_industries_title' );
if ( have_rows( 'our_work_industries' ) ) {
	?>
	<section class="module module-our-work-industries">
		<div class="our-work-industries-wrapper">
			<div class="title-with-icon">
				<?php
				if ( ! empty( $our_work_industries_title ) ) {
					?>
					<h2><?php echo esc_html( $our_work_industries_title ); ?></h2>
					<?php
				}
				?>
			</div>
			<div class="our-industries-box buttons-container">
				<?php
				while ( have_rows( 'our_work_industries' ) ) {
					the_row();

					$industries_name = get_sub_field( 'industries_name' );
					if ( ! empty( $industries_name ) ) {
						?>
						<span class="button button-white-green"><?php echo $industries_name; //phpcs:ignore ?></span>
						<?php
					}
				}
				?>
			</div>
		</div>
	</section>
	<?php
	wp_reset_postdata();
}

