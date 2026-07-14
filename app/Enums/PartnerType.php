<?php

namespace App\Enums;

enum PartnerType: string
{
    case Buyer = 'buyer';
    case Vendor = 'vendor';

    public function label(): string
    {
        return match ($this) {
            self::Buyer => 'Buyer',
            self::Vendor => 'Vendor',
        };
    }
}
