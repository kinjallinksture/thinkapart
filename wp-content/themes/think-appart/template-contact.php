<?php
/**
 * Template name: Contact
 */
wp_enqueue_style('think-appart-contact-style', get_template_directory_uri().'/css/template-contact.css', array(), THINK_APPART_THEME_VERSION);

// Header
get_header();

while(have_rows('cover')){
	the_row();
	?>
	<section class="module module-cover-contact">
		<?php
		$type_cover = get_sub_field('type_cover');
		if($type_cover == 'image'){
			$image = get_sub_field('image');
			?>
			<div class="media-container">
				<div class="background-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image"></div>
			</div>
			<?php
		}elseif($type_cover == 'video'){
			$video = get_sub_field('video');
			?>
			<div class="media-container">
				<div class="background-image">
					<video src="<?=$video['url']?>" class="image" playsinline autoplay loop muted></video>
				</div>
			</div>
			<?php
		}
		?>
		<div class="text-container font-color-<?=get_sub_field('text_color')?>">
			<h1 class="title font-h1"><?=get_sub_field('title')?></h1>
			<p class="text font-h3"><?=get_sub_field('text')?></p>
		</div>
	</section>
	<?php
}

while (have_rows('content')) {
	the_row();
	$layout = get_row_layout();

	if($layout == 'buttons'){
		?>
		<section class="module module-banner-buttons background-green">
			<?php
			while(have_rows('buttons')){
				the_row();
				?>
				<a href="<?=get_sub_field('link')?>" class="button button-green-black" target="_blank" rel="noopener noreferrer"><?=get_sub_field('text')?></a>
				<?php
			}
			?>
		</section>
		<?php
	}elseif($layout == 'form'){
		jg_print_contact_form();
	}elseif($layout == 'offices'){
		$offices = get_field('offices', 'option');
		$n_offices = count($offices);
		$button = '';
		$button_type = get_sub_field('type_button');
		if($button_type == 'link'){
			$button = '<a href="'.get_permalink(get_sub_field('page')).'" class="button button-black-border-white">'.get_sub_field('text').'</a>';
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
	}
}

// Footer
get_footer();
