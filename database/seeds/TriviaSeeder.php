<?php

use Illuminate\Database\Seeder;

class TriviaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trivias')->insert([
            'name' => 'Rally Turistico',
            'description' => 'Trivia de rally turistico de la ciudad de oaxaca',
            'img'=> '',
            'status' => 'Nueva',
        ]);
    }
}
