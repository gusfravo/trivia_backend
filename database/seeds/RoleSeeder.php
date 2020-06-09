<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
            'name' => 'ADMINISTRADOR',
            'description' => 'Rol para la administración del sistema',
            'status' => true,
        ]);
        DB::table('roles')->insert([
            'name' => 'JUGADOR',
            'description' => 'Rol asignado a los usuarios que juegan en el sistema',
            'status' => true,
        ]);
    }
}
