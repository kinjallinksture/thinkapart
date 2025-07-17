<?php

define('THINK_APPART_THEME_VERSION', '1.0.0');

/*
 * Funciones extras para el tema Openers & Closers
 */
include 'includes/config.php';
//include 'includes/duplicate-posts.php';

add_action( 'init', function() {
	if(function_exists('get_field') && get_field('customizar_menu_wordpress', 'option')){
		include 'includes/custom-wp.php';
	}
});

add_filter('upload_mimes', 'jg_custom_upload_mimes');
function jg_custom_upload_mimes($mimes = array()) {
	// Add a key and value for the SVG file type
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

/*
 * Registramos los menús para nuestro tema
 */
add_action( 'init', 'registrar_menus' );
function registrar_menus() {
	register_nav_menus(
		array(
			'menu-principal' => __( 'Primary menu' ),
			'menu-secundario' => __( 'Secondary menu' )
		)
	);
}

function get_menu_items($menu_location){
	$locations = get_nav_menu_locations();
	$menu = get_term( $locations[$menu_location], 'nav_menu' );
	return wp_get_nav_menu_items($menu->term_id);
}

add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );
function add_menu_link_class( $atts, $item, $args ) {
	if (property_exists($args, 'link_class')) {
		$atts['class'] = $args->link_class;
	}
	return $atts;
}

/*
 * Añade JS y CSS al tema
 */
add_action('wp_enqueue_scripts', 'registrar_jscss');
function registrar_jscss(){
	
	/*
	 * Añadimos las hojas de estilos
	 */
	wp_enqueue_style('think-appart-style', get_template_directory_uri().'/css/style.css', array(), THINK_APPART_THEME_VERSION);
	wp_enqueue_style('swiper-style', get_template_directory_uri().'/css/lib/swiper-bundle.min.css', array(), THINK_APPART_THEME_VERSION);
	/*
	 * Añadimos los archivos JavaScript
	 */
	wp_enqueue_script('jqueryjs', get_template_directory_uri().'/js/lib/jquery-3.6.0.min.js', array(), THINK_APPART_THEME_VERSION);
	wp_enqueue_script('gsap', get_template_directory_uri().'/js/lib/gsap.min.js', array(), THINK_APPART_THEME_VERSION);
	wp_enqueue_script('scrollmagic', get_template_directory_uri().'/js/lib/ScrollMagic.min.js', array(), THINK_APPART_THEME_VERSION);
	wp_enqueue_script('scrollmagic-gsap', get_template_directory_uri().'/js/lib/animation.gsap.js', array(), THINK_APPART_THEME_VERSION);
	wp_enqueue_script('swiper', get_template_directory_uri().'/js/lib/swiper-bundle.min.js', array(), THINK_APPART_THEME_VERSION);
	wp_enqueue_script('typed', get_template_directory_uri().'/js/lib/typed.js', array(), THINK_APPART_THEME_VERSION);
	wp_enqueue_script('scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js', array(), THINK_APPART_THEME_VERSION);
	wp_enqueue_script('think-appart-scrollanimation-js', get_template_directory_uri().'/js/scrollAnimation.js', array(), THINK_APPART_THEME_VERSION);
	wp_enqueue_script('think-appart-main-js', get_template_directory_uri().'/js/main.js', array(), THINK_APPART_THEME_VERSION);
}


add_action( 'wp_ajax_nopriv_newsletter', 'jg_newsletter');
add_action( 'wp_ajax_newsletter', 'jg_newsletter');
function jg_newsletter(){
	if(empty($_POST['email'])){
		$response = ['status' => 'error', 'message' => 'Required email.'];
	}else{
		$response =  jg_add_subscriber_list($_POST['email']);
	}
    echo json_encode($response);
    wp_die();
}

function jg_icon_play($extra_class = ''){
	?>
	<svg class="icon-play <?=$extra_class?>" width="122" height="122" viewBox="0 0 122 122" fill="none" xmlns="http://www.w3.org/2000/svg">
		<circle class="circle" cx="61" cy="61" r="61"/>
		<path class="play" d="M86 61L48.5 82.6506L48.5 39.3494L86 61Z"/>
	</svg>
	<?php
}

