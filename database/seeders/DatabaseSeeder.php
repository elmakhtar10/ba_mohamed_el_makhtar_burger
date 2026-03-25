<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $gestionnaireRole = Role::firstOrCreate(['name' => 'gestionnaire']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        $gestionnaire = User::firstOrCreate(
            ['email' => 'gestionnaire@isi-burger.test'],
            [
                'name' => 'Gestionnaire',
                'password' => Hash::make('password'),
            ]
        );
        $gestionnaire->assignRole($gestionnaireRole);

        $client = User::firstOrCreate(
            ['email' => 'client@isi-burger.test'],
            [
                'name' => 'Client',
                'password' => Hash::make('password'),
            ]
        );
        $client->assignRole($clientRole);
    }
}
