<?php
/**
 * Mission
 */

$about_mission_title = get_sub_field( 'about_mission' );
$about_mission_sub   = get_sub_field( 'about_mission_sub_title' );
$about_mission_text  = get_sub_field( 'about_mission_description' );

if ( ! empty( $about_mission_title ) || ! empty( $about_mission_sub ) || ! empty( $about_mission_text ) ) {
	?>
	<section class="module module-process">
		<div class="module-content">
			<div class="process-container-misson">
				<div class="texts-container">
					<div class="text-container">
						<div class="dot"></div>
						<div class="line"></div>
						<?php
						if ( ! empty( $about_mission_title ) ) {
							?>
							<h3 class="title font-h3 about-title"><?php echo esc_html( $about_mission_title ); ?></h3>
							<?php
						}
						if ( ! empty( $about_mission_sub ) ) {
							?>
							<p class="text font-p about-sub-title"><?php echo esc_html( $about_mission_sub ); ?></p>
							<?php
						}
						if ( ! empty( $about_mission_text ) ) {
							?>
							<p class="text font-p about-desc"><?php echo esc_html( $about_mission_text ); ?></p>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
}
