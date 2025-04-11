<?php
/**
 * Template name: Jobs
 */
wp_enqueue_style('think-appart-jobs-style', get_template_directory_uri().'/css/template-jobs.css', array(), THINK_APPART_THEME_VERSION);

// Header
get_header();

while(have_rows('cover')){
	the_row();
	$office = get_sub_field('office');
	?>
	<section class="module module-cover-jobs">
		<div class="text-container">
			<h1 class="title font-h2"><?=get_sub_field('title')?></h1>
		</div>
	</section>
	<?php
}

while (have_rows('jobs')) {
	the_row();
	$offices = get_sub_field('offices');
	?>
	<section class="module module-offices-jobs background-blue font-color-white">
		<div class="buttons-container">
			<?php
			$active = 'active';
			foreach ($offices as $office) {
				?>
				<p class="button button-blue <?=$active?>" data-office="<?=$office->term_id?>"><?=$office->name?></p>
				<?php
				$active = '';
			}
			?>
		</div>
		<div class="offices-container">
			<?php
			$active = 'active';
			foreach ($offices as $office) {
				$offers = get_posts([
					'numberposts' => -1,
					'post_type' => 'jobs',
					'tax_query' => [[
						'taxonomy' => 'offices',
						'field' => 'term_id',
						'terms' => $office->term_id,
					]],
					'fields' => 'ids',
					'suppress_filters' => false,
				]);
				?>
				<div class="office-container <?=$active?>" data-office="<?=$office->term_id?>">
					<div class="title-container">
						<p class="office font-p"><strong><?=$office->name?></strong></p>
						<p class="font-h2 font-color-black font-regular"><?=get_sub_field('title')?></p>
					</div>
					<div class="offers-container">
						<?php
						if(empty($offers)){
							?>
							<p class="font-h2"><?=get_sub_field('no_jobs_text')?></p>
							<?php
						}else{
							foreach ($offers as $offer) {
								?>
								<a href="<?=get_permalink($offer)?>" class="offer">
									<span class="offer-title font-h2"><?=get_the_title($offer)?></span>
									<svg class="arrow" width="19" height="43" viewBox="0 0 19 43" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1.33203 41.4747L16.332 21.4747L1.33203 1.47473" stroke="white" stroke-width="3"/>
									</svg>
								</a>
								<?php
							}
						}
						?>
					</div>
				</div>
				<?php
				$active = '';
			}
			?>
		</div>
	</section>
	<?php
}

// Footer
get_footer();
