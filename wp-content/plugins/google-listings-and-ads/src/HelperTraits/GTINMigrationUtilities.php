<?php
declare( strict_types=1 );

namespace Automattic\WooCommerce\GoogleListingsAndAds\HelperTraits;

use Automattic\WooCommerce\GoogleListingsAndAds\Jobs\MigrateGTIN;
use Automattic\WooCommerce\GoogleListingsAndAds\Options\OptionsAwareTrait;
use Automattic\WooCommerce\GoogleListingsAndAds\Options\OptionsInterface;
use Exception;
use WC_Product;

defined( 'ABSPATH' ) || exit;

/**
 * Trait GTINMigrationUtilities
 *
 * @package Automattic\WooCommerce\GoogleListingsAndAds\HelperTraits
 */
trait GTINMigrationUtilities {

	use OptionsAwareTrait;

	/**
	 * Get the version from when the GTIN should be hidden in the Google for WooCommerce tab.
	 *
	 * @return string
	 */
	protected function get_gtin_hidden_version(): string {
		return '2.8.7';
	}

	/**
	 * Get the version from when the GTIN field is available in core.
	 * 9.2 is the version when GTIN field was added in Woo Core.
	 *
	 * @return bool
	 */
	protected function is_gtin_available_in_core(): bool {
		return version_compare( WC_VERSION, '9.2', '>=' ) && method_exists( WC_Product::class, 'get_global_unique_id' );
	}

	/**
	 * If GTIN field should be hidden, this is when initial installed version is after the GTIN migration logic.
	 *
	 * @return bool
	 */
	protected function should_hide_gtin(): bool {
		// Don't hide in case GTIN is not available in core.
		if ( ! $this->is_gtin_available_in_core() ) {
			return false;
		}

		$first_install_version = $this->options()->get( OptionsInterface::INSTALL_VERSION, false );
		return $first_install_version && version_compare( $first_install_version, $this->get_gtin_hidden_version(), '>' );
	}

	/**
	 * Get the status for the migration of GTIN.
	 *
	 * GTIN_MIGRATION_COMPLETED: GTIN is not available on that WC version or the initial version installed after GTIN migration.
	 * GTIN_MIGRATION_READY: GTIN is available in core and on read-only mode in the extension. It's ready for migration.
	 * GTIN_MIGRATION_STARTED: GTIN migration is started
	 * GTIN_MIGRATION_COMPLETED: GTIN Migration is completed
	 *
	 * @return string
	 */
	protected function get_gtin_migration_status(): string {
		// If the current version doesn't show GTIN field or the GTIN field is not available in core.
		if ( ! $this->is_gtin_available_in_core() || $this->should_hide_gtin() ) {
			return MigrateGTIN::GTIN_MIGRATION_UNAVAILABLE;
		}

		return $this->options()->get( OptionsInterface::GTIN_MIGRATION_STATUS, MigrateGTIN::GTIN_MIGRATION_READY );
	}

	/**
	 *
	 * Get the options object.
	 * Notice classes with OptionsAwareTrait only get the options object auto-loaded if
	 * they are registered in the Container class.
	 * If they are instantiated on the fly (like the input fields), then this won't get done.
	 * That's why we need to fetch it from the container in case options field is null.
	 *
	 * @return OptionsInterface
	 */
	protected function options(): OptionsInterface {
		return $this->options ?? woogle_get_container()->get( OptionsInterface::class );
	}

	/**
	 * Prepares the GTIN to be saved.
	 *
	 * @param string $gtin
	 * @return string
	 */
	protected function prepare_gtin( string $gtin ): string {
		return str_replace( '-', '', $gtin );
	}

	/**
	 * Gets the message when the GTIN is invalid.
	 *
	 * @param WC_Product $product
	 * @param string     $gtin
	 * @return string
	 */
	protected function error_gtin_invalid( WC_Product $product, string $gtin ): string {
		return sprintf( 'GTIN [ %s ] has been skipped for Product ID: %s - %s. Invalid GTIN was found.', $gtin, $product->get_id(), $product->get_name() );
	}

	/**
	 * Gets the message when the GTIN is already in the Product Inventory
	 *
	 * @param WC_Product $product
	 * @return string
	 */
	protected function error_gtin_already_set( WC_Product $product ): string {
		return sprintf( 'GTIN has been skipped for Product ID: %s - %s. GTIN was found in Product Inventory tab.', $product->get_id(), $product->get_name() );
	}

	/**
	 * Gets the message when the GTIN is not found.
	 *
	 * @param WC_Product $product
	 * @return string
	 */
	protected function error_gtin_not_found( WC_Product $product ): string {
		return sprintf( 'GTIN has been skipped for Product ID: %s - %s. No GTIN was found', $product->get_id(), $product->get_name() );
	}

	/**
	 * Gets the message when the GTIN had an error when saving.
	 *
	 * @param WC_Product $product
	 * @param string     $gtin
	 * @param Exception  $e
	 *
	 * @return string
	 */
	protected function error_gtin_not_saved( WC_Product $product, string $gtin, Exception $e ): string {
		return sprintf( 'GTIN [ %s ] for Product ID: %s - %s has an error - %s', $gtin, $product->get_id(), $product->get_name(), $e->getMessage() );
	}

	/**
	 * Gets the message when the GTIN is successfully migrated.
	 *
	 * @param WC_Product $product
	 * @param string     $gtin
	 *
	 * @return string
	 */
	protected function successful_migrated_gtin( WC_Product $product, string $gtin ): string {
		return sprintf( 'GTIN [ %s ] has been migrated for Product ID: %s - %s', $gtin, $product->get_id(), $product->get_name() );
	}

	/**
	 * Gets the GTIN value
	 *
	 * @param WC_Product $product The product
	 * @return string|null
	 */
	protected function get_gtin( WC_Product $product ): ?string {
		/**
		 * Filters the value of the GTIN before performing the migration.
		 * This value will be he one that we copy inside the Product Inventory GTIN.
		 */
		return apply_filters( 'woocommerce_gla_gtin_migration_value', $this->attribute_manager->get_value( $product, 'gtin' ), $product );
	}
}
