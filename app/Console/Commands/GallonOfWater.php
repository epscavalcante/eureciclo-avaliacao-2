<?php

namespace App\Console\Commands;

use App\Actions\FillGallonWater\FillGallonOfWaterAction;
use App\Actions\FillGallonWater\FillGallonOfWaterActionInput;
use Illuminate\Console\Command;

class GallonOfWater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gallon-of-water';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $volume = (float) $this->ask('Volume do galão: ');
        $bottlesCount = (int) $this->ask('Quantidade de garrafas: ');

        $bottles = [];
        for ($i = 1; $i <= $bottlesCount; $i++) {
            $bootle = (float) $this->ask("Volume da garrafa {$i}");
            array_push($bottles, $bootle);
        }

        $input = new FillGallonOfWaterActionInput(
            volume: $volume,
            bootles: $bottles
        );
        $action = new FillGallonOfWaterAction();
        $output = $action->execute($input);

        $bottles = $output->bottles;
        asort($bottles);

        $bottlesOutput = implode(
            separator: ', ',
            array: array_map(
                callback: fn ($bootle) => "{$bootle}L",
                array: $bottles
            )
        );

        $leftOverOutput = $output->leftOver . 'L';
        $output = "Resposta: [{$bottlesOutput}], sobra: {$leftOverOutput}.";
        $this->line($output);

        return Command::SUCCESS;
    }
}
