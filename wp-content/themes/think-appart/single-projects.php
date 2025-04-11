<?php
wp_enqueue_style('think-appart-single-projects-style', get_template_directory_uri().'/css/single-projects.css', array(), THINK_APPART_THEME_VERSION);

// Header
get_header();

$cpt_projects = get_field('cpt_projects', 'option');
$id_projects_main_page = $cpt_projects['projects_main_page'];

while(have_rows('general')){
	the_row();
	?>
	<section class="module module-cover-single-projects">
		<?php
		$type = get_sub_field('media_type');
		if($type == 'image'){
			$image = get_sub_field('image');
			?>
			<div class="image-container">
				<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
			</div>
			<?php
		}elseif($type == 'video'){
			$video = get_sub_field('video');
			?>
			<div class="video-container">
				<video src="<?=$video['url']?>" class="video" autoplay muted loop playsinline></video>
			</div>
			<?php
		}
		?>
	</section>

	<section class="module module-project-info background-black font-color-white">
		<div class="column">
			<p class="title font-p font-h3-mobile font-regular font-color-green"><?=__('Project', 'think-appart')?></p>
			<p class="font-p2"><?=get_sub_field('title')?></p>
		</div>
		<div class="column big">
			<p class="title font-p font-h3-mobile font-regular font-color-green"><?=__('Services', 'think-appart')?></p>
			<div class="buttons-container">
				<?php
				$services = get_sub_field('services');
				foreach ($services as $service) {
					$service_lang = apply_filters( 'wpml_object_id', $service, 'services', true );
					?>
					<a href="<?=get_permalink($id_projects_main_page)?>?service=<?=$service?>" class="button button-white-green"><?=get_the_title($service_lang)?></a>
					<?php
				}
				?>
			</div>
		</div>
		<div class="column">
			<p class="title font-p font-h3-mobile font-regular font-color-green"><?=__('Credits', 'think-appart')?></p>
			<p class="font-p2"><?=get_sub_field('credits')?></p>
		</div>
	</section>
	<?php
}
?>

