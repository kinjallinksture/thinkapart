		<footer class="footer-container background-black font-color-white">
			<div class="logo-container">
				<img src="<?=get_template_directory_uri()?>/assets/svg/logo.svg" alt="" class="logo">
				<?php
					while(have_rows('footer', 'option')){
						the_row();
						$footer_short_description = get_sub_field( 'footer_short_description' );
						?>
							<h2 class="module-title font-h2"><?=get_sub_field('under_logo_text')?></h2>
						<?php
						if ( ! empty( $footer_short_description ) ) {
							?>
							<p><?php echo esc_html( $footer_short_description ); ?></p>
							<?php
						}
					}
				?>
			</div>
			<div class="columns-container">
				<!-- Jump To Section -->
				<div class="column column-jump-to font-p">
					<p class="column-title font-semibold"></p>
					<?php
					while(have_rows('jump_to_section', 'option')){
						the_row();
						?>
						<div class="location-container">
							<p class="city font-semibold"><?=get_sub_field('title')?></p>
							<div class="jump-to-menu">
							<?php
								while(have_rows('links', 'option')){
									the_row();
							?>
								<a href="<?=get_sub_field('menu_page_link')?>" class="address-link" rel="noopener noreferrer"><?=get_sub_field('menu_page_text')?></a>
							<?php 
								}
							?>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<!-- Services Section -->
				<div class="column column-services font-p">
					<p class="column-title font-semibold"></p>
					<?php
					while(have_rows('services_section', 'option')){
						the_row();
						?>
						<div class="location-container">
							<p class="city font-semibold"><?=get_sub_field('title')?></p>
							<div class="jump-to-menu">
							<?php
								while(have_rows('links', 'option')){
									the_row();
							?>
								<a href="<?=get_sub_field('menu_page_link')?>" class="address-link" rel="noopener noreferrer"><?=get_sub_field('menu_page_text')?></a>
							<?php 
								}
							?>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<!-- Location Section -->
				<div class="column column-location font-p">
					<p class="column-title font-semibold"></p>
					<p class="column-title font-semibold only-mobile"><?=get_field('location','option')?></p>
					<?php
					while(have_rows('offices', 'option')){
						the_row();
						?>
						<div class="location-container">
							<p class="city font-semibold"><?=get_sub_field('city')?></p>
							<a href="<?=get_sub_field('address_link')?>" class="address-link" target="_blank" rel="noopener noreferrer"><?=get_sub_field('address')?></a>
						</div>
						<?php
					}
					?>
				</div>
				<div class="column column-contact font-p">
					<?php
					while(have_rows('footer', 'option')){
						the_row();
						$footer_email = get_sub_field('email');
						?>
						<p class="column-title font-semibold font-h3-mobile"><?=get_sub_field('contact_title')?></p>
						<a href="<?=get_permalink(get_sub_field('contact_page'))?>" class="contact-link font-claim font-color-green"><?=get_sub_field('contact_link_text')?></a>
						<?php
					}
					?>
					<div class="social-links-container">
						<?php
						while(have_rows('social_networks', 'option')){
							the_row();
							?>
							<a href="<?=get_sub_field('link')?>" class="social-link font-semibold" target="_blank" rel="noopener noreferrer"><?=get_sub_field('text')?></a>
							<?php
						}
						?>
					</div>
					<a href="mailto:<?=$footer_email?>" class="mail-link font-color-green font-medium only-mobile"><?=$footer_email?></a>
					<div class="language-container only-desktop">
						<p class="title font-semibold"><?=__('Language', 'think-appart')?></p>
						<?php
						$languages = apply_filters('wpml_active_languages', []);
						foreach ($languages as $lang_code => $lang) {
							$active = '';
							if($lang['active']){
								$active = 'active';
							}
							?>
							<a href="<?=$lang['url']?>" class="<?=$active?>"><?=$lang['native_name']?></a>
							<?php
						}
						?>
					</div>
				</div>
				<div class="column font-p only-mobile">
					<div class="language-container layout-<?=get_field('footer', 'option')['layout_languages_on_mobile']?>">
						<p class="title font-semibold"><?=__('Language', 'think-appart')?></p>
						<?php
						foreach ($languages as $lang_code => $lang) {
							$active = '';
							if($lang['active']){
								$active = 'active';
							}
							?>
							<a href="<?=$lang['url']?>" class="<?=$active?>"><?=$lang['native_name']?></a>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			<div class="legal-info font-p">
				<p class="legal-text font-medium">© <?=date('Y')?> Appart_. All rights reserved</p>
				<a href="mailto:<?=$footer_email?>" class="mail-link font-color-green font-medium only-desktop"><?=$footer_email?></a>
			</div>
		</footer>


		<?php wp_footer(); ?>
	</body>
</html>

