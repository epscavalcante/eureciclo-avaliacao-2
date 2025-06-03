<?php

use App\Entities\GallonOfWater;

describe('Gallon Water Unit Test', function () {
    it('Deve a entidade GallonOfWater', function ($volume, $bottles, $result, float $amountNeedToCompleteGallon) {
        $gallonOfWater = new GallonOfWater(
            volume: $volume,
            bottles: $bottles
        );
        expect($gallonOfWater->isFull())->toBe($result[0]);
        expect($gallonOfWater->getLeftOver())->toBe($result[1]);
        expect($gallonOfWater->getBottlesUsed())->toEqualCanonicalizing($result[2]);
        expect($gallonOfWater->getNeededVolumeToCompleteGallon())->toBe($amountNeedToCompleteGallon);
    })->with([
        [7, [1, 3, 4.5, 1.5, 3.5], [true, 0.0, [1, 4.5, 1.5]], 0],
        [5, [1, 3, 4.5, 1.5], [true, 0.5, [1, 4.5]], 0],
        [4.9, [4.5, 0.4], [true, 0.0, [4.5, 0.4]], 0],
    ]);
});
