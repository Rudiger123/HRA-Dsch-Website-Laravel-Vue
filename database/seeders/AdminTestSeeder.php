<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les rôles s'ils n'existent pas
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editeurRole = Role::firstOrCreate(['name' => 'editeur']);
        $receptionniste = Role::firstOrCreate(['name' => 'receptionniste']);
        $medecin = Role::firstOrCreate(['name' => 'medecin']);

        // Créer l'utilisateur super admin test
        $superAdminUser = User::firstOrCreate(
            ['email' => 'admin@hradschang.cm'],
            [
                'name' => 'Admin HRA Dschang',
                'password' => bcrypt('password123'),
                'phone' => '+237 671 234 567',
                'is_active' => true,
            ]
        );

        // Assigner le rôle super_admin
        $superAdminUser->syncRoles($superAdminRole);

        $this->command->info('Super Admin créé: admin@hradschang.cm / password123');

        // Créer un utilisateur réceptionniste test
        $receptionnisteUser = User::firstOrCreate(
            ['email' => 'accueil@hradschang.cm'],
            [
                'name' => 'Accueil HRA Dschang',
                'password' => bcrypt('password123'),
                'phone' => '+237 671 234 568',
                'is_active' => true,
            ]
        );

        // Assigner le rôle réceptionniste
        $receptionnisteUser->syncRoles($receptionniste);

        $this->command->info('Réceptionniste créé: accueil@hradschang.cm / password123');

        // Créer un utilisateur médecin test
        $medecinUser = User::firstOrCreate(
            ['email' => 'medecin@hradschang.cm'],
            [
                'name' => 'Dr. Médecin Test',
                'password' => bcrypt('password123'),
                'phone' => '+237 671 234 569',
                'is_active' => true,
            ]
        );

        // Assigner le rôle médecin
        $medecinUser->syncRoles($medecin);

        $this->command->info('Médecin créé: medecin@hradschang.cm / password123');
    }
}