function jg_icon_pause($extra_class = ''){
	?>
	<div class="icon-pause <?=$extra_class?>"></div>
	<?php
}

function jg_icon_volume($extra_class = ''){
	?>
	<div class="icon-volume <?=$extra_class?>">
		<div class="volume-bar"></div>
		<div class="volume-bar"></div>
		<div class="volume-bar"></div>
		<div class="volume-bar"></div>		
	</div>
	<?php
}

function jg_icon_plus($extra_class = ''){
	?>
	<svg class="icon-plus <?=$extra_class?>" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
		<line x1="15.5" y1="6.55671e-08" x2="15.5" y2="30" stroke-width="3"/>
		<line y1="15.5" x2="30" y2="15.5" stroke-width="3"/>
	</svg>
	<?php
}

function jg_icon_phone($extra_class = ''){
	return '
	<svg class="phone '.$extra_class.'" viewBox="0 0 23 18" xmlns="http://www.w3.org/2000/svg">
		<path d="M19.512 14.3968C18.5739 16.5793 16.3744 16.962 15.6558 16.962C15.4449 16.962 12.1579 17.1313 7.43334 12.7813C3.63112 9.27982 3.16652 5.51686 3.1261 4.80126C3.08667 4.1048 3.29203 2.35726 5.76913 1.05872C6.07602 0.897675 6.68453 0.826561 6.84159 0.978993C6.91125 1.04692 8.99044 4.36693 9.04499 4.47695C9.09746 4.57757 9.12555 4.6885 9.12713 4.80126C9.12713 4.95284 9.01575 5.14237 8.79297 5.36985C8.56957 5.59796 8.32653 5.80717 8.0665 5.9952C7.8105 6.18007 7.56767 6.38154 7.3397 6.59823C7.11693 6.81083 7.00554 6.98516 7.00554 7.12122C7.02066 7.47551 7.31966 8.74407 9.59732 10.6861C11.875 12.6282 12.9727 13.1764 13.0802 13.2143C13.1638 13.2476 13.2527 13.2667 13.343 13.2708C13.4837 13.2708 13.6634 13.1628 13.8822 12.9468C14.1007 12.7306 14.8351 11.7525 15.0707 11.5363C15.3062 11.3201 15.5008 11.2123 15.6568 11.2123C15.7729 11.2137 15.8871 11.2409 15.9907 11.2917C16.104 11.3447 19.5294 13.2902 19.5951 13.3553C19.7728 13.5323 19.6473 14.084 19.5129 14.3965"/>
	</svg>';
}

function jg_icon_copy($extra_class = ''){
	return '<svg class="svg-copy '.$extra_class.'" width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
		<rect class="stroke" x="5.20703" y="0.5" width="15.1386" height="16.922" rx="2.5"/>
		<rect class="stroke fill" x="1.12891" y="4.57788" width="15.1386" height="16.922" rx="2.5"/>
	</svg>';
}

function jg_print_contact_form($extra_class = ''){
	$general = get_sub_field('use_general_form');
	if($general){
		while(have_rows('general_contact_form', 'option')){
			the_row();
			jg_print_contact_form_private($extra_class);
		}
	}else{
		jg_print_contact_form_private($extra_class);
	}
}

function jg_print_contact_form_private($extra_class){
	?>
	<section class="module module-form <?=$extra_class?>">
		<div class="title-container typed-container font-h1">
			<div class="typed-text-hidden">
				<?php
				while(have_rows('texts')){
					the_row();
					?>
					<p><?=get_sub_field('text')?></p>
					<?php
				}
				?>
			</div>
			<p class="typed"></p>
		</div>
		<?=do_shortcode(get_sub_field('shortcode_form'))?>
	</section>
	<?php
}

