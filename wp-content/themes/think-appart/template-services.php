<?php
/**
 * Template name: Services
 */
wp_enqueue_style('think-appart-services-style', get_template_directory_uri().'/css/template-services.css', array(), THINK_APPART_THEME_VERSION);

// Header
get_header();

while (have_rows('cover')) {
	the_row();
	?>
	<section class="module module-cover-services">
		<div class="shapes-container js-animate" data-animation-type="shapes">
			<img src="<?=get_template_directory_uri()?>/assets/svg/shape-1.svg" alt="" class="shape shape-1">
			<img src="<?=get_template_directory_uri()?>/assets/svg/shape-2.svg" alt="" class="shape shape-2">
			<img src="<?=get_template_directory_uri()?>/assets/svg/shape-3.svg" alt="" class="shape shape-3">
			<img src="<?=get_template_directory_uri()?>/assets/svg/shape-4.svg" alt="" class="shape shape-4">
			<img src="<?=get_template_directory_uri()?>/assets/svg/shape-5.svg" alt="" class="shape shape-5">
		</div>
		<h1 class="module-title font-p font-bold"><?=get_sub_field('title')?></h1>
		<p class="text font-h1"><?=get_sub_field('text')?></p>
		<svg class="arrow-down" viewBox="0 0 74 29" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M1.5 1.99999L37 27L72.5 2" stroke="#00D3A8" stroke-width="3"/>
		</svg>
	</section>
	<?php
}

while(have_rows('content')){
	the_row();
	$layout = get_row_layout();
	if($layout == 'slider_image_text'){
		$module_slider_class = 'no-stuck';
		if(get_sub_field('stuck_section')){
			$module_slider_class = '';
		}
		?>
		<section class="module module-slider-scroll <?=$module_slider_class?>">
			<div class="screens-wrapper">
				<div class="screens-container">
					<?php
					$n_slides = 0;
					while(have_rows('slides')){
						the_row();
						$n_slides++;
						?>
						<div class="screen">
							<div class="text-container">
								<h2 class="title font-h1"><?=get_sub_field('title')?></h2>
								<p class="text font-p2"><?=get_sub_field('text')?></p>
							</div>
							<?php
							$image = get_sub_field('image');
							if(get_sub_field('media_type') == 'image'){
								?>
								<div class="image-container">
									<div class="background-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image"></div>
								</div>
								<?php
							}else{
								$video = get_sub_field('video');
								$autoplay = '';
								if(get_sub_field('video_autoplay')){
									$autoplay = 'autoplay loop muted';
								}
								?>
								<div class="video-container">
									<video src="<?=$video['url']?>" class="video" <?=$autoplay?> playsinline></video>
									<?php
									if(empty($autoplay)){
										?>
										<div class="mask-container background-image">
											<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
										</div>
										<div class="icons-container">
											<?=jg_icon_play()?>
											<?=jg_icon_pause()?>
											<?=jg_icon_volume()?>
										</div>
										<?php
									}
									?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					}
					?>
				</div>
				<div class="steps-container">
					<?php
					$active = 'active';
					for ($i=0; $i < $n_slides; $i++) {
						?>
						<div class="step <?=$active?>"></div>
						<?php
						$active = '';
					}
					?>
				</div>
			</div>
		</section>
		<?php
	}elseif($layout == 'services_list'){
		?>
		<section class="module module-services">
			<h2 class="module-title font-h1"><?=get_sub_field('title')?></h2>
			<div class="services-container">
				<?php
				$services = get_posts([
					'numberposts' => -1,
					'post_type' => 'services',
					'fields' => 'ids',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'post_parent' => 0, // exclude child posts
					'suppress_filters' => false,
				]);
				foreach ($services as $service) {
					while(have_rows('general', $service)){
						the_row();
						$image = get_sub_field('image');
						$background = jg_get_info_background_color('main');
						$text_hover = change_color_to_hex('green');
						if($background['color'] == 'green' || $background['color'] == 'blue'){
							$text_hover = change_color_to_hex('black');
						}elseif($background['color'] == 'yellow'){
							$text_hover = change_color_to_hex('blue');
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
		</section>
		<?php
	}elseif($layout == 'awards'){
		?>
		<section class="module module-awards">
			<p class="module-title font-h1"><?=get_sub_field('title')?></p>
			<div class="logos-container">
				<?php
				$logos = get_sub_field('logos');
				foreach ($logos as $logo) {
					?>
					<img src="<?=$logo['url']?>" alt="<?=$logo['alt']?>" class="logo">
					<?php
				}
				?>
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
	}elseif($layout == 'process'){
		$image = get_sub_field('image');
		?>
		<section class="module module-process">
			<div class="module-content background-yellow">
				<h2 class="module-title font-h1"><?=get_sub_field('title')?></h2>
				<div class="process-container">
					<div class="texts-container">
						<?php
						$active = 'active';
						while(have_rows('process')){
							the_row();
							?>
							<div class="text-container <?=$active?>">
								<div class="dot"></div>
								<div class="line"></div>
								<h3 class="title font-h3"><?=get_sub_field('title')?></h3>
								<?php 
								$text = get_sub_field('text');
								if ( ! empty( $text ) ) { ?>
									<p class="text font-p"><?=get_sub_field('text')?></p>
								<?php } ?>
							</div>
							<?php
							$active = '';
						}
						?>
					</div>
					<div class="image-container only-desktop">
						<div class="shapes-container js-animate" data-animation-type="shapes">
							<img src="<?=get_template_directory_uri()?>/assets/svg/shape-1-white.svg" alt="" class="shape shape-1">
							<img src="<?=get_template_directory_uri()?>/assets/svg/shape-2-black.svg" alt="" class="shape shape-2">
							<img src="<?=get_template_directory_uri()?>/assets/svg/shape-3-white.svg" alt="" class="shape shape-3">
							<img src="<?=get_template_directory_uri()?>/assets/svg/shape-6-black.svg" alt="" class="shape shape-4">
							<img src="<?=get_template_directory_uri()?>/assets/svg/shape-7-black.svg" alt="" class="shape shape-5">
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}elseif($layout == 'form'){
		jg_print_contact_form();
	}
}

// Footer
get_footer();
