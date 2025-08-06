<?php

$home_video_autoplay = get_sub_field( 'home_video_autoplay' );

if ( ! empty( $home_video_autoplay ) ) {
	?>
	<section class="module module-cover-home">
		<div class="video-container-block full-screen-video icon-play-default play-without-sound">
			<video autoplay muted loop playsinline src="<?php echo esc_url( $home_video_autoplay['url'] ); ?>" class="video"></video>
			<div class="icons-container">
				<?=jg_icon_play()?>
				<?=jg_icon_pause()?>
				<?=jg_icon_volume()?>
			</div>
		</div>
	</section>
	<?php
}
