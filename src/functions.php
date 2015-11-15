<?php

if (! class_exists('Timber')) {
	add_action('admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
	});
	return;
}

// remove the admin bar from the front end
add_filter('show_admin_bar', '__return_false');

// WooCommerce support
add_action('after_setup_theme', function () {
	add_theme_support('woocommerce');
});

// form validation
add_action('wp_nonce_field', function ($action) {
	wp_nonce_field($action);
});

// INCLUDES
include 'functions/menus.php'; // Menus
include 'functions/settings.php'; // Settings Page
