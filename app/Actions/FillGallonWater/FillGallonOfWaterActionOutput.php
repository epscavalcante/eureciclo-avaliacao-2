<?php

namespace App\Actions\FillGallonWater;

class FillGallonOfWaterActionOutput
{
    public function __construct(
        public readonly bool $isFull,
        public readonly float $leftOver,
        public readonly array $bottles,
    ) {}
}
