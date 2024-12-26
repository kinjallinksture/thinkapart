<?php
wp_enqueue_style('think-appart-single-services-style', get_template_directory_uri().'/css/single-services.css', array(), THINK_APPART_THEME_VERSION);

// Header
get_header();

$id_services_main_page = get_field('cpt_services', 'option')['services_main_page'];
$id_projects_main_page = get_field('cpt_projects', 'option')['projects_main_page'];

while(have_rows('general')){
	the_row();
	$image = get_sub_field('image');

	$module_slider_class = 'no-stuck';
	if(get_sub_field('stuck_texts_section')){
		$module_slider_class = '';
	}

	$background = jg_get_info_background_color('main');
	if($background['color'] == 'white'){
		$background['color'] = 'black';
		$background['font_color'] = 'white';
	}
	?>
	<section class="module module-cover-single-services title-image-main">
		<div class="title-image-container">
		<div class="title-container">
			<p class="breadcrumb-container font-p font-bold"><a class="font-bold" href="<?=get_permalink($id_services_main_page)?>"><?=get_the_title($id_services_main_page)?></a> | <?=get_the_title()?></p>
			<h1 class="font-h1"><?=get_sub_field('title')?></h1>
		</div>
		<div class="image-container image-desktop-view">
			<div class="background-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image"></div>
		</div>
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
		
		<!-- Added by TBS - Dynamic but will only show the services AOI that exist so please make sure to add all AOI and use this -->
		<!-- <div class="areas-container font-p">
			<p class="title font-bold"><?=get_sub_field('list_areas_title')?> Dynamic</p>
			<?php
			// $list_areas_dynamic = get_sub_field('list_areas_dynamic');
			// if ($list_areas_dynamic) {
			// 	foreach ($list_areas_dynamic as $post) {
			// 		setup_postdata($post);

			// 		$area_link = get_field('area_link');
			// 		$area_name = get_the_title(); 
			?>
					<p><a href="<?= $area_link ?>"><?php echo $area_name; ?></a></p>
			<?php
				// }
				// wp_reset_postdata();
			//}
			?>
		</div> -->
	</section>
	<section class="module module-slider-scroll with-top-image <?=$module_slider_class?> background-<?=$background['color']?> font-color-<?=$background['font_color']?>">
		<div class="image-container image-mobile-view">
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

	<?php if (have_rows('read_more_text')): ?>
	<?php while (have_rows('read_more_text')): the_row(); ?>
	<?php $title = get_sub_field('title'); ?>
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
}

while(have_rows('works')){
	the_row();
	?>
	<section class="module module-works">
		<?php
		$projects = get_sub_field('featured_works');
		if(empty($projects)){
			$projects = [];
		}
		foreach ($projects as $project) {
			while(have_rows('general', $project)){
				the_row();
				$project_bg = jg_get_info_background_color('hover');
				?>
				<a href="<?=get_permalink($project)?>" class="work-container">
					<div class="background-image">
						<?php
						$type = get_sub_field('thumbnail_media_type');
						if($type == 'image'){
							$image = get_sub_field('thumbnail_image');
							?>
								<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
							<?php
						}elseif($type == 'video'){
							$video = get_sub_field('thumbnail_video');
							?>
								<video src="<?=$video['url']?>" class="image" autoplay muted loop playsinline></video>
							<?php
						}
						?>
					</div>
					<div class="text-container background-<?=$project_bg['color']?> font-color-<?=$project_bg['font_color']?>" <?=$project_bg['other_color_style']?>>
						<p class="font-p"><?=get_sub_field('title')?></p>
					</div>
				</a>
				<?php
			}
		}
		?>
	</section>
	<?php
	if(get_sub_field('add_view_all_projects')){
		?>
		<section class="module module-banner-text-button background-black font-color-white">
			<p class="title font-h1"><?=get_sub_field('text_view_all_projects')?></p>
			<a href="<?=get_permalink($id_projects_main_page)?>?service=<?=get_post()->ID?>" class="button button-white"><?=__('View all projects', 'think-appart')?></a>
		</section>
		<?php
	}
}

while(have_rows('awards')){
	the_row();
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
}

while(have_rows('client_logos')){
	the_row();
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
}

if(have_rows('reviews')){
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
}

while(have_rows('form')){
	the_row();
	jg_print_contact_form();
}

while(have_rows('sylo_structure')){
	the_row();
	if(get_sub_field('include')){
		?>
		<section class="module module-sylo background-yellow">
			<h2 class="module-title font-h1"><?=get_sub_field('title')?></h2>
			<div class="sections-container">
				<?php
				while(have_rows('sections')){
					the_row();
					$image = get_sub_field('image');
					?>
					<div class="section-container">
						<div class="image-container">
							<div class="background-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image"></div>
						</div>
						<div class="section-title-container">
							<h3 class="font-h3"><?=get_sub_field('title')?></h3>
							<svg class="arrow" viewBox="0 0 22 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M0.638673 1L11.1387 9L21.6387 1" stroke="black"/>
							</svg>
						</div>
						<div class="links-container-wrapper">
							<div class="links-container">
								<?php
								$links = get_sub_field('links');
								foreach ($links as $link) {
									?>
									<a href="<?=get_permalink($link)?>" class="link font-p3"><?=get_the_title($link)?></a>
									<?php
								}
								?>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</section>
		<?php
	}
}

// Footer
get_footer();
