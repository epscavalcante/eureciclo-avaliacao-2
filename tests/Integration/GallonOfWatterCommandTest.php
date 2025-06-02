<?php

describe('GAllonWatterCommand Test', function () {

    test('Deve testar o commando', function () {
        $this->artisan('app:gallon-of-water')
            ->expectsQuestion('Volume do galão: ', 4.5)
            ->expectsQuestion('Quantidade de garrafas: ', 2)
            ->expectsQuestion('Volume da garrafa 1', 4.5)
            ->expectsQuestion('Volume da garrafa 2', 0.4)
            ->assertExitCode(0);
    });
});
