<?php

use App\Actions\FillGallonWater\FillGallonOfWaterAction;
use App\Actions\FillGallonWater\FillGallonOfWaterActionInput;
use App\Actions\FillGallonWater\FillGallonOfWaterActionOutput;

describe('Fill Gallon Watter Unit Test', function () {
    it('Deve testar o gallon Watter', function ($volume, $bottles, $result) {
        $input = new FillGallonOfWaterActionInput(
            volume: $volume,
            bootles: $bottles
        );
        $action = new FillGallonOfWaterAction;
        $output = $action->execute($input);
        expect($output)->toBeInstanceOf(FillGallonOfWaterActionOutput::class);
        expect($output->isFull)->toBe($result[0]);
        expect($output->leftOver)->toBe($result[1]);
        expect($output->bottles)->toEqualCanonicalizing($result[2]);
    })->with([
        [7, [1, 3, 4.5, 1.5, 3.5], [true, 0.0, [1, 4.5, 1.5]]],
        [5, [1, 3, 4.5, 1.5], [true, 0.5, [1, 4.5]]],
        [4.9, [4.5, 0.4], [true, 0.0, [4.5, 0.4]]],
    ]);
});
