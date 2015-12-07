<?php

$context = Timber::get_context();

// WooCommerce Notices
$context['wc_notices'] = wc_get_notices();
wc_clear_notices();

if (is_cart()) {

	foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
		$_product   = apply_filters('woocommerce_cart_item_product',    $cart_item['data'],       $cart_item, $cart_item_key);
		$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
		$quantity = false;

		if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
			if (!$_product->is_sold_individually()) {
				$quantity = [
					'name'  => "cart[{$cart_item_key}][qty]",
					'value' => $cart_item['quantity'],
					'min'   => '0',
					'max'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity()
				];
			}
		}

		$cart_products[] = [
			'title'     => apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key),
			'remove_url' => WC()->cart->get_remove_url($cart_item_key),
			'price'     => apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key),
			'quantity'  => $quantity,
			'subtotal'  => apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key)
		];
	}

	$context['cart_empty'] = WC()->cart->is_empty();
	$context['action'] = WC()->cart->get_cart_url();
	$context['shop_url'] = wc_get_page_permalink('shop');
	$context['checkout_url'] = WC()->cart->get_checkout_url();
	$context['cart_products'] = $cart_products;

	Timber::render('templates/layouts/cart.twig', $context);

} elseif (is_checkout()) {

	$context['is_user_logged_in'] = is_user_logged_in();
	$context['woocommerce_create_account_default_checked'] = apply_filters('woocommerce_create_account_default_checked', false);
	$context['checkout_url'] = $get_checkout_url;
	$context['checkout'] = WC()->checkout();
	$context['cart'] = WC()->cart;

	Timber::render('templates/layouts/checkout.twig', $context);

} else {
	$post = new TimberPost();
	$context['post'] = $post;
	Timber::render('templates/layouts/singular.twig', $context);
}
