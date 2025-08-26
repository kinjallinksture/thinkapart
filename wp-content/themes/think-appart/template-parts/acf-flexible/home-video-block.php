<?php

$home_video_autoplay = get_sub_field( 'home_video_autoplay' );

if ( ! empty( $home_video_autoplay ) ) {
	?>
	<section class="module module-cover-home">
		<div class="video-container-block full-screen-video icon-play-default play-without-sound">
			<video autoplay playsinline muted loop src="<?php echo esc_url( $home_video_autoplay['url'] ); ?>" class="video-remove"></video>
			<video muted loop src="<?php echo esc_url( $home_video_autoplay['url'] ); ?>" class="video hide-video"></video>
			<div class="icons-container">
				<?=jg_icon_play()?>				
			</div>
		</div>
	</section>
	<?php
}
