<?php
/**
 * Template name: About
 */
wp_enqueue_style('think-appart-about-style', get_template_directory_uri().'/css/template-about.css', array(), THINK_APPART_THEME_VERSION);

// Header
get_header();

$title_tag = 'h1';

echo '<div class="modules-about">';

while (have_rows('content')) {
	the_row();
	$layout = get_row_layout();

	if($layout == 'title_&_text'){
		$tag = 'p';
		$title_class = 'empty';
		$title = get_sub_field('title');
		if(!empty($title)){
			$tag = $title_tag;
			$title_tag = 'p';
			$title_class = '';
		}
		$text = get_sub_field('text');
		$text_class = (empty($text)) ? 'empty' : '';
		?>
		<section class="module module-title-text">
			<<?=$tag?> class="title font-h2 <?=$title_class?>"><?=$title?></<?=$tag?>>
			<p class="text font-p2 <?=$text_class?>"><?=get_sub_field('text')?></p>
		</section>
		<?php
	} elseif ( $layout == 'our_achievements' ) {
		$template_name = 'our-achievements';
		get_template_part( 'template-parts/acf-flexible/' . $template_name );
	} elseif ( $layout == 'industries' ) {
		$template_name = 'industries';
		get_template_part( 'template-parts/acf-flexible/' . $template_name );
	} elseif ( $layout == 'mission' ) {
		$template_name = 'mission';
		get_template_part( 'template-parts/acf-flexible/' . $template_name );
	} elseif($layout == 'image'){
		$image = get_sub_field('image');
		$image_position = get_sub_field('image_position');
		?>
		<section class="module module-image image-position-<?=$image_position?>">
			<div class="image-container js-parallax" data-parallax-factor="1">
				<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
			</div>
		</section>
		<?php
	}elseif($layout == 'team'){
		?>
		<section class="module module-team">
			<?php
			while(have_rows('team')){
				the_row();
				$image            = get_sub_field('image');
				$team_details     = get_sub_field('team_details');
				$linkedin_profile = get_sub_field('linkedin_profile');
				?>
				<div class="item">
					<div class="image-container">
						<div class="background-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image"></div>
					</div>
					<div class="team-details-wrapper">
						<p class="name font-p"><strong><?=get_sub_field('name')?></strong></p>
						<p class="font-p2 font-regular"><?=get_sub_field('role')?></p>
						<?php
						if ( ! empty( $linkedin_profile ) ) {
							?>
							<a class="linkedin-icon" href="<?php echo esc_url( $linkedin_profile ); ?>" target="_blank">
								<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/LinkedIn.svg" alt="<?php echo _x( 'LinkedIn', 'think-appart' ); ?>">
							</a>
							<?php
						}
						if ( ! empty( $team_details ) ) {
							?>
							<div class="team-details">
								<?php echo $team_details; //phpcs:ignore ?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}
			?>
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
	}elseif($layout == 'images'){
		?>
		<section class="module module-about-home background-yellow">
			<div class="title-container">
				<p class="module-title font-h1"><?=get_sub_field('title')?></p>
			</div>
			<div class="images-container swiper-wrapper">
				<?php
				$images = get_sub_field('images');
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
		</section>
		<?php
	}elseif($layout == 'section_link'){
		$image_1 = get_sub_field('image_1');
		$image_2 = get_sub_field('image_2');
		?>
		<section class="module module-link-section">
			<div class="text-container">
				<p class="tagline font-p"><strong><?=get_sub_field('tagline')?></strong></p>
				<p class="title font-h2"><?=get_sub_field('title')?></p>
				<?php
				while(have_rows('button')){
					the_row();
					if(get_sub_field('include')){
						?>
						<a href="<?=get_permalink(get_sub_field('link'))?>" class="button button-black"><?=get_sub_field('text')?></a>
						<?php
					}
				}
				?>
			</div>
			<div class="images-container">
				<div class="image-container">
					<img src="<?=$image_1['url']?>" alt="<?=$image_1['alt']?>" class="image">
				</div>
				<?php
				if(!empty($image_2)){
					?>
					<div class="image-container">
						<img src="<?=$image_2['url']?>" alt="<?=$image_2['alt']?>" class="image">
					</div>
					<?php
				}
				?>
			</div>
		</section>
		<?php
	}
}

echo '</div>';

// Footer
get_footer();
