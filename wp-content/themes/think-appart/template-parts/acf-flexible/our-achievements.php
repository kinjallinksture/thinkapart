<?php
/**
 * Our Achievements
 */

if ( have_rows( 'our_achievements_box' ) ) {
	?>
	<section class="module module-our-achievements-box">
		<div class="our-achievements-box-wrapper">
			<?php
			while ( have_rows( 'our_achievements_box' ) ) {
				the_row();

				$achievements_number      = get_sub_field( 'achievements_number' );
				$achievements_title       = get_sub_field( 'achievements_title' );
				$achievements_description = get_sub_field( 'achievements_description' );
				?>
				<div class="our-achievements-box">
					<?php
					if ( ! empty( $achievements_number ) ) {
						?>
						<span><?php echo $achievements_number; //phpcs:ignore ?></span>
						<?php
					}
					if ( ! empty( $achievements_title ) ) {
						?>
						<h2 class="title"><?php echo esc_html( $achievements_title ); ?></h2>
						<?php
					}
					if ( ! empty( $achievements_description ) ) {
						?>
						<p><?php echo esc_html( $achievements_description ); ?></p>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
	</section>
	<?php
	wp_reset_postdata();
}

