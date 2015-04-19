<?php

if (! class_exists('Timber')) {
	add_action('admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
	});
	return;
}

// remove the admin bar from the front end
add_filter('show_admin_bar', '__return_false');

// add footer_menu to Wordpress
add_action('init', function() {
	register_nav_menu('footer_menu', __( 'Footer Menu' ));
});

// add footer_menu to Timber Context
add_filter('timber_context', function($data) {
	$data['footer_menu'] = new TimberMenu('footer_menu');
	return $data;
});

// Settings Page
include 'settings.php';
