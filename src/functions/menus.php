<?php

// add header_menu to Wordpress
add_action('init', function() {
	register_nav_menu('header_menu', __( 'Header Menu' ));
});

// add header_menu to Timber Context
add_filter('timber_context', function($data) {
	$data['header_menu'] = new TimberMenu('header_menu');
	return $data;
});

// add footer_menu to Wordpress
add_action('init', function() {
	register_nav_menu('footer_menu', __( 'Footer Menu' ));
});

// add footer_menu to Timber Context
add_filter('timber_context', function($data) {
	$data['footer_menu'] = new TimberMenu('footer_menu');
	return $data;
});
