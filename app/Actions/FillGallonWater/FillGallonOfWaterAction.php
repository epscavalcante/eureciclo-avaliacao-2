<?php

namespace App\Actions\FillGallonWater;

use App\Entities\GallonOfWater;

class FillGallonOfWaterAction
{
    public function execute(FillGallonOfWaterActionInput $input): FillGallonOfWaterActionOutput
    {
        $gallon = new GallonOfWater(
            volume: $input->volume,
            bottles: $input->bottles
        );

        return new FillGallonOfWaterActionOutput(
            isFull: $gallon->isFull(),
            leftOver: $gallon->getLeftOver(),
            bottles: $gallon->getBottlesUsed()
        );
    }
}
