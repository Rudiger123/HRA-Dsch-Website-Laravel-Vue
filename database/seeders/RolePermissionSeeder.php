<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ==========================================
        // CRÉER LES PERMISSIONS
        // ==========================================

        $permissions = [
            // Gestion utilisateurs
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'assign_roles',

            // Gestion services
            'view_services',
            'create_services',
            'edit_services',
            'delete_services',

            // Gestion médecins
            'view_medecins',
            'create_medecins',
            'edit_medecins',
            'delete_medecins',

            // Gestion actualités
            'view_actualites',
            'create_actualites',
            'edit_actualites',
            'delete_actualites',
            'publish_actualites',

            // Gestion RDV
            'view_all_rdv',
            'view_own_rdv',
            'manage_rdv',

            // Gestion messages contact
            'view_contacts',
            'manage_contacts',

            // Gestion tarifs et horaires
            'manage_tarifs',
            'manage_horaires',

            // Statistiques
            'view_full_dashboard',
            'view_basic_stats',

            // Audit log
            'view_audit_log',

            // Paramètres
            'manage_settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ==========================================
        // CRÉER LES RÔLES ET ASSIGNER PERMISSIONS
        // ==========================================

        // 1. SUPER ADMIN - Peut tout faire
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        // 2. ADMIN - Tout sauf gestion utilisateurs
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'view_services', 'create_services', 'edit_services', 'delete_services',
            'view_medecins', 'create_medecins', 'edit_medecins', 'delete_medecins',
            'view_actualites', 'create_actualites', 'edit_actualites', 'delete_actualites', 'publish_actualites',
            'view_all_rdv', 'manage_rdv',
            'view_contacts', 'manage_contacts',
            'manage_tarifs', 'manage_horaires',
            'view_full_dashboard',
            'view_audit_log',
        ]);

        // 3. ÉDITEUR - Gestion actualités uniquement
        $editeur = Role::firstOrCreate(['name' => 'editeur', 'guard_name' => 'web']);
        $editeur->givePermissionTo([
            'view_services',
            'view_medecins',
            'view_actualites', 'create_actualites', 'edit_actualites', 'delete_actualites', 'publish_actualites',
            'view_basic_stats',
        ]);

        // 4. RÉCEPTIONNISTE - Gestion RDV et messages
        $receptionniste = Role::firstOrCreate(['name' => 'receptionniste', 'guard_name' => 'web']);
        $receptionniste->givePermissionTo([
            'view_services',
            'view_medecins',
            'view_all_rdv', 'manage_rdv',
            'view_contacts', 'manage_contacts',
            'view_basic_stats',
        ]);

        // 5. MÉDECIN - Consultation RDV uniquement
        $medecin = Role::firstOrCreate(['name' => 'medecin', 'guard_name' => 'web']);
        $medecin->givePermissionTo([
            'view_services',
            'view_medecins',
            'view_own_rdv',
            'view_basic_stats',
        ]);

        // ==========================================
        // CRÉER UTILISATEUR SUPER ADMIN PAR DÉFAUT
        // ==========================================

        $superAdminUser = User::firstOrCreate(
            ['email' => 'admin@hradschang.cm'],
            [
                'name' => 'Administrateur Principal',
                'password' => Hash::make('password123'), // ⚠️ À changer en production
                'phone' => '+237233000000',
                'is_active' => true,
            ]
        );

        if (!$superAdminUser->hasRole('super_admin')) {
            $superAdminUser->assignRole('super_admin');
        }

        // Créer utilisateurs de test (optionnel - à supprimer en production)
        $this->createTestUsers();

        $this->command->info('✅ Rôles et permissions créés avec succès !');
        $this->command->info('📧 Super Admin : admin@hradschang.cm / password123');
    }

    /**
     * Créer utilisateurs de test pour chaque rôle
     */
    private function createTestUsers(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin.adjoint@hradschang.cm'],
            [
                'name' => 'Administrateur Adjoint',
                'password' => Hash::make('password123'),
                'phone' => '+237233000001',
                'is_active' => true,
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Éditeur
        $editeur = User::firstOrCreate(
            ['email' => 'editeur@hradschang.cm'],
            [
                'name' => 'Responsable Communication',
                'password' => Hash::make('password123'),
                'phone' => '+237233000002',
                'is_active' => true,
            ]
        );
        if (!$editeur->hasRole('editeur')) {
            $editeur->assignRole('editeur');
        }

        // Réceptionniste
        $receptionniste = User::firstOrCreate(
            ['email' => 'accueil@hradschang.cm'],
            [
                'name' => 'Réceptionniste',
                'password' => Hash::make('password123'),
                'phone' => '+237233000003',
                'is_active' => true,
            ]
        );
        if (!$receptionniste->hasRole('receptionniste')) {
            $receptionniste->assignRole('receptionniste');
        }

        // Médecin
        $medecin = User::firstOrCreate(
            ['email' => 'medecin@hradschang.cm'],
            [
                'name' => 'Dr. Jean Fotso',
                'password' => Hash::make('password123'),
                'phone' => '+237233000004',
                'is_active' => true,
            ]
        );
        if (!$medecin->hasRole('medecin')) {
            $medecin->assignRole('medecin');
        }
    }
}
