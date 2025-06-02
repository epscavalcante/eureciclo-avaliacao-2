<?php

namespace App\Http\Controllers;

use App\Actions\FillGallonWater\FillGallonOfWaterAction;
use App\Actions\FillGallonWater\FillGallonOfWaterActionInput;
use App\Http\Requests\GallonOfWaterRequest;
use App\Http\Resources\GallonOfWaterResource;

class GallonOfWaterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GallonOfWaterRequest $request, FillGallonOfWaterAction $gallonWaterAction): GallonOfWaterResource
    {
        $input = new FillGallonOfWaterActionInput(
            volume: $request->validated('volume'),
            bootles: $request->validated('bottles')
        );
        $output = $gallonWaterAction->execute($input);

        return new GallonOfWaterResource(
            leftOver: $output->leftOver,
            bottles: $output->bottles
        );
    }
}
