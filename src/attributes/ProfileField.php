<?php

namespace App\Attribute;

use Attribute;

// say it's an attribute and it can only be used on properties
#[\Attribute(Attribute::TARGET_PROPERTY)]
class ProfileField
{
    // The level of the log
    public function __construct(public ?int $weight = 1)
    {}
}

?>