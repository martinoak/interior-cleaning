<?php

namespace App\Enums;

enum CleaningPrices: string
{
    case LIGHT_START = 'Lehký start';
    case GOLDEN_MIDDLE = 'Zlatá střední cesta';
    case DELUXE = 'Deluxe';

    public function getVariantPrice(): string
    {
        return match ($this) {
            self::LIGHT_START => $this->getFormattedPrice(699),
            self::GOLDEN_MIDDLE => $this->getFormattedPrice(1999),
            self::DELUXE => $this->getFormattedPrice(3299),
        };
    }

    public function getFormattedPrice(int $price): string
    {
        return number_format($price, 0, '', ' ') . ',- Kč';
    }

    public function getVariantDescription(): array
    {
        return match ($this) {
            self::LIGHT_START => config('web.offer.start'),
            self::GOLDEN_MIDDLE => config('web.offer.middle'),
            self::DELUXE => config('web.offer.deluxe'),
        };
    }
}
