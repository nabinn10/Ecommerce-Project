<?php
declare( strict_types=1 );

namespace Automattic\WooCommerce\GoogleListingsAndAds\API\Site;

use Automattic\WooCommerce\GoogleListingsAndAds\API\Site\Controllers\BaseController;
use Automattic\WooCommerce\GoogleListingsAndAds\Exception\ValidateInterface;
use Automattic\WooCommerce\GoogleListingsAndAds\Infrastructure\Registerable;
use Automattic\WooCommerce\GoogleListingsAndAds\Infrastructure\Service;
use Automattic\WooCommerce\GoogleListingsAndAds\Internal\ContainerAwareTrait;
use Automattic\WooCommerce\GoogleListingsAndAds\Internal\Interfaces\ContainerAwareInterface;

/**
 * Class RESTControllers
 *
 * Container used for:
 * - classes tagged with 'rest_controller'
 *
 * @package Automattic\WooCommerce\GoogleListingsAndAds\API\Site
 */
class RESTControllers implements ContainerAwareInterface, Service, Registerable {

	use ContainerAwareTrait;
	use ValidateInterface;

	/**
	 * Register a service.
	 */
	public function register(): void {
		add_action(
			'rest_api_init',
			function () {
				$this->register_controllers();
			}
		);
	}

	/**
	 * Register our individual rest controllers.
	 */
	protected function register_controllers(): void {
		/** @var BaseController[] $controllers */
		$controllers = $this->container->get( 'rest_controller' );
		foreach ( $controllers as $controller ) {
			$this->validate_instanceof( $controller, BaseController::class );
			$controller->register();
		}
	}
}
