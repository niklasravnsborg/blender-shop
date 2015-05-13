<?php

if (!class_exists('Timber')){
	echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
	return;
}

function archive_loop() {
	while (have_posts()) {
		the_post();
		$product = new WC_Product(get_the_ID());
		$context['title']      = get_the_title();
		$context['link']       = get_permalink();
		$context['thumbnail']  = wp_get_attachment_url(get_post_thumbnail_id());
		$context['price']      = $product->get_price_html();
		Timber::render('templates/components/products.twig', $context);
	}
}

if (is_singular('product')) {
	$context = Timber::get_context();
	Timber::render('templates/layouts/woocommerce.twig', $context);

} else {
	$context = Timber::get_context();
	Timber::render('templates/layouts/commerce_archive.twig', $context);

}
