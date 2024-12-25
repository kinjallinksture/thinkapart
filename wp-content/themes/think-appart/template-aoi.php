<?php
/**
 * Template name: AOI
 * Template Post Type: services, page
 */
wp_enqueue_style('think-appart-template-aoi-style', get_template_directory_uri().'/css/template-aoi.css', array(), THINK_APPART_THEME_VERSION);

// Header
get_header();

$id_services_main_page = get_field('cpt_services', 'option')['services_main_page'];
$parent_id = wp_get_post_parent_id(get_the_ID()); 
$parent_title = get_the_title($parent_id);
$parent_permalink = get_permalink($parent_id);

while(have_rows('cover')){
	the_row();
	$type_cover = get_sub_field('type_cover');
	?>
	<section class="module module-cover-single-landings type-<?=$type_cover?>">
		<?php
		$text_color = 'black';
		$button_style = 'full-';
		if($type_cover == 'text'){
			$button_style = '';
			?>
			<div class="circle-container">
				<svg class="circle js-parallax" data-parallax-circle="true" width="144" height="288" viewBox="0 0 144 288" fill="none" xmlns="http://www.w3.org/2000/svg">
					<circle cy="144" r="144" fill="#00D3A8"/>
				</svg>
			</div>
			<?php
		}elseif($type_cover == 'image'){
			$image = get_sub_field('image');
			$text_color = get_sub_field('text_color');
			?>
			<div class="media-container">
				<div class="background-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image"></div>
			</div>
			<?php
		}elseif($type_cover == 'video'){
			$video = get_sub_field('video');
			$text_color = get_sub_field('text_color');
			?>
			<div class="media-container">
				<div class="background-image">
					<video src="<?=$video['url']?>" class="image" playsinline autoplay loop muted></video>
				</div>
			</div>
			<?php
		}
		?>
		<div class="text-container font-color-<?=$text_color?>">
			<h1 class="title font-h1"><?=get_sub_field('title')?></h1>
			<p class="text font-h3"><?=get_sub_field('text')?></p>
			<?php
			while(have_rows('button')){
				the_row();
				if(get_sub_field('include')){
					$target = '';
					if(get_sub_field('open_in_new_window')){
						$target = 'target="_blank" rel="noopener noreferrer"';
					}
					?>
					<a href="<?=get_permalink(get_sub_field('link'))?>" class="button button-<?=$button_style?><?=$text_color?>" <?=$target?>><?=get_sub_field('text')?></a>
					<?php
				}
			}
			?>
		</div>
	</section>
	<?php
}

