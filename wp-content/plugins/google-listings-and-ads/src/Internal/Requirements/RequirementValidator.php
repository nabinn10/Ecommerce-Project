<?php
declare( strict_types=1 );

namespace Automattic\WooCommerce\GoogleListingsAndAds\Internal\Requirements;

use Automattic\WooCommerce\GoogleListingsAndAds\Exception\RuntimeExceptionWithMessageFunction;

defined( 'ABSPATH' ) || exit;

/**
 * Class RequirementValidator
 *
 * @package AutomatticWooCommerceGoogleListingsAndAdsInternalRequirements
 */
abstract class RequirementValidator implements RequirementValidatorInterface {

	/**
	 * @var RequirementValidator[]
	 */
	private static $instances = [];

	/**
	 * Get the instance of the RequirementValidator object.
	 *
	 * @return RequirementValidator
	 */
	public static function instance(): RequirementValidator {
		$class = get_called_class();
		if ( ! isset( self::$instances[ $class ] ) ) {
			self::$instances[ $class ] = new $class();
		}
		return self::$instances[ $class ];
	}


	/**
	 * Add a standard requirement validation error notice.
	 *
	 * @param RuntimeExceptionWithMessageFunction $e
	 */
	protected function add_admin_notice( RuntimeExceptionWithMessageFunction $e ) {
		// Display notice error message.
		add_action(
			'admin_notices',
			function () use ( $e ) {
				echo '<div class="notice notice-error">' . PHP_EOL;
				echo '	<p>' . esc_html( $e->get_formatted_message() ) . '</p>' . PHP_EOL;
				echo '</div>' . PHP_EOL;
			}
		);
	}
}
