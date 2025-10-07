<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Modules\Usuarios\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $desarrollador = Role::updateOrCreate([
            'name' => 'desarrollador',
        ],[
            'guard_name' => 'api',
            'descripcion' => 'Rol unicamente para desarrolladores'
        ]);
        $permisos = Permission::all();
        $desarrollador->syncPermissions($permisos);
        // $user = User::where('id', 432)->first();
        // $user->assignRole('desarrollador');
        $usuarios = [
            [
                'email' => '1036131909@sumimedical.com',
                'password' => bcrypt('1036131909'),
                'tipo_usuario_id' => 2,
                'reps_id' => null,
            ],

        ];
        foreach ($usuarios as $usuario) {
            $user = User::updateOrCreate(
                ['email' => $usuario['email']],
                $usuario
            );
            $user->assignRole('desarrollador');
            //$user->entidad()->attach(1);
        }
    }
}