<div class="content-project">
	<?php
	$first_module = 'first-module';
	while(have_rows('content')){
		the_row();
		$layout = get_row_layout();
		if($layout == 'change_background'){
			$change_background = jg_get_info_background_color('', false);
			$class = 'background-' . $change_background['color'] . ' font-color-'.$change_background['font_color'];
			?>
			<div class="change-background <?=$first_module?>" data-class="<?=$class?>" data-<?=$change_background['other_color_style']?>></div>
			<?php
		}elseif($layout == 'text'){
			?>
			<section class="module module-project-text">
				<p class="column-text font-<?=get_sub_field('text_size')?>"><?=get_sub_field('text')?></p>
			</section>
			<?php
		}elseif($layout == 'text_two_colums'){
			?>
			<section class="module module-project-text-two-columns">
				<p class="column-text font-<?=get_sub_field('left_text_size')?>"><?=get_sub_field('left_text')?></p>
				<p class="column-text font-<?=get_sub_field('right_text_size')?>"><?=get_sub_field('right_text')?></p>
			</section>
			<?php
		}elseif($layout == 'image'){
			$image_width = get_sub_field('image_width');
			$image_position = get_sub_field('image_position');
			$image = get_sub_field('image');
			$border_rounded = '';
			if(get_sub_field('image_border_rounded')){
				$border_rounded = 'border-rounded';
			}
			?>
			<section class="module module-project-image <?=$image_width?> position-<?=$image_position?>">
				<div class="image-container <?=$border_rounded?>">
					<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
				</div>
			</section>
			<?php
		}elseif($layout == 'imagen_&_text'){
			$image_position = get_sub_field('image_position');
			$text_position = get_sub_field('text_position');
			$image = get_sub_field('image');
			$border_rounded = '';
			if(get_sub_field('image_border_rounded')){
				$border_rounded = 'border-rounded';
			}
			?>
			<section class="module module-project-image-text image-position-<?=$image_position?> text-position-<?=$text_position?>">
				<p class="text font-<?=get_sub_field('text_size')?>"><?=get_sub_field('text')?></p>
				<div class="image-container <?=$border_rounded?>">
					<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
				</div>
			</section>
			<?php
		}elseif($layout == 'video'){
			$video_width = get_sub_field('video_width');
			$video = get_sub_field('video');
			$image = get_sub_field('image');
			$autoplay = '';
			if(get_sub_field('autoplay')){
				$autoplay = 'autoplay loop muted';
			}
			$border_rounded = '';
			if(get_sub_field('video_border_rounded')){
				$border_rounded = 'border-rounded';
			}
			if(!get_sub_field('video_aspect_ratio')){
				$border_rounded .= ' height-auto';
			}
			?>
			<section class="module module-project-video <?=$video_width?>">
				<div class="video-container <?=$border_rounded?>">
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
			</section>
			<?php
		}elseif($layout == 'video_&_text'){
			$video_position = get_sub_field('video_position');
			$text_position = get_sub_field('text_position');
			$video = get_sub_field('video');
			$video_poster = get_sub_field('video_poster');
			$autoplay = '';
			if(get_sub_field('autoplay')){
				$autoplay = 'autoplay loop muted';
			}
			$border_rounded = '';
			if(get_sub_field('video_border_rounded')){
				$border_rounded = 'border-rounded';
			}
			if(!get_sub_field('video_aspect_ratio')){
				$border_rounded .= ' height-auto';
			}
			?>
			<section class="module module-project-video-text video-position-<?=$video_position?> text-position-<?=$text_position?>">
				<p class="text font-<?=get_sub_field('text_size')?>"><?=get_sub_field('text')?></p>
				<div class="video-container <?=$border_rounded?>">
					<video src="<?=$video['url']?>" class="video" <?=$autoplay?> playsinline></video>
					<?php
					if(empty($autoplay)){
						?>
						<div class="mask-container background-image">
							<img src="<?=$video_poster['url']?>" alt="<?=$video_poster['alt']?>" class="image">
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
			</section>
			<?php
		}elseif($layout == 'video_&_image'){
			$video_position = get_sub_field('video_position');
			$video = get_sub_field('video');
			$video_poster = get_sub_field('video_poster');
			$image = get_sub_field('image');
			$autoplay = '';
			if(get_sub_field('autoplay')){
				$autoplay = 'autoplay loop muted';
			}
			$video_aspect_ratio = '';
			if(!get_sub_field('video_aspect_ratio')){
				$video_aspect_ratio = 'height-auto';
			}
			?>
			<section class="module module-project-video-image video-position-<?=$video_position?>">
				<div class="video-container <?=$video_aspect_ratio?>">
					<video src="<?=$video['url']?>" class="video" <?=$autoplay?> playsinline></video>
					<?php
					if(empty($autoplay)){
						?>
						<div class="mask-container background-image">
							<img src="<?=$video_poster['url']?>" alt="<?=$video_poster['alt']?>" class="image">
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
				<div class="image-text-container">
					<div class="image-container">
						<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
					</div>
				</div>
			</section>
			<?php
		}
		$first_module = '';
	}
	?>
</div>

<section class="module module-works">
	<p class="module-title font-h1"><?=__('You may also like these projects', 'think-appart')?></p>
	<?php
	while(have_rows('related_projects')){
		the_row();
		$projects = get_sub_field('projects');
	}
	$n_projects = count($projects);
	if($n_projects < 2){
		$projects = array_merge($projects, get_posts([
			'numberposts' => (2 - $n_projects),
			'post_type' => 'projects',
			'exclude' => array_merge([get_post()->ID], $projects),
			'fields' => 'ids',
			'suppress_filters' => false,
		]));
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
<section class="module module-banner-text-button background-blue font-color-white">
	<p class="title font-h1"><?=$cpt_projects['banner_view_all_projects_text']?></p>
	<a href="<?=get_permalink($id_projects_main_page)?>" class="button button-full-white"><?=__('View all projects', 'think-appart')?></a>
</section>
<?php

// Footer
get_footer();
