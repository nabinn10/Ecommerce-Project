<?php
declare( strict_types=1 );

namespace Automattic\WooCommerce\GoogleListingsAndAds\Exception;

use Exception;
use RuntimeException;
use Throwable;

defined( 'ABSPATH' ) || exit;

/**
 * Class RuntimeExceptionWithMessageFunction
 *
 * The purpose of this Exception type is to be able to throw an exception early,
 * but translate the string late. This is because WP 6.7+ requires translations
 * to happen after the init hook.
 *
 * @package Automattic\WooCommerce\GoogleListingsAndAds\Exception
 */
class RuntimeExceptionWithMessageFunction extends RuntimeException implements GoogleListingsAndAdsException {

	/** @var callable $message_function */
	private $message_function;

	/**
	 * Construct the exception
	 *
	 * @param string         $message [optional] The Exception message to throw.
	 * @param int            $code [optional] The Exception code.
	 * @param Throwable|null $previous [optional] The previous throwable used for the exception chaining.
	 * @param callable|null  $message_function [optional] Function to format/translate the message string.
	 */
	public function __construct( string $message = '', int $code = 0, ?Throwable $previous = null, ?callable $message_function = null ) {
		parent::__construct( $message, $code, $previous );
		$this->message_function = $message_function;
	}

	/**
	 * Override getMessage function to return message from function if available.
	 *
	 * @return string Exception message.
	 */
	public function get_formatted_message(): string {
		if ( is_callable( $this->message_function ) ) {
			return ( $this->message_function )();
		}

		return parent::getMessage();
	}
}