while (have_rows('content')) {
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
	}elseif($layout == 'slider_images'){
		$images = get_sub_field('images');
		?>
		<div class="module module-slider-images">
			<div class="slider-container">
				<div class="swiper-wrapper">
					<?php
					foreach ($images as $image) {
						?>
						<div class="swiper-slide image-container">
							<div class="background-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image"></div>
						</div>
						<?php
					}
					?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
		</div>
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
							$text_hover = change_color_to_hex('white');
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
	}elseif($layout == 'areas_of_intervention_-_list'){
		?>
		<section class="module module-cover-single-services">
			<div class="title-container">
				<p class="breadcrumb-container font-p font-bold"><a href="<?= $parent_permalink ?>" class="font-bold"><?= $parent_title ?></a> | <a class="font-bold" href="<?= get_permalink($id_services_main_page) ?>"><?= get_the_title($id_services_main_page) ?></a></p>
				<h2 class="font-h1"><?=get_sub_field('title')?></h2>
			</div>
			<!-- Tweaked by TBS - to add link to the AOI when link is filled in -->
			<div class="areas-container font-p">
				<p class="title font-bold"><?=get_sub_field('list_areas_title')?></p>
				<?php
				
				while (have_rows('list_areas')) {
					the_row();
					$area_link = get_sub_field('area_link');
					$area_name = get_sub_field('area');
					if (!empty($area_link)) {
						?>
						<p><a href="<?= $area_link ?>"><?php echo $area_name; ?></a></p>
						<?php
					} else {
						?>
						<p><?php echo $area_name; ?></p>
						<?php
					}
				}
				?>
			</div>
		</section>

		<?php
		$image = get_sub_field('image');

		$module_slider_class = 'no-stuck';
		if(get_sub_field('stuck_texts_section')){
			$module_slider_class = '';
		}

		$background = jg_get_info_background_color();
		if($background['color'] == 'white'){
			$background['color'] = 'black';
			$background['font_color'] = 'white';
		}
		?>

		<section class="module module-slider-scroll with-top-image <?=$module_slider_class?> background-<?=$background['color']?> font-color-<?=$background['font_color']?>" <?=$background['other_color']?>>
			<div class="image-container">
				<div class="background-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image"></div>
			</div>
			<div class="screens-wrapper">
				<div class="screens-container">
					<?php
					$count = 0;
					while(have_rows('texts')){
						the_row();
						$count++;
						?>
						<div class="screen">
							<div class="text-container">
								<h2 class="title font-h1"><?=get_sub_field('title')?></h2>
								<p class="text font-p2"><?=get_sub_field('text')?></p>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<div class="steps-container">
					<?php
					$active = 'active';
					if($count > 1){
						for ($i=0; $i < $count; $i++) { 
							?>
							<div class="step <?=$active?> background-<?=$background['font_color']?>"></div>
							<?php
							$active = '';
						}
					}
					?>
				</div>
			</div>
		</section>
		<?php
	}elseif($layout == 'areas_of_intervention_-_grid'){
		$section = jg_get_info_background_color('section');
		$image = get_sub_field('image');
		?>
		<section class="module module-areas-of-intervention-grid background-<?=$section['color']?> font-color-<?=$section['font_color']?>" <?=$section['other_color_style']?>>
			<div class="title-container">
				<div class="shapes-container js-animate" data-animation-type="shapes">
					<img src="<?=get_template_directory_uri()?>/assets/svg/shape-1-white.svg" alt="" class="shape shape-1">
					<img src="<?=get_template_directory_uri()?>/assets/svg/shape-2-black.svg" alt="" class="shape shape-2">
					<img src="<?=get_template_directory_uri()?>/assets/svg/shape-3-white.svg" alt="" class="shape shape-3">
					<img src="<?=get_template_directory_uri()?>/assets/svg/shape-4-white.svg" alt="" class="shape shape-4">
					<img src="<?=get_template_directory_uri()?>/assets/svg/shape-5-black.svg" alt="" class="shape shape-5">
				</div>
				<h2 class="module-title font-h1"><?=get_sub_field('title')?></h2>
			</div>
			<div class="grid-container">
				<?php
				while(have_rows('list_areas')){
					the_row();
					$image = get_sub_field('image');
					?>
					<div class="grid-item">
						<div class="image-container">
							<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
						</div>
						<h3 class="title font-h3p"><?=get_sub_field('title')?></h3>
						<p class="text font-p2"><?=get_sub_field('text')?></p>
					</div>
					<?php
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
	// TBS Added - FAQ Content Layout
	}elseif($layout == 'faq'){
	 
	if (have_rows('read_more_text')):
	while (have_rows('read_more_text')): the_row(); 
	$title = get_sub_field('title'); 
	?>
	<section class="module <?= ($title ? 'module-question' : 'module-question-hidden'); ?>">
			<p class="module-title font-h1"><?= $title ?></p>
		<div class="more-info-container">
			<div class="more-info-title">
			<p class="text font-p3" data-text-closed="<?=get_sub_field('read_more_title', true)?>" data-text-opened="<?=get_sub_field('read_more_title', true)?>"><?=get_sub_field('read_more_title', true)?></p>
		<?php endwhile; ?>
		<?php endif; ?>
				<svg class="arrow" width="23" height="10" viewBox="0 0 23 10" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M1 1.30762L11.5 9.30762L22 1.30762" stroke="#181818"/>
				</svg>
			</div>
			<div class="more-info-content">
				<div class="more-info-content-wrapper">
					<?php 
					if (have_rows('read_more_text')) {
						$i = 1;
						while (have_rows('read_more_text')) {
							the_row();							
							$more_info = get_sub_field('more_info');
							echo '<p class="title font-h3 font-medium font-center">FAQ: ' . get_the_title() .'</p>';
							if ($more_info) {
								foreach ($more_info as $info) {
									echo '<div class="column">';
									echo '<h2 class="title font-h3 font-medium">' . $i . '. ' . $info['title'] . '</h2>';
									echo '<p class="text font-p2">' . $info['text'] . '</p>';
									echo '</div>';
									$i++;
								}
							}
						}
					}
					?>
				</div>
			</div>
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
		<section class="module module-logos with-title background-black">
			<h2 class="title font-h1 font-color-white"><?=get_sub_field('title')?></h2>
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
								<p class="text font-p"><?=get_sub_field('text')?></p>
							</div>
							<?php
							$active = '';
						}
						?>
					</div>
					<div class="image-container only-desktop">
						<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
					</div>
				</div>
			</div>
		</section>
		<?php
	}elseif($layout == 'reviews'){
		?>
		<section class="module module-review background-blue">
			<div class="slider-wrapper swiper-wrapper">
				<?php
				while(have_rows('reviews')){
					the_row();
					$image = get_sub_field('author_image');
					?>
					<div class="slide swiper-slide">
						<p class="review font-h2 font-color-white"><?=get_sub_field('review')?></p>
						<p class="author-name font-p3 font-semibold"><?=get_sub_field('author')?></p>
						<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="author-image">
					</div>
					<?php
				}
				?>
			</div>
			<div class="steps-container"></div>
		</section>
		<?php
	}elseif($layout == 'banner'){
		$info_color = jg_get_info_background_color('main');
		$button_color = 'white';
		if($info_color['color'] == 'white'){
			$button_color = 'black';
		}
		?>
		<section class="module module-banner-text-button background-<?=$info_color['color']?> font-color-<?=$info_color['font_color']?>" <?=$info_color['other_color_style']?>>
			<p class="title font-h1"><?=get_sub_field('text')?></p>
			<a href="<?=get_permalink($id_projects_main_page)?>" class="button button-<?=$button_color?>"><?=__('View all projects', 'think-appart')?></a>
		</section>
		<?php
	}elseif($layout == 'form'){
		jg_print_contact_form('background-yellow');
	} 

}

get_footer();