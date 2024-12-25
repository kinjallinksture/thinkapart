<?php

/*
 * Configuración Think Appart
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'General Think Appart',
		'menu_title'	=> 'General Think Appart',
		'menu_slug' 	=> 'config-think-appart',
		'capability'	=> 'manage_options',
		'redirect'		=> false,
		'position'		=> '7',
	));
}
