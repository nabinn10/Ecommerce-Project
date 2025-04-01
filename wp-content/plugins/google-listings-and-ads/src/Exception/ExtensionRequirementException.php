<?php
declare( strict_types=1 );

namespace Automattic\WooCommerce\GoogleListingsAndAds\Exception;

defined( 'ABSPATH' ) || exit;

/**
 * Class ExtensionRequirementException
 *
 * Error messages generated in this class should be translated, as they are intended to be displayed
 * to end users. We pass the translated message as a function so they are only translated when shown.
 * This prevents translation functions to be called before init which is not allowed in WP 6.7+.
 *
 * @package Automattic\WooCommerce\GoogleListingsAndAds\Exception
 */
class ExtensionRequirementException extends RuntimeExceptionWithMessageFunction implements GoogleListingsAndAdsException {

	/**
	 * Create a new instance of the exception when a required plugin/extension isn't activated.
	 *
	 * @param string $plugin_name The name of the missing required plugin.
	 *
	 * @return static
	 */
	public static function missing_required_plugin( string $plugin_name ): ExtensionRequirementException {
		return new static(
			sprintf(
				'Google for WooCommerce requires %1$s to be enabled.', // Fallback exception message.
				$plugin_name
			),
			0,
			null,
			fn () => sprintf(
				/* translators: 1 the missing plugin name */
				__( 'Google for WooCommerce requires %1$s to be enabled.', 'google-listings-and-ads' ),
				$plugin_name
			)
		);
	}

	/**
	 * Create a new instance of the exception when an incompatible plugin/extension is activated.
	 *
	 * @param string $plugin_name The name of the incompatible plugin.
	 *
	 * @return static
	 */
	public static function incompatible_plugin( string $plugin_name ): ExtensionRequirementException {
		return new static(
			sprintf(
				'Google for WooCommerce is incompatible with %1$s.', // Fallback exception message.
				$plugin_name
			),
			0,
			null,
			fn () => sprintf(
				/* translators: 1 the incompatible plugin name */
				__( 'Google for WooCommerce is incompatible with %1$s.', 'google-listings-and-ads' ),
				$plugin_name
			)
		);
	}
}
