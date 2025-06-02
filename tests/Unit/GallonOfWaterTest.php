<?php

use App\Entities\GallonOfWater;

describe('Gallon Watter Unit Test', function () {
    it('Deve a entidade GallonOfWater', function ($volume, $bottles, $result) {
        $gallonOfWater = new GallonOfWater(
            volume: $volume,
            bootles: $bottles
        );
        expect($gallonOfWater->isFull())->toBe($result[0]);
        expect($gallonOfWater->getLeftOver())->toBe($result[1]);
        expect($gallonOfWater->getBottlesUsed())->toEqualCanonicalizing($result[2]);
    })->with([
        [7, [1, 3, 4.5, 1.5, 3.5], [true, 0.0, [1, 4.5, 1.5]]],
        [5, [1, 3, 4.5, 1.5], [true, 0.5, [1, 4.5]]],
        [4.9, [4.5, 0.4], [true, 0.0, [4.5, 0.4]]],
    ]);
});
