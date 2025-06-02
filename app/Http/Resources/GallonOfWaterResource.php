<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GallonOfWaterResource extends JsonResource
{
    public function __construct(
        private readonly float $leftOver,
        private readonly array $bottles
    ) {}

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'left_over' => $this->leftOver,
            'bottles' => $this->bottles,
        ];
    }
}
