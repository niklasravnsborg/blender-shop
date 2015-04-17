<?php

if (! class_exists('Timber')) {
	add_action('admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
	});
	return;
}

// remove the admin bar from the front end
add_filter('show_admin_bar', '__return_false');

// add menu to Timber Context
add_filter('timber_context', 'add_to_context');

function add_to_context($data) {
	$data['menu'] = new TimberMenu();
	return $data;
}

include 'settings.php';
