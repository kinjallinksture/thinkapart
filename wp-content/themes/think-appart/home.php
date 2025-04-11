<?php
/**
 * Template name: Blog
 */
wp_enqueue_style('think-appart-blog-style', get_template_directory_uri().'/css/template-blog.css', array(), THINK_APPART_THEME_VERSION);

// Header
get_header();

$id_blog_main_page = get_option('page_for_posts');
$current_language = apply_filters('wpml_current_language', NULL);
 
?>
<!-- Off Canvas Container -->
<div id="offCanvas" class="off-canvas">
	<button id="closeOffCanvasButton" class="close-button">
	<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M1 20.999L20.9997 0.999289" stroke="white" stroke-width="2.5"/>
		<path d="M1 1L20.9997 20.9997" stroke="white" stroke-width="2.5"/>
	</svg>
	</button>
	<div class="off-canvas-content">
		<div class="sidebar-container">
			<h3 class="font-p font-color-green font-medium padding-0-0-20-0"><?php echo esc_html(($current_language === 'es') ? 'Buscar en el Blog' : (($current_language === 'th') ? 'ค้นหาบล็อก' : 'Search Blog')); ?></h3>
			<form role="search" method="get" id="searchform" class="searchform" action="https://staging4.thinkappart.com/">
				<div>
					<label class="screen-reader-text" for="s">Search for:</label>
					<input type="text" value="" name="s" id="s" placeholder="Type here and press enter...">
					<button type="submit" id="searchsubmit" class="search-icon-button">
						<i class="fa fa-search" style="color:#fff"></i>
					</button>
				</div>
			</form>
		</div>
		<div class="sidebar-container">
			<h3 class="font-p font-color-green font-medium padding-0-0-20-0"><?php echo esc_html(($current_language === 'es') ? 'Categorías del Blog' : (($current_language === 'th') ? 'หมวดหมู่บล็อก' : 'Blog Categories')); ?></h3>
			<div class="button-group">
			<?php
                $categories = get_categories();
                foreach ($categories as $category) {
					if (($category->name) == "Other"){
					}else{
						echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button button-small button-white category-button">' . esc_html($category->name) . '</a>';
					}
                }
            ?>
			</div>
		</div>
		<div class="sidebar-container">
			<h3 class="font-p font-color-green font-medium padding-0-0-20-0"><?php echo esc_html(($current_language === 'es') ? 'Entradas Recientes' : (($current_language === 'th') ? 'โพสต์ล่าสุด' : 'Recent Posts')); ?></h3>
			<div class="recent-posts">
				<?php
				$recent_posts = new WP_Query(array(
					'posts_per_page' => 3,
					'post_status' => 'publish',
				));
				while ($recent_posts->have_posts()) : $recent_posts->the_post();
				?>
					<a href="<?php the_permalink(); ?>"  class="text" style="color:#fff;"><?php the_title(); ?></a><br>
				<?php
				endwhile;
				wp_reset_postdata(); 
				?>
			</div>
		</div>
		<div class="sidebar-container">
			<h3 class="font-p font-color-green font-medium padding-0-0-20-0"><?php echo esc_html(($current_language === 'es') ? 'Nuestros Servicios' : (($current_language === 'th') ? 'บริการของเรา' : 'Our Services')); ?></h3>
			<div class="related-services">
                <?php
                $services = new WP_Query(array(
					'post_type' => 'services',
					'post_status' => 'publish',
					'order'          => 'ASC',
					'orderby'        => 'title',
					'post_parent' => 0, // exclude child posts
                ));
				$total_posts = $services->post_count;
				$counter = 0;
				while ($services->have_posts()) : $services->the_post();
				$counter++;
                ?>
                    <a href="<?php the_permalink(); ?>" class="text" style="color:#fff;"><?php the_title(); ?></a>
				<?php
				 if ($counter < $total_posts) {
					?>
					<p class="text sep" style="color:#fff;">|</p>
					<?php
				}
				endwhile;
				wp_reset_postdata(); 
				?>
            </div>
		</div>
	</div>
</div>

<!-- Overlay -->
<div class="overlay"></div>

<section class="module module-blog">
	<h1 class="module-title font-h1"><span class="font-h1 font-color-green">Appart_</span><?=get_the_title($id_blog_main_page)?></h1>
	<!-- Filter Button -->
	<div class="filter-container module-title">
		<a href="#" id="openPopupButton" class="button-filter button-white font-p">Filter</a>
	</div>

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
						$description = implode($description,' ').'...';
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
			<p class="empty-text font-p"><?php echo __('No content', 'think-appart'); ?></p>
			<?php
		}
		?>
	</div>
</section>

<?php
while(have_rows('newsletter', $id_blog_main_page)){
	the_row();
	?>
	<section class="module module-form background-green">
		<p class="tagline font-h3"><?=get_sub_field('tagline')?></p>
		<p class="title-container font-h1"><?=get_sub_field('title')?></p>
		<?=do_shortcode(get_sub_field('shortcode_form'))?>
	</section>
	<?php
}
// Footer
get_footer();
