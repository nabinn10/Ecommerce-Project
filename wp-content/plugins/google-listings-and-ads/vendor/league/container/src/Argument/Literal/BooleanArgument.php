<?php

declare(strict_types=1);

namespace Automattic\WooCommerce\GoogleListingsAndAds\Vendor\League\Container\Argument\Literal;

use Automattic\WooCommerce\GoogleListingsAndAds\Vendor\League\Container\Argument\LiteralArgument;

class BooleanArgument extends LiteralArgument
{
    public function __construct(bool $value)
    {
        parent::__construct($value, LiteralArgument::TYPE_BOOL);
    }
}