function jg_get_info_background_color($prefix = ''){
	if(!empty($prefix)){
		$prefix .= '_';
	}
	$color = get_sub_field($prefix . 'background_color');
	$other_background_color = '';
	$other_text_color = '';
	$other_color_style = 'style="';
	if($color == 'other'){
		$other_background_color = '--other-bg-color: #'.get_sub_field($prefix . 'other_background_color');
		$other_color_style .= $other_background_color . '; ';
	}
	$font_color = get_sub_field($prefix . 'text_color');
	if(empty($font_color)){
		$font_color = 'white';
		if($color == 'yellow' || $color == 'white'){
			$font_color = 'black';
		}
	}
	if($font_color == 'other'){
		$other_text_color = '--other-color: #'.get_sub_field($prefix . 'other_text_color');
		$other_color_style .= $other_text_color . '; ';
	}
	$other_color_style .= '"';
	return [
		'color' => $color,
		'font_color' => $font_color,
		'other_background_color' => $other_background_color,
		'other_text_color' => $other_text_color,
		'other_color_style' => $other_color_style,
	];
}

function change_color_to_hex($color){
	if($color == 'black'){
		$color = '#181818';
	}elseif($color == 'green'){
		$color = '#00D3A8';
	}elseif($color == 'blue'){
		$color = '#2E5DFF';
	}elseif($color == 'yellow'){
		$color = '#F6F459';
	}elseif($color == 'white'){
		$color = '#FFFFFF';
	}
	return $color;
}

function jg_change_background_color_to_hex($background){
	if($background['color'] == 'other'){
		$background['color'] = '#'.$background['other_color'];
	}else{
		$background['color'] = change_color_to_hex($background['color']);
	}
	$background['font_color'] = change_color_to_hex($background['font_color']);
	return $background;
}

/* 
Added by TBS
*/
// Add filter dropdown for 'se_category' taxonomy in 'services' post type admin page
add_action('restrict_manage_posts', 'add_services_category_filter');
function add_services_category_filter() {
    global $typenow;
    // Check if we are on the 'services' post type page
    if ($typenow == 'services') {
        $taxonomy = 'se_category';
        $selected = isset($_GET['se_category']) ? $_GET['se_category'] : '';
        $args = array(
            'show_option_all' => __('All Categories', 'textdomain'),
            'taxonomy'        => $taxonomy,
            'name'            => 'se_category',
            'orderby'         => 'name',
            'selected'        => $selected,
            'show_count'      => true,
            'hide_empty'      => true,
            'hierarchical'    => true, 
            'value_field'     => 'slug', 
        );
        wp_dropdown_categories($args);
    }
}

// Filter 'services' posts by 'se_category' taxonomy in admin
add_filter('parse_query', 'filter_services_by_se_category');
function filter_services_by_se_category($query) {
    global $pagenow;
    $post_type = 'services';
    $taxonomy = 'se_category';

    if (is_admin() && $pagenow=='edit.php' && isset($_GET['se_category']) && $_GET['se_category'] != '') {
        $term_slug = $_GET['se_category'];
        $term = get_term_by('slug', $term_slug, $taxonomy);
        if ($term) {
            $query->query_vars['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => $term_slug
                )
            );
        }
    }
}

// Add filter dropdown for 'la_category' taxonomy in 'landings' post type admin page
add_action('restrict_manage_posts', 'add_landings_category_filter');
function add_landings_category_filter() {
    global $typenow;
    
    if ($typenow == 'landings') {
        $taxonomy = 'la_category';
        $selected = isset($_GET['la_category']) ? $_GET['la_category'] : '';
        $args = array(
            'show_option_all' => __('All Categories', 'textdomain'),
            'taxonomy'        => $taxonomy,
            'name'            => 'la_category',
            'orderby'         => 'name',
            'selected'        => $selected,
            'show_count'      => true,
            'hide_empty'      => true,
            'hierarchical'    => true, 
            'value_field'     => 'slug',
        );
        wp_dropdown_categories($args);
    }
}

// Filter 'landings' posts by 'la_category' taxonomy in admin
add_filter('parse_query', 'filter_landings_by_la_category');
function filter_landings_by_la_category($query) {
    global $pagenow;
    $post_type = 'landings';
    $taxonomy = 'la_category';

    if (is_admin() && $pagenow=='edit.php' && isset($_GET['la_category']) && $_GET['la_category'] != '') {
        $term_slug = $_GET['la_category'];
        $term = get_term_by('slug', $term_slug, $taxonomy);
        if ($term) {
            $query->query_vars['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => $term_slug
                )
            );
        }
    }
}
