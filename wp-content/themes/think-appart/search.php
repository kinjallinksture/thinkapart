<?php
/**
 * Búsqueda
 */

wp_enqueue_style('think-appart-blog-style', get_template_directory_uri().'/css/template-blog.css', array(), THINK_APPART_THEME_VERSION);

// Cabecera
get_header(); ?>

<section class="module module-blog">
	<h1 class="module-title font-h1"><span class="font-h1 font-color-green"></span>Search Results</h1>

	<div class="posts-container">
		<?php
		if(have_posts()){
			$i = 0;
			$show_date = get_field('cpt_posts', 'option')['show_date'];
			while(have_posts()){
				the_post();
				$font_small_size = 'font-p3';
				$font_big_size = 'font-h3';
				if($i == 0){
					$font_small_size = 'font-p';
					$font_big_size = 'font-h1';
				}
				while(have_rows('general')){
					the_row();
					$image = get_sub_field('image');
					$description = get_sub_field('short_description_general');
					if(empty($description)){
						$description = get_sub_field('short_description');
						$description = explode(' ', substr($description, 0, 200));
						array_pop($description);
						$description = implode(' ', $description).'...';
					}
					?>
					<div class="post-container">
						<div class="image-container">
							<div class="background-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image"></div>
						</div>
						<div class="text-container">
							<?php
							if($show_date){
								?>
								<p class="date <?=$font_small_size?> font-color-green font-medium font-uppercase"><?=get_the_date('j F Y')?></p>
								<?php
							}
							?>
							<a href="<?=get_permalink()?>" class="title <?=$font_big_size?>"><?=get_the_title()?></a>
							<p class="description <?=$font_small_size?> font-color-gray"><?=$description?></p>
						</div>
					</div>
					<?php
				}
				$i++;
			}
			?>
			<div class="pagination-container font-p2">
				<?php
				if(!empty(get_previous_posts_link())){
					previous_posts_link('<svg class="pagination-arrow" width="7" height="15" viewBox="0 0 7 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M6.33203 1L1.33203 7.5L6.33203 14" stroke="black"/>
						</svg>');
				}else{
					echo '<svg class="pagination-arrow disabled" width="7" height="15" viewBox="0 0 7 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M6.33203 1L1.33203 7.5L6.33203 14" stroke="#D9D9D9"/>
						</svg>';
				}
				echo '<div class="pagination-numbers-container">';
				echo paginate_links(array(
					'base' => get_pagenum_link(1) . '%_%',
					'format' => 'page/%#%',
					'prev_next' => false,
				));
				echo '</div>';
				if(!empty(get_next_posts_link())){
					next_posts_link('<svg class="pagination-arrow" width="7" height="15" viewBox="0 0 7 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.33203 14L6.33203 7.5L1.33203 1" stroke="black"/>
						</svg>');
				}else{
					echo '<svg class="pagination-arrow disabled" width="7" height="15" viewBox="0 0 7 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.33203 14L6.33203 7.5L1.33203 1" stroke="#D9D9D9"/>
						</svg>';
				}
				?>
			</div>
			<?php
		}else{
			?>
			<p class="empty-text font-p"><?php echo __('No Result Found', 'think-appart'); ?></p>
			<?php
		}
		?>
	</div>
</section>


<?php
get_footer();