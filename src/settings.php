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

add_action('admin_init', function() use($page_slug) {
	// Register settings so that POST is automatically handled
	register_setting($page_slug, 'hero_headline' );
	register_setting($page_slug, 'hero_description' );

	// Add new section to theme-settings page
	add_settings_section(
		'landing_page',
		'Landing Page',
		function() { echo '<p>Customize the Landing Page.</p>'; },
		$page_slug
	);

	// Add a field to use in our landing_page section
	add_settings_field(
		'hero_headline', // $id
		'Hero Headline', // $title
		'text_input', // $callback
		$page_slug, // $page
		'landing_page', // $section
		['name' => 'hero_headline'] // $args (array for $callback)
	);

	add_settings_field(
		'hero_description',
		'Hero Description',
		'text_input',
		$page_slug,
		'landing_page',
		['name' => 'hero_description']
	);

});
