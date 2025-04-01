<?php
declare( strict_types=1 );

namespace Automattic\WooCommerce\GoogleListingsAndAds;

use Automattic\WooCommerce\GoogleListingsAndAds\Infrastructure\Registerable;
use Automattic\WooCommerce\GoogleListingsAndAds\Infrastructure\Service;
use Automattic\WooCommerce\GoogleListingsAndAds\Internal\ContainerAwareTrait;
use Automattic\WooCommerce\GoogleListingsAndAds\Internal\Interfaces\ContainerAwareInterface;
use Automattic\WooCommerce\GoogleListingsAndAds\Internal\Interfaces\FirstInstallInterface;
use Automattic\WooCommerce\GoogleListingsAndAds\Internal\Interfaces\InstallableInterface;
use Automattic\WooCommerce\GoogleListingsAndAds\Options\OptionsAwareInterface;
use Automattic\WooCommerce\GoogleListingsAndAds\Options\OptionsAwareTrait;
use Automattic\WooCommerce\GoogleListingsAndAds\Options\OptionsInterface;
use Automattic\WooCommerce\GoogleListingsAndAds\Proxies\WP;

defined( 'ABSPATH' ) || exit;

/**
 * Installer class.
 *
 * @package Automattic\WooCommerce\GoogleListingsAndAds
 */
class Installer implements ContainerAwareInterface, OptionsAwareInterface, Registerable, Service {

	use ContainerAwareTrait;
	use OptionsAwareTrait;
	use PluginHelper;

	/**
	 * @var WP
	 */
	protected $wp;

	/**
	 * Installer constructor.
	 *
	 * @param WP $wp
	 */
	public function __construct( WP $wp ) {
		$this->wp = $wp;
	}

	/**
	 * Register a service.
	 */
	public function register(): void {
		add_action(
			'admin_init',
			function () {
				$this->admin_init();
			}
		);
	}

	/**
	 * Admin init.
	 */
	protected function admin_init(): void {
		if ( defined( 'IFRAME_REQUEST' ) || $this->wp->wp_doing_ajax() ) {
			return;
		}

		$this->check_if_plugin_files_updated();

		$db_version = $this->get_db_version();
		if ( $db_version !== $this->get_version() || apply_filters( 'woocommerce_gla_force_run_install', false ) ) {
			$this->install();

			if ( '' === $db_version ) {
				$this->first_install();
			}

			$this->options->update( OptionsInterface::DB_VERSION, $this->get_version() );
		}
	}

	/**
	 * Install GLA.
	 *
	 * Run on every plugin update.
	 */
	protected function install(): void {
		$old_version = $this->get_db_version();
		$new_version = $this->get_version();

		/** @var InstallableInterface[] */
		$installables = $this->container->get( InstallableInterface::class );

		foreach ( $installables as $installable ) {
			$installable->install( $old_version, $new_version );
		}
	}

	/**
	 * Checks and records if plugin files have been updated.
	 */
	protected function check_if_plugin_files_updated(): void {
		if ( $this->get_file_version() !== $this->get_version() ) {
			$this->options->update( OptionsInterface::FILE_VERSION, $this->get_version() );
		}
	}

	/**
	 * Runs on the first install of GLA.
	 */
	protected function first_install(): void {
		/** @var FirstInstallInterface[] $first_installers */
		$first_installers = $this->container->get( FirstInstallInterface::class );

		foreach ( $first_installers as $installer ) {
			$installer->first_install();
		}
	}

	/**
	 * Get the db version
	 *
	 * @return string
	 */
	protected function get_db_version(): string {
		return $this->options->get( OptionsInterface::DB_VERSION, '' );
	}

	/**
	 * Get the stored file version
	 *
	 * @return string
	 */
	protected function get_file_version(): string {
		return $this->options->get( OptionsInterface::FILE_VERSION, '' );
	}
}
