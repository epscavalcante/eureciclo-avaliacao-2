<?php

namespace App\Actions\FillGallonWater;

class FillGallonOfWaterActionInput
{
    public function __construct(
        public readonly float $volume,
        public readonly array $bottles,
    ) {}
}
