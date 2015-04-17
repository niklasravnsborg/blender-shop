<?php

$page_slug = 'theme-settings';
$title = 'Theme Settings';

function text_input($input) {
	$name = $input['name'];

	echo '<input
		class="regular-text"
		name="' . $name .'"
		type="text"
		value="' . get_option($name) . '"'
	. '>';
}

add_action('admin_menu', function() use($page_slug, $title) {
	add_options_page(
		$title, // title on page
		$title, // title in menu
		'manage_options', // permissions to edit
		$page_slug, // page
		function() use($page_slug) {

			$data['title']   = $title;
			$data['fields']  = TimberHelper::function_wrapper('settings_fields', array($page_slug));
			$data['section'] = TimberHelper::function_wrapper('do_settings_sections', array($page_slug));
			$data['submit']  = TimberHelper::function_wrapper('submit_button');
			Timber::render('templates/layouts/settings.twig', $data);

		}
	);
});
