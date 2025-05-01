<?php
/**
 * Template name: Home
 */
wp_enqueue_style( 'think-appart-home-style', get_template_directory_uri().'/css/template-home.css', array(), THINK_APPART_THEME_VERSION );

// Header.
get_header();

while ( have_rows( 'cover' ) ) {
	the_row();
	$video = get_sub_field( 'video' );
	$image = get_sub_field( 'image' );
	?>
	<section class="module module-cover-home">
		<div class="video-container full-screen-video">
			<video src="<?=$video['url']?>" class="video"></video>
			<div class="mask-container background-image">
				<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
			</div>
			<div class="icons-container">
				<?=jg_icon_play()?>
				<?=jg_icon_pause()?>
				<?=jg_icon_volume()?>
			</div>
		</div>
	</section>
	<?php
}

while ( have_rows( 'content' ) ) {
	the_row();
	$layout = get_row_layout();

	if ( $layout == 'aproach' ) {
		?>
		<section class="module module-approach background-green">
			<p class="module-title font-p font-bold"><?=get_sub_field('title')?></p>
			<div class="text-container">
				<h1 class="font-h1 font-color-white"><?=get_sub_field('text')?></h1>
				<div class="button-container">
					<a href="<?=get_permalink(get_sub_field('button_page'))?>" class="button button-black-border-white"><?=get_sub_field('button_text')?></a>
				</div>
			</div>
		</section>
		<?php
	} elseif ( $layout == 'services' ) {
		?>
		<section class="module module-services">
			<h2 class="module-title font-p font-bold"><?=get_sub_field('title')?></h2>
			<div class="services-container">
				<?php
				$services = get_posts([
					'numberposts'      => -1,
					'post_type'        => 'services',
					'fields'           => 'ids',
					'orderby'          => 'menu_order',
					'order'            => 'ASC',
					'post_parent'      => 0, // exclude child posts.
					'suppress_filters' => false,
				]);

				foreach ( $services as $service ) {
					while( have_rows( 'general', $service ) ) {
						the_row();

						$image      = get_sub_field( 'image' );
						$background = jg_get_info_background_color( 'main' );
						$text_hover = change_color_to_hex( 'green' );

						if ( $background['color'] == 'green' || $background['color'] == 'blue' ) {
							$text_hover = change_color_to_hex( 'black' );
						} elseif ( $background['color'] == 'yellow' ) {
							$text_hover = change_color_to_hex( 'blue' );
						}

						$background = jg_change_background_color_to_hex($background);
						?>
						<a href="<?=get_permalink($service)?>" class="service-container" data-color-bg="<?=$background['color']?>" data-color-font="<?=$background['font_color']?>" data-color-hover="<?=$text_hover?>">
							<p class="name font-h2"><?=get_the_title($service)?></p>
							<?=jg_icon_plus()?>
							<div class="image-wrapper">
								<div class="image-container">
									<div class="background-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image"></div>
								</div>
							</div>
						</a>
						<?php
					}
				}
				?>
			</div>
			<div class="button-container">
				<a href="<?=get_permalink(get_sub_field('button_page'))?>" class="button button-green-hover-white"><?=get_sub_field('button_text')?></a>
			</div>
		</section>
		<?php
	}elseif($layout == 'latest_works'){
		$projects = get_sub_field('projects');
		$n_projects = count($projects);
		$col4_count = 0;
		$row_open = false;
		?>
		<section class="module module-grid-latest-works">
			<div class="title">
				<h2 class="module-title font-h1 font-regular"><?=get_sub_field('title')?></h2>
			</div>
			<?php
			if ( ! empty( $projects ) ) {
				foreach ( $projects as $index => $project ) {
					// Open first row
					if ( $index === 0 ) {
						echo '<div class="first-row">';
						echo '<div class="project-item-one project-home-grid">';
							jg_print_project_home( $project );
						echo '</div>';
					} elseif ($index === 1) {
						echo '<div class="project-item-two project-home-grid">';
							jg_print_project_home($project);
						echo '</div>';
						echo '</div>'; // close first row
					} else {
						// All other items in rows of 3 col-4
						if ( $col4_count % 3 === 0 ) {
							if ($row_open) {
								echo '</div>'; // Close previous row
							}
							echo '<div class="second-row">';
							$row_open = true;
						}
						echo '<div class="second-row-items project-home-grid">';
							jg_print_project_home($project);
						echo '</div>';
						$col4_count++;
					}
				}
			}

			if ($row_open) {
				echo '</div>'; // Close last open row
			}
			?>
			<div class="buttons-container">
				<a href="<?=get_permalink(get_sub_field('button_page'))?>" class="button button-black"><?=get_sub_field('button_text')?></a>
			</div>
		</section>
		<?php
	}elseif($layout == 'offices'){
		$offices = get_field('offices', 'option');
		$n_offices = count($offices);
		$button = '';
		$button_type = get_sub_field('type_button');
		if($button_type == 'link'){
			$button = '<a href="'.get_permalink(get_sub_field('page')).'" class="button button-black-border-white">'.get_sub_field('button_text').'</a>';
		}elseif($button_type == 'email'){
			$button = '<a href="mailto:'.get_sub_field('email').'" class="button button-black-border-white">'.get_sub_field('email').'</a>';
			$button.= '<p data-copy-text="'.get_sub_field('email').'" class="button button-black-border-white button-copy">'.jg_icon_copy().'</p>';
		}
					
		?>
		<section class="module module-display background-yellow">
			<div class="display-container slow">
				<div class="display-text-container">
					<div class="display-text-wrapper">
						<p class="display-text font-p">
							<?php
							for ($i=0; $i < $n_offices; $i++) {
								if($i > 0){
									if($i < $n_offices-1){
										echo ', ';
									}else{
										echo ' ' . __('&', 'think-appart') . ' ';
									}
								}
								echo $offices[$i]['city'];
							}
							?>
						</p>
					</div>
				</div>
			</div>
		</section>

		<section class="module module-offices background-blue">
			<div class="text-container">
				<p class="module-title font-p font-color-white font-bold"><?=__('Our offices', 'think-appart')?></p>
				<h2 class="steps-container font-h1">
					<?=__('You can find us in', 'think-appart')?> 
					<?php
					$active = 'active';
					for ($i=0; $i < $n_offices; $i++) {
						if($i > 0){
							if($i < $n_offices-1){
								echo ', ';
							}else{
								echo ' ' . __('&', 'think-appart') . ' ';
							}
						}
						echo '<strong class="step font-medium '.$active.'" data-id="'.$i.'">'.$offices[$i]['city'].'</strong>';
						$active = '';
					}
					?>
				</h2>
				<div class="buttons-container only-desktop"><?=$button?></div>
			</div>
			<div class="slider-container">
				<div class="slider-wrapper swiper-wrapper">
					<?php
					while(have_rows('offices', 'option')){
						the_row();
						$info_c = jg_get_info_background_color();
						?>
						<div class="slide swiper-slide background-<?=$info_c['color']?> font-color-<?=$info_c['font_color']?>" <?=$info_c['other_color']?>>
							<p class="country font-h2"><?=get_sub_field('city')?>, <?=get_sub_field('country')?></p>
							<div class="bottom-content">
								<p class="time font-h2" data-timezone="<?=get_sub_field('timezone')?>"></p>
								<a href="<?=get_sub_field('address_link')?>" class="address-link font-p2" target="_blank" rel="noopener noreferrer"><?=get_sub_field('address')?></a>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<div class="buttons-container only-mobile"><?=$button?></div>
		</section>
		<?php
	}elseif($layout == 'jobs'){
		?>
		<section class="module module-jobs">
			<div class="shapes-container js-animate" data-animation-type="shapes">
				<img src="<?=get_template_directory_uri()?>/assets/svg/shape-1.svg" alt="" class="shape shape-1">
				<img src="<?=get_template_directory_uri()?>/assets/svg/shape-2.svg" alt="" class="shape shape-2">
				<img src="<?=get_template_directory_uri()?>/assets/svg/shape-3.svg" alt="" class="shape shape-3">
				<img src="<?=get_template_directory_uri()?>/assets/svg/shape-4.svg" alt="" class="shape shape-4">
				<img src="<?=get_template_directory_uri()?>/assets/svg/shape-5.svg" alt="" class="shape shape-5">
			</div>
			<h2 class="module-title font-p font-bold"><?=get_sub_field('title')?></h2>
			<div class="text-container">
				<p class="font-h1"><?=get_sub_field('text')?></p>
				<a href="<?=get_permalink(get_sub_field('button_page'))?>" class="button button-black"><?=get_sub_field('button_text')?></a>
			</div>
		</section>
		<?php
	}elseif($layout == 'client_logos'){
		if(get_sub_field('use_general_logos')){
			while(have_rows('general_client_logos','option')){
				the_row();
				$logos = get_sub_field('logos');
			}
		}else{
			$logos = get_sub_field('logos');
		}

		?>
		<section class="module module-logos background-black">
			<div class="display-container">
				<div class="display-text-container">
					<div class="display-text-wrapper">
						<?php
						foreach ($logos as $logo) {
							?>
							<img src="<?=$logo['url']?>" alt="<?=$logo['alt']?>" class="display-image">
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</section>
		<?php
	} elseif($layout == 'blog_carousel'){
		$template_name = 'blog-carousel';
		get_template_part( 'template-parts/acf-flexible/' . $template_name );
	} elseif($layout == 'about_us'){
		$images = get_sub_field('images');
		?>
		<section class="module module-about-home background-yellow">
			<div class="title-container">
				<p class="module-title font-h1"><?=get_sub_field('title')?></p>
				<a href="<?=get_permalink(get_sub_field('button_page'))?>" class="button button-black-border-white"><?=get_sub_field('button_text')?></a>
			</div>
			<div class="images-container swiper-wrapper">
				<?php
				foreach ($images as $image) {
					?>
					<div class="image-container swiper-slide">
						<div class="background-image">
							<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
						</div>
					</div>
					<?php
				}
				?>
			</div>
			<?php
			while ( have_rows( 'more_info' ) ) {
				the_row();
				?>
				<div class="more-info-container">
					<div class="more-info-title">
						<p class="text font-p3" data-text-closed="<?=__('Read more', 'think-appart')?>" data-text-opened="<?=__('Show less', 'think-appart')?>"><?=__('Read more', 'think-appart')?></p>
						<svg class="arrow" width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1 1.30762L11.5 9.30762L22 1.30762" stroke="black"/>
						</svg>
					</div>
					<div class="more-info-content">
						<div class="more-info-content-wrapper">
							<div class="column">
								<h2 class="title font-h3 font-medium"><?=get_sub_field( 'title_1' )?></h2>
								<p class="text font-p2"><?=get_sub_field( 'text_1' )?></p>
							</div>
							<div class="column">
								<h2 class="title font-h3 font-medium"><?=get_sub_field( 'title_2' )?></h2>
								<p class="text font-p2"><?=get_sub_field( 'text_2' )?></p>
								<div class="button-container">
									<a href="<?=get_permalink( get_sub_field( 'button_page' ) )?>" class="button button-hover-white"><?=get_sub_field( 'button_text' )?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</section>
		<?php
	}
}


// Footer.
get_footer();


function jg_print_project_home( $project, $parallax_factor = 0 ) {
	while ( have_rows( 'general', $project ) ) {
		the_row();
		$project_bg = jg_get_info_background_color( 'hover' );
		?>
		<a href="<?=get_permalink($project)?>" class="home-project-grid-wrap">
			<div class="background-image-wrap">
				<?php
				$type = get_sub_field( 'home_media_type' );
				if ( empty( $type ) ) {
					$type = get_sub_field( 'thumbnail_media_type' );
				}
				if ( $type == 'image' ) {
					$image = get_sub_field( 'home_image' );
					if ( empty( $image ) ) {
						$image = get_sub_field( 'thumbnail_image' );
					}
					?>
						<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
					<?php
				} elseif ( $type == 'video' ){
					$video = get_sub_field( 'home_video' );
					if ( empty( $video ) ) {
						$video = get_sub_field( 'thumbnail_video' );
					}
					?>
						<video src="<?=$video['url']?>" class="image" autoplay muted loop playsinline></video>
					<?php
				}
				?>
			</div>
			<p class="font-p"><?=get_sub_field('title')?></p>
			<?php
				$services = get_sub_field( 'services' );
				if ( ! empty( $services ) ) {
					$cat_array = array();
					foreach ( $services as $service ) {
						$cat_id = apply_filters( 'wpml_object_id', $service, 'services', true );
						$cat_array[] = get_the_title( $cat_id );
					}
				}
				if ( ! empty( $cat_array ) ) {
					?>
					<div class="project-grid-category-list">
						<?php echo implode( ' | ', $cat_array ); //phpcs:ignore ?>
					</div>
					<?php
				}
			?>
		</a>
		<?php
	}
}