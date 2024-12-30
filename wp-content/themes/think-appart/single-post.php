<?php
wp_enqueue_style('think-appart-single-post-style', get_template_directory_uri().'/css/single-post.css', array(), THINK_APPART_THEME_VERSION);

// Header
get_header();

$id_blog_main_page = get_option('page_for_posts');

while(have_rows('general')){
	the_row();
	$image               = get_sub_field('image');
	$border_rounded      = '';
	$text_style_general  = get_sub_field('text_style_general');
	$image_style_general = get_sub_field('image_style_general');
	$title_width = '';
	if( 'full-width' === $text_style_general ){
		$title_width = 'title-full-width';
	}
	if(get_sub_field('image_border_rounded')){
		$border_rounded = 'border-rounded';
	}
	?>
	<section class="module module-cover-single-post text-<?=$text_style_general?>">
		<div class="title-container">
			<p class="breadcrumb-container font-p font-bold font-color-green">
				<a class="font-bold" href="<?=get_permalink($id_blog_main_page)?>"><?=get_the_title($id_blog_main_page)?></a>
				<?php
				if(get_field('cpt_posts', 'option')['show_date']){
					?>
			 		| <span class="font-uppercase font-bold"><?=get_the_date('j F Y')?></span></p>
					<?php
				}
				?>
			<h1 class="title font-h1 font-regular <?=$title_width?>"><?=get_the_title()?></h1>
		</div>
	</section>
	<section class="module-image image-<?=$image_style_general?>">
		<div class="image-container <?=$border_rounded?>">
			<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
		</div>
	</section>
	<section class="module-description text-<?=$text_style_general?>">
		<p class="text font-p font-color-gray"><?=get_sub_field('short_description')?></p>
	</section>
	<?php
}
?>

<div class="post-content">
	<?php
	while(have_rows('content')){
		the_row();
		$info_c = jg_get_info_background_color();
		$text_style = get_sub_field('text_style');
		$image_style = get_sub_field('image_style');
		$title_width = '';
		if( 'full-width' === $text_style_general ){
			$title_width = 'title-full-width';
		}
		?>
		<section class="module module-content text-<?=$text_style?> image-<?=$image_style?> background-<?=$info_c['color']?> font-color-<?=$info_c['font_color']?>"  <?=$info_c['other_color_style']?>>
			<?php
			$title = get_sub_field('title');
			if(!empty($title)){
				$title_size = get_sub_field('title_size');
				?>
				<h2 class="title font-h1 size-<?=$title_size?> <?=$title_width?>"><?=$title?></h2>
				<?php
			}
			?>
			<div class="short-text font-p"><?=get_sub_field('short_description')?></div>
			<div class="text font-p"><?=get_sub_field('text')?></div>
			<?php
			if($image_style !== 'none'){
				$image = get_sub_field('image');
				$border_rounded = '';
				if(get_sub_field('image_border_rounded')){
					$border_rounded = 'border-rounded';
				}
				?>
				<div class="image-container <?=$border_rounded?>">
					<img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image">
				</div>
				<?php
			}
			?>
		</section>
		<?php
	}
	?>
</div>

<!-- TBS Added - Author Section -->
<?php
$post_author_id = get_the_author_meta('ID');
$post_author_display_name = get_the_author_meta('display_name', $post_author_id);
$post_author_bio = get_the_author_meta('description', $post_author_id);
$post_author_avatar = get_avatar_url($post_author_id, ['size' => 350]);
$post_author_job_position = get_the_author_meta('user_job_position');

