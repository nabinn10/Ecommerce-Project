<?php

declare(strict_types=1);

namespace Automattic\WooCommerce\GoogleListingsAndAds\Vendor\League\Container\Argument\Literal;

use Automattic\WooCommerce\GoogleListingsAndAds\Vendor\League\Container\Argument\LiteralArgument;

class ObjectArgument extends LiteralArgument
{
    public function __construct(object $value)
    {
        parent::__construct($value, LiteralArgument::TYPE_OBJECT);
    }
}
