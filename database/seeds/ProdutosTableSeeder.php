<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProdutosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // factory(\App\Produto::class, 30)->create();
        for($i = 0; $i < 50; $i++) {
            DB::table('produtos')->insert([
                'nome' => $faker->word,
                'descricao' => $faker->sentence(),
                'valor' => $faker->randomNumber(2),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
