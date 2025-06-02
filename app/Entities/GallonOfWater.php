<?php

namespace App\Entities;

class GallonOfWater
{
    private array $bottlesUsed;

    public function __construct(
        private readonly float $volume,
        private array $bootles,
    ) {
        $this->bottlesUsed = [];

        $this->fill();
    }

    private function fill(): void
    {
        arsort($this->bootles);
        foreach ($this->bootles as $bottle) {
            if (!$this->isFull() && $bottle <= $this->getNeededVolumeToCompleteGallon()) {
                $this->incrementVolumeGallon($bottle);
            }
        }

        sort($this->bootles);
        if (! $this->isFull()) {
            if ($this->bootles[0] >= $this->getNeededVolumeToCompleteGallon()) {
                $this->incrementVolumeGallon($this->bootles[0]);
            }
        }
    }

    private function getNeededVolumeToCompleteGallon(): float
    {
        if ($this->isFull()) {
            return 0;
        }

        return $this->volume - $this->getCurrentVolumeGallon();
    }

    public function isFull(): bool
    {
        return $this->getCurrentVolumeGallon() >= $this->volume;
    }

    private function getCurrentVolumeGallon(): float
    {
        return array_sum($this->bottlesUsed);
    }

    private function incrementVolumeGallon(float $bottle): void
    {
        array_push($this->bottlesUsed, $bottle);
    }

    public function getLeftOver(): float
    {
        return $this->getCurrentVolumeGallon() - $this->volume;
    }

    public function getBottlesUsed(): array
    {
        return $this->bottlesUsed;
    }
}
