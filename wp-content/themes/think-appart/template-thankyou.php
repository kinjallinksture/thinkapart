<?php
/**
 * Template name: Thank you
 */
wp_enqueue_style('think-appart-single-landings-style', get_template_directory_uri().'/css/single-landings.css', array(), THINK_APPART_THEME_VERSION);

// Header
get_header();

while(have_rows('cover')){
	the_row();
	$image = get_sub_field('image');
	?>
	<section class="module module-cover-single-landings type-text">
		<div class="circle-container">
			<svg class="circle" width="144" height="288" viewBox="0 0 144 288" fill="none" xmlns="http://www.w3.org/2000/svg">
				<circle cy="144" r="144" fill="#00D3A8"/>
			</svg>
		</div>
		<div class="text-container font-color-<?=$text_color?>">
			<div class="image-container">
				<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
			</div>
			<h1 class="title font-h1"><?=get_sub_field('title')?></h1>
			<p class="text font-h3"><?=get_sub_field('text')?></p>
		</div>
	</section>
	<?php
}

get_footer();