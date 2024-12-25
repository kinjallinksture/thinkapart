<?php

wp_enqueue_style('think-appart-single-jobs-style', get_template_directory_uri().'/css/single-jobs.css', array(), THINK_APPART_THEME_VERSION);

// Header
get_header();

$id_jobs_main_page = get_field('cpt_jobs', 'option')['jobs_main_page'];

while(have_rows('cover')){
	the_row();
	$office = get_sub_field('office');
	?>
	<section class="module module-cover-single-jobs">
		<div class="title-container">
			<a href="<?=get_permalink($id_jobs_main_page)?>" class="location font-p font-h3-mobile font-color-green"><strong><?=get_the_title($id_jobs_main_page)?> / <?=$office->name?></strong></a>
			<h1 class="title font-h1 font-regular"><?=get_the_title()?></h1>
		</div>
		<div class="text-container">
			<p class="title font-h1"><?=get_sub_field('title')?></p>
			<p class="text font-h3 font-p2-mobile"><?=get_sub_field('text')?></p>
		</div>
	</section>
	<?php
}

while (have_rows('about_us')) {
	the_row();
	$show = get_sub_field('show');
	if($show == 'general'){
		while(have_rows('general_jobs_single', 'option')){
			the_row();
			while(have_rows('about_us', 'option')){
				the_row();
				jg_print_single_jobs_about_us();
			}
		}
	}elseif($show == 'custom'){
		jg_print_single_jobs_about_us();
	}

}

while (have_rows('form')) {
	the_row();
	$general = get_sub_field('use_general_jobs_form');
	if($general){
		while(have_rows('general_jobs_single', 'option')){
			the_row();
			while(have_rows('form', 'option')){
				the_row();
				jg_print_single_jobs_form();
			}
		}
	}else{
		jg_print_single_jobs_form();
	}

}

get_footer();

function jg_print_single_jobs_about_us(){
	?>
	<section class="module module-about-jobs background-green">
		<div class="title-container">
			<p class="title font-h1"><?=get_sub_field('title')?></p>
		</div>
		<div class="text-container">
			<?php
			while(have_rows('content')){
				the_row();
				$layout = get_row_layout();
				if($layout == 'text'){
					?>
					<p class="content text font-h3 font-p2-mobile"><?=get_sub_field('text')?></p>
					<?php
				}elseif($layout == 'image'){
					$image = get_sub_field('image');
					?>
					<div class="content image-container">
						<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
					</div>
					<?php
				}
			}
			?>
		</div>
	</section>
	<?php
}

function jg_print_single_jobs_form(){
	?>
	<section class="module module-form">
		<p class="title-container font-h1"><?=get_sub_field('title')?></p>
		<?=do_shortcode(get_sub_field('shortcode_form'))?>
	</section>
	<?php
}