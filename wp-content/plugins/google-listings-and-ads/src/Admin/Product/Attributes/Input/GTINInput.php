<?php
declare( strict_types=1 );

namespace Automattic\WooCommerce\GoogleListingsAndAds\Admin\Product\Attributes\Input;

use Automattic\WooCommerce\GoogleListingsAndAds\Admin\Input\Text;
use Automattic\WooCommerce\GoogleListingsAndAds\HelperTraits\GTINMigrationUtilities;

defined( 'ABSPATH' ) || exit;

/**
 * Class GTIN
 *
 * @package Automattic\WooCommerce\GoogleListingsAndAds\Product\Attributes
 *
 * @since 1.5.0
 */
class GTINInput extends Text {

	use GTINMigrationUtilities;

	/**
	 * GTINInput constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->set_label( __( 'Global Trade Item Number (GTIN)', 'google-listings-and-ads' ) );
		$this->set_description( __( 'Global Trade Item Number (GTIN) for your item. These identifiers include UPC (in North America), EAN (in Europe), JAN (in Japan), and ISBN (for books)', 'google-listings-and-ads' ) );
		$this->set_field_visibility();
	}

	/**
	 * Controls the inputs visibility based on the WooCommerce version and the
	 * initial version of Google for WooCommerce at the time of installation.
	 *
	 * @since 2.9.0
	 * @return void
	 */
	public function set_field_visibility(): void {
		if ( $this->is_gtin_available_in_core() ) {
			// For versions after the GTIN changes are published. Hide the GTIN field from G4W tab. Otherwise, set as readonly.
			if ( $this->should_hide_gtin() ) {
				$this->set_hidden( true );
			} else {
				$this->set_readonly( true );
				$this->set_description( __( 'The Global Trade Item Number (GTIN) for your item can now be entered on the "Inventory" tab', 'google-listings-and-ads' ) );
			}
		}
	}
}
