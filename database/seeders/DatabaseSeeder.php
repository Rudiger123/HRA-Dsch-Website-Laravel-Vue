<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Exécuter tous les seeders de la base de données HRAD
     *
     * Ordre important :
     * 1. Services (table indépendante)
     * 2. Médecins (table indépendante)
     * 3. Horaires (dépend de Services)
     * 4. Tarifs (dépend de Services)
     *
     * Les associations médecins-services sont créées dans MedecinSeeder
     */
    public function run(): void
    {
        $this->command->info('🏥 Démarrage du seeding de la base de données HRAD...');
        $this->command->newLine();

        // Ordre d'exécution respectant les dépendances
        $this->call([
            ServiceSeeder::class,
            MedecinSeeder::class,
            HoraireSeeder::class,
            TarifSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('✅ Base de données HRAD complètement initialisée !');
        $this->command->info('📊 Statistiques :');

        // Afficher les statistiques
        $serviceCount = \App\Models\Service::count();
        $medecinCount = \App\Models\Medecin::count();
        $horaireCount = \App\Models\Horaire::count();
        $tarifCount = \App\Models\Tarif::count();

        $this->command->table(
            ['Table', 'Nombre d\'enregistrements'],
            [
                ['Services', $serviceCount],
                ['Médecins', $medecinCount],
                ['Horaires', $horaireCount],
                ['Tarifs', $tarifCount],
            ]
        );

        $this->command->newLine();
        $this->command->info('🚀 Vous pouvez maintenant démarrer le développement !');
    }
}
