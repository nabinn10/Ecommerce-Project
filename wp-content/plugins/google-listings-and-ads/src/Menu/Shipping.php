<?php
declare( strict_types=1 );

namespace Automattic\WooCommerce\GoogleListingsAndAds\Menu;

use Automattic\WooCommerce\GoogleListingsAndAds\Infrastructure\Registerable;
use Automattic\WooCommerce\GoogleListingsAndAds\Infrastructure\Service;

/**
 * Class Shipping
 *
 * @package Automattic\WooCommerce\GoogleListingsAndAds\Menu
 */
class Shipping implements Service, Registerable {

	/**
	 * Register a service.
	 */
	public function register(): void {
		add_action(
			'admin_menu',
			function () {
				wc_admin_register_page(
					[
						'id'     => 'google-shipping',
						'parent' => 'google-listings-and-ads-category',
						'title'  => __( 'Shipping', 'google-listings-and-ads' ),
						'path'   => '/google/shipping',
					]
				);
			}
		);
	}
}
