<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<?php if(is_front_page()){ ?>
			<title><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
		<?php }else{ ?>
			<title><?php wp_title(' | ', 'echo', 'right'); ?><?php bloginfo('name'); ?></title>
		<?php } ?>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php wp_head(); ?>
		<script>var ajaxurl = "<?=admin_url('admin-ajax.php')?>";</script>

		<link rel="shortcut icon" href="<?=get_template_directory_uri()?>/assets/fav/favicon.ico">

		<!-- TBS Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-NRZFJ4X');</script>
		<!-- End Google Tag Manager -->
		
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-PPDLGHG');</script>
				<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6174049154669019"
		     crossorigin="anonymous"></script>
		<!-- End Google Tag Manager -->
		        
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-54996752-2"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-54996752-2');
		</script>
        <meta name="google-site-verification" content="rWIXq9nFLjKv-ykW7u8sUqH_akxaF7vojOAMy8dmFrM" />
		
		<script src="https://kit.fontawesome.com/2af2fe346b.js" crossorigin="anonymous"></script>
	</head>
	<body <?php body_class(isset($class) ? $class : ''); ?>>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PPDLGHG"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		
		<!-- TBS Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NRZFJ4X"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		
		<header class="header-container">
			<a href="<?=home_url()?>" class="logo-container">
				<img src="<?=get_template_directory_uri()?>/assets/svg/logo-blink.svg" alt="" class="logo">
			</a>
			<?php
			if(!get_field('hide_full_menu')){
				?>
				<nav class="nav-container" role="navigation">
					<ul class="menu-container">
						<?php
						$current_page = get_post()->ID;
						$menu_items = get_menu_items('menu-principal');
						$id_blog_main_page = get_option('page_for_posts');
						foreach ($menu_items as $menu_item) {
							$button_class = '';
							$phone_svg = '';
							$current = '';

							if($menu_item->object_id == $current_page){
								$current = 'current';
							}elseif(is_home() && $menu_item->object_id == $id_blog_main_page){
								$current = 'current';
							}
							
							$page_title = get_the_title();
							if ($page_title == 'Services' || $page_title == 'บริการของเรา' || $page_title == 'Servicios') {
								$tbs = 'tbs-active';
							}
							
							if(get_field('phone_number', $menu_item)){
								$current .= ' only-desktop';
								$button_class .= ' phone-number';
								$phone_svg = jg_icon_phone('fill-black');
							}
						
							?>
							<li class="menu-item <?= $current === 'current' && ($menu_item->title != 'Services' && $menu_item->title != 'บริการของเรา' && $menu_item->title != 'Servicios') ? 'current' : '' ?> <?php if ($menu_item->title == 'Services' || $menu_item->title == 'บริการของเรา' || $menu_item->title == 'Servicios') echo 'service-nav-item'; ?> <?= get_field('phone_number', $menu_item) ? 'only-desktop' : ''; ?>">
								<a href="<?=$menu_item->url?>" class="button button-small button-<?=get_field('button_color', $menu_item)?> <?=$button_class?> <?=$tbs?>">
									<?=$phone_svg?>
									<p class="text"><?=$menu_item->title?></p>
								</a>
								<?php if ($menu_item->title == 'Services' || $menu_item->title == 'บริการของเรา' || $menu_item->title == 'Servicios' ) : ?>
									<nav class="only-mobile open-sub-menu" role="navigation">
										<button aria-expanded="true" class="sub-service-button"><i class="fa-solid fa-chevron-right sub-service-mobile"></i></button>
									</nav>
								<?php endif; ?>
								<!-- MEGA MENU -->
								<?php if ($menu_item->title == 'Services' || $menu_item->title == 'บริการของเรา' || $menu_item->title == 'Servicios' ) : ?>
								<div class="mega_menu_content only-desktop">
									<?php
										while(have_rows('mega_menu_content', 'option')){
											the_row();
												$mega_menu_page_link = get_sub_field('menu_link'); 
												$menu_image = get_sub_field('menu_image');
									?>	
										<div class="mega_menu_item"> 
											<img src="<?php echo $menu_image; ?>"/>
											<a href="<?php echo esc_url(get_permalink($mega_menu_page_link->ID)); ?>" class="text" rel="noopener noreferrer"><?php echo esc_html(get_the_title($mega_menu_page_link->ID)); ?></a>
										</div>
										<?php } ?>
								</div>

								<nav class="sub_mega_menu_content only-mobile">
									<div class="return-main-nav">
										<button aria-expanded="true"><i class="fa-solid fa-chevron-left sub-service-mobile"></i></button>
									</div>
									<?php
										while(have_rows('mega_menu_content', 'option')){
											the_row();
												$mega_menu_page_link = get_sub_field('menu_link'); 
												$menu_image = get_sub_field('menu_image');
									?>	
										<div class="sub_mega_menu_item"> 
											<img src="<?php echo $menu_image; ?>"/>
											<a href="<?php echo esc_url(get_permalink($mega_menu_page_link->ID)); ?>" class="text" rel="noopener noreferrer"><?php echo esc_html(get_the_title($mega_menu_page_link->ID)); ?></a>
										</div>
									<?php } ?>
								</nav>
								<!-- END MEGA MENU -->
								<?php endif; ?>
							</li>
							<?php
						}
						?>
					</ul>
					<div class="social-links-container font-color-white only-mobile">
						<?php
						while(have_rows('social_networks', 'option')){
							the_row();
							?>
							<a href="<?=get_sub_field('link')?>" class="social-link font-semibold" target="_blank" rel="noopener noreferrer"><?=get_sub_field('text')?></a>
							<?php
						}
						?>
					</div>
				</nav>
				<?php
			}else{
				while(have_rows('short_menu', 'option')){
					the_row();
					$phone = get_sub_field('phone');
					$email = get_sub_field('email');
					?>
					<div class="nav-container">
						<div class="short-menu-container">
							<a href="tel:<?=$phone?>" class="button button-small button-white phone-number">
								<?=jg_icon_phone('fill-black')?>
								<p class="text"><?=$phone?></p>
							</a>
							<a href="mailto:<?=$email?>" class="button button-small button-black-white">
								<p class="text"><?=$email?></p>
							</a>
						</div>
					</div>
					<?php
				}
			}
			?>
			<div class="menu-mobile-button only-mobile">
				<div class="line"></div>
				<div class="line"></div>
				<div class="line"></div>
			</div>
		</header>

		<?php