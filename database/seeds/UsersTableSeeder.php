<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'nombre' => 'Administrador',
            'email' => 'pedro@utopicstudio.com',
            'descripcion' => 'Administrador del Sistema',
            'password' => bcrypt('utopic123!')
        ]);
    }
}
