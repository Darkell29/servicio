<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        Usuario::create([
            'usuario' => 'administrador',
            'contraseña' => Hash::make('admin'),
            'rol' => 1,
        ]);

        Usuario::create([
            'usuario' => 'vendedor',
            'contraseña' => Hash::make('vende'),
            'rol' => 2,
        ]);
    }
}