// Social links 
$linkedin_link = get_the_author_meta('linkedin', $post_author_id);
$twitter_link = get_the_author_meta('twitter', $post_author_id);
$facebook_link = get_the_author_meta('facebook', $post_author_id);
$instagram_link = get_the_author_meta('instagram', $post_author_id);
?>
<section class="module module-author background-white">
    <div class="author-container">
        <div class="author-profile">
            <img src="<?php echo esc_url($post_author_avatar); ?>" alt="Profile Picture">
        </div>
        <div class="author-summary">
            <p class="module-title font-h1"><?php echo esc_html($post_author_display_name); ?></p>
			<p class="module-title font-h2"><?php echo esc_html($post_author_job_position); ?></p>
			<?php if ($twitter_link || $facebook_link || $instagram_link || $linkedin_link ) : ?>
            <div class="social-links-container">
				<?php if ($linkedin_link) : ?>
				<a href="<?php echo esc_url($linkedin_link); ?>" class="social-link font-semibold" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-linkedin" style="color:#00D3A8; font-size:20px;"></i></a>
                <?php endif; ?>
                <?php if ($twitter_link) : ?>
                <a href="<?php echo esc_url($twitter_link); ?>" class="social-link font-semibold" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-square-twitter" style="color:#1DA1F2; font-size:20px;"></i></a>
                <?php endif; ?>
                <?php if ($facebook_link) : ?>
                <a href="<?php echo esc_url($facebook_link); ?>" class="social-link font-semibold" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-square-facebook" style="color:#1877F2; font-size:20px;"></i></a>
                <?php endif; ?>
                <?php if ($instagram_link) : ?>
                <a href="<?php echo esc_url($instagram_link); ?>" class="social-link font-semibold" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-square-instagram" style="color:#d62976; font-size:20px;"></i></a>
                <?php endif; ?>
            <?php endif; ?>
			</div>
            <div class="text font-p">
                <p><?php echo esc_html($post_author_bio); ?></p>
            </div>
		</div>
    </div>
</section>

<?php
while(have_rows('share_section')){
	the_row();
	?>
	<section class="module module-share background-green">
		<p class="module-title font-h1"><?=get_sub_field('title')?></p>
		<div class="logos-container">
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?=get_permalink()?>" target="_blank" rel="noopener noreferrer" class="logo"><i class="fa-brands fa-linkedin-in"></i></a>
			<a href="https://twitter.com/intent/tweet?text=<?=get_permalink()?>" target="_blank" rel="noopener noreferrer" class="logo"><i class="fa-brands fa-facebook-f"></i></a>
			<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?=get_permalink()?>" target="_blank" rel="noopener noreferrer" class="logo"><i class="fa-brands fa-twitter"></i></a>
		</div>
	</section>
	<?php
}

while(have_rows('services')){
	the_row();
	$services = get_sub_field('services');
	if(!empty($services)){
		?>
		<section class="module module-related-services">
			<p class="module-title font-h1"><?=get_sub_field('title')?></p>
			<div class="services-container">
				<?php
				foreach ($services as $service) {
					?>
					<a href="<?=get_permalink($service)?>" class="button button-white"><?=get_the_title($service)?></a>
					<?php
				}
				?>
			</div>
		</section>
		<?php
	}
}

while(have_rows('related')){
	the_row();
	?>
	<section class="module module-related-posts background-black font-color-white">
		<p class="module-title font-h1"><?=get_sub_field('title')?></p>
		<div class="posts-container">
			<?php
			$related_posts = get_sub_field('related_posts');
			if(empty($related_posts)){
				$related_posts = [];
			}
			$n_related_posts = count($related_posts);
			if($n_related_posts < 2){
				$more_related_posts = get_posts([
					'numberposts' => 2-$n_related_posts,
					'fields' => 'ids',
					'suppress_filters' => false,
					'exclude' => array_merge($related_posts, [get_post()->ID]),
				]);
				$related_posts = array_merge($related_posts, $more_related_posts);
			}
			foreach ($related_posts as $related_post) {
				while(have_rows('general', $related_post)){
					the_row();
					$image = get_sub_field('image');
					?>
					<div class="post-container">
						<div class="image-container">
							<div class="background-image"><img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="image"></div>
						</div>
						<a href="<?=get_permalink($related_post)?>" class="title font-h3"><?=get_the_title($related_post)?></a>
					</div>
					<?php
				}
			}
			?>
		</div>
	</section>
	<?php
}

while(have_rows('form')){
	the_row();
	jg_print_contact_form();
}


// Footer
get_footer();
