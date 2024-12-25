<?php
/**
 * Template name: Projects
 */
wp_enqueue_style('think-appart-projects-style', get_template_directory_uri().'/css/template-projects.css', array(), THINK_APPART_THEME_VERSION);

// Header
get_header();
?>

<section class="module module-filter-works">
	<?php
	$active = 'active';
	$current_service = -1;
	$services = get_posts([
		'numberposts' => -1,
		'post_type' => 'services',
		'fields' => 'ids',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_parent' => 0, // exclude child posts
		'suppress_filters' => false,
	]);
	if(!empty($_GET['service'])){
		$current_service = intval($_GET['service']);
		$current_service_lang = apply_filters( 'wpml_object_id', $current_service, 'services', true );
		if(!in_array($current_service_lang, $services)){
			$current_service = -1;
		}else{
			$active = '';
		}
	}
	$full_filters = 'all ';
	?>	
	<p class="filter-work font-p3 <?=$active?>" data-filter="all" ><?=__('All', 'think-appart')?></p>
	<?php
	foreach ($services as $service) {
		$active = '';
		$service_en = apply_filters( 'wpml_object_id', $service, 'services', true, 'en' );
		if($service_en == $current_service){
			$active = 'active';
		}
		$full_filters .= $service_en . ' ';
		?>
		<p class="filter-work font-p3 <?=$active?>" data-filter="<?=$service_en?>" ><?=get_the_title($service)?></p>
		<?php
	}
	?>
</section>

<section class="module module-works">
	<?php
	$projects = get_posts([
		'numberposts' => -1,
		'post_type' => 'projects',
		'fields' => 'ids',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'suppress_filters' => false,
	]);
	$n_projects = count($projects);
	foreach ($projects as $project) {
		while(have_rows('general', $project)){
			the_row();
			$project_class = '';
			$project_bg = jg_get_info_background_color('hover');
			$services = get_sub_field('services');
			if($current_service != -1 && !in_array($current_service, $services)){
				$project_class = 'hidden';
			}
			?>
			<a href="<?=get_permalink($project)?>" class="work-container <?=$project_class?>" data-filter="all <?=implode(' ', $services)?>">
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
	while(have_rows('banner')){
		the_row();
		$background = jg_get_info_background_color('main');
		$banner_class = '';
		$general_banner_class = 'hidden';
		if($n_projects % 2 == 0){
			$banner_class = 'hidden';
			$general_banner_class = '';
		}
		?>
		<div class="work-container banner-text-button <?=$banner_class?> background-<?=$background['color']?> font-color-<?=$background['font_color']?>" <?=$background['other_color_style']?> data-filter="<?=$full_filters?>">
			<p class="title font-h1"><?=get_sub_field('banner_text')?></p>
			<a href="<?=get_permalink(get_sub_field('banner_link'))?>" class="button button-full-white"><?=get_sub_field('banner_button_text')?></a>
		</div>
		<?php
	}
	?>
</section>

<?php
while(have_rows('banner')){
	the_row();
	$background = jg_get_info_background_color('main');
	?>
	<section class="module module-banner-text-button <?=$general_banner_class?> background-<?=$background['color']?> font-color-<?=$background['font_color']?>" <?=$background['other_color_style']?>>
		<p class="title font-h1"><?=get_sub_field('banner_text')?></p>
		<a href="<?=get_permalink(get_sub_field('banner_link'))?>" class="button button-full-white"><?=get_sub_field('banner_button_text')?></a>
	</section>
	<?php
}
?>


<?php
// Footer
get_footer();
