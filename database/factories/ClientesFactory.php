<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Cliente;
use Faker\Generator as Faker;

$factory->define(Cliente::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'cpf' => $faker->cpf(),
        'cep' => $faker->postcode,
        'endereco' => $faker->streetName,
        'numero_casa' => $faker->numberBetween(1, 999),
        'bairro' => $faker->streetName,
        'cidade' => $faker->city,
        'estado' => $faker->stateAbbr,
    ];
});
