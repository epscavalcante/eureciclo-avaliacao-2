<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function PHPUnit\Framework\callback;

class ListArticleResource extends JsonResource
{
    public function __construct(
        private readonly int $total,
        private readonly array $items,
    ) {}
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total' => $this->total,
            'items' => $this->mapItems($this->items),
        ];
    }

    private function mapItems(): array
    {
        return  array_map(
            callback: fn($item) => [
                'id' => $item->id,
                'date' => $item->date,
                'title' => $item->title,
            ],
            array: $this->items
        );
    }
}
