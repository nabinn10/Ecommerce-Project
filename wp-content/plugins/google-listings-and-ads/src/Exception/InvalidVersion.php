<?php
declare( strict_types=1 );

namespace Automattic\WooCommerce\GoogleListingsAndAds\Exception;

defined( 'ABSPATH' ) || exit;

/**
 * Class InvalidVersion
 *
 * Error messages generated in this class should be translated, as they are intended to be displayed
 * to end users. We pass the translated message as a function so they are only translated when shown.
 * This prevents translation functions to be called before init which is not allowed in WP 6.7+.
 *
 * @package Automattic\WooCommerce\GoogleListingsAndAds\Exception
 */
class InvalidVersion extends RuntimeExceptionWithMessageFunction implements GoogleListingsAndAdsException {

	/**
	 * Create a new instance of the exception when an invalid version is detected.
	 *
	 * @param string $requirement
	 * @param string $found_version
	 * @param string $minimum_version
	 *
	 * @return static
	 */
	public static function from_requirement( string $requirement, string $found_version, string $minimum_version ): InvalidVersion {
		return new static(
			sprintf(
				'Google for WooCommerce requires %1$s version %2$s or higher. You are using version %3$s.', // Fallback exception message.
				$requirement,
				$minimum_version,
				$found_version
			),
			0,
			null,
			fn () => sprintf(
				/* translators: 1 is the required component, 2 is the minimum required version, 3 is the version in use on the site */
				__( 'Google for WooCommerce requires %1$s version %2$s or higher. You are using version %3$s.', 'google-listings-and-ads' ),
				$requirement,
				$minimum_version,
				$found_version
			)
		);
	}

	/**
	 * Create a new instance of the exception when a requirement is missing.
	 *
	 * @param string $requirement
	 * @param string $minimum_version
	 *
	 * @return InvalidVersion
	 */
	public static function requirement_missing( string $requirement, string $minimum_version ): InvalidVersion {
		return new static(
			sprintf(
				'Google for WooCommerce requires %1$s version %2$s or higher.', // Fallback exception message.
				$requirement,
				$minimum_version
			),
			0,
			null,
			fn () => sprintf(
				/* translators: 1 is the required component, 2 is the minimum required version */
				__( 'Google for WooCommerce requires %1$s version %2$s or higher.', 'google-listings-and-ads' ),
				$requirement,
				$minimum_version
			)
		);
	}

	/**
	 * Create a new instance of the exception when an invalid architecture is detected.
	 *
	 * @since 2.3.9
	 * @return InvalidVersion
	 */
	public static function invalid_architecture(): InvalidVersion {
		return new static(
			'Google for WooCommerce requires a 64 bit version of PHP.', // Fallback exception message.
			0,
			null,
			fn () => __( 'Google for WooCommerce requires a 64 bit version of PHP.', 'google-listings-and-ads' )
		);
	}
}
