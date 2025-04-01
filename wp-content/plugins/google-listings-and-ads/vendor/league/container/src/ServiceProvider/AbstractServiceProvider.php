<?php

declare(strict_types=1);

namespace Automattic\WooCommerce\GoogleListingsAndAds\Vendor\League\Container\ServiceProvider;

use Automattic\WooCommerce\GoogleListingsAndAds\Vendor\League\Container\ContainerAwareTrait;

abstract class AbstractServiceProvider implements ServiceProviderInterface
{
    use ContainerAwareTrait;

    /**
     * @var string
     */
    protected $identifier;

    public function getIdentifier(): string
    {
        return $this->identifier ?? get_class($this);
    }

    public function setIdentifier(string $id): ServiceProviderInterface
    {
        $this->identifier = $id;
        return $this;
    }
}
