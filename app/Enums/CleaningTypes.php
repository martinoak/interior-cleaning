<?php

namespace App\Enums;

enum CleaningTypes: string
{
    case START = 'Lehký start';
    case MIDDLE = 'Zlatá střední cesta';
    case DELUXE = 'Deluxe';

    public function getVariantPrice(): string
    {
        return match ($this) {
            self::START => $this->getFormattedPrice(config('web.prices.start')),
            self::MIDDLE => $this->getFormattedPrice(config('web.prices.middle')),
            self::DELUXE => $this->getFormattedPrice(config('web.prices.deluxe')),
        };
    }

    public function getFormattedPrice(int $price): string
    {
        return number_format($price, 0, '', ' ') . ',- Kč';
    }

    public function getVariantDescription(): array
    {
        return match ($this) {
            self::START => config('web.offer.start'),
            self::MIDDLE => config('web.offer.middle'),
            self::DELUXE => config('web.offer.deluxe'),
        };
    }
}