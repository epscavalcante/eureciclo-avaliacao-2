<?php

describe('GAllonWatter Api Http Test', function () {
    describe('Receives 422 - Unprocessable Entity', function () {
        test('Enviados nenhum dado', function () {
            $response = $this->getJson(route('gallon_of_water'));
            $response->assertUnprocessable();
            $response->assertJson([
                "message" => "The volume field is required. (and 1 more error)",
                "errors" => [
                    "volume" => [
                        "The volume field is required."
                    ],
                    "bottles" => [
                        "The bottles field is required."
                    ]
                ]
            ]);
        });

        test('Enviando dados não númericos', function () {
            $response = $this->getJson(route('gallon_of_water', ['volume' => 'AVS', 'bottles' => ['abc', 'DEF', 'GH1']]));
            $response->assertUnprocessable();
            $response->assertJson([
                "message" => "The volume field must be a number. (and 3 more errors)",
                "errors" => [
                    "volume" => [
                        "The volume field must be a number."
                    ],
                    "bottles.0" => [
                        "The bottles.0 field must be a number."
                    ],
                    "bottles.1" => [
                        "The bottles.1 field must be a number."
                    ],
                    "bottles.2" => [
                        "The bottles.2 field must be a number."
                    ]
                ]
            ]);
        });
    });

    describe('Receives 200 - OK', function () {
        test('Deve calcular', function (float $volume, array $bottles, array $result) {
            $route = route('gallon_of_water', ['volume' => $volume, 'bottles' => $bottles]);
            $response = $this->getJson($route);
            $response->assertOk();
            $response->assertJson([
                'data' => [
                    'left_over' => $result[0],
                    'bottles' => $result[1]
                ]
            ]);
        })->with([
            [7, [1, 3, 4.5, 1.5, 3.5], [0.0, [4.5, 1.5, 1]]],
            [5, [1, 3, 4.5, 1.5], [0.5, [4.5, 1]]],
            [4.9, [4.5, 0.4], [0.0, [4.5, 0.4]]],
        ]);
    });
});
