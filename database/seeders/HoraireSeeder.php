<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horaire;
use App\Models\Service;

class HoraireSeeder extends Seeder
{
    /**
     * Insérer les horaires d'ouverture pour chaque service
     */
    public function run(): void
    {
        $services = Service::all();

        foreach ($services as $service) {
            // Horaires selon le type de service
            switch ($service->slug) {
                case 'urgences':
                    // Urgences ouvertes 24h/24 tous les jours
                    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                    foreach ($jours as $jour) {
                        Horaire::create([
                            'service_id' => $service->id,
                            'jour_semaine' => $jour,
                            'ouverture' => '00:00:00',
                            'fermeture' => '23:59:59',
                            'note' => 'Service disponible 24h/24',
                        ]);
                    }
                    break;

                case 'maternite':
                    // Maternité ouverte 24h/24
                    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                    foreach ($jours as $jour) {
                        Horaire::create([
                            'service_id' => $service->id,
                            'jour_semaine' => $jour,
                            'ouverture' => '00:00:00',
                            'fermeture' => '23:59:59',
                            'note' => 'Accouchements et urgences obstétricales 24h/24',
                        ]);
                    }
                    break;

                case 'laboratoire':
                case 'radiologie':
                    // Labo et Radio : Lun-Ven 7h30-17h, Sam 8h-13h
                    $joursEnSemaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
                    foreach ($joursEnSemaine as $jour) {
                        Horaire::create([
                            'service_id' => $service->id,
                            'jour_semaine' => $jour,
                            'ouverture' => '07:30:00',
                            'fermeture' => '17:00:00',
                            'note' => 'Prélèvements à jeun avant 9h recommandés',
                        ]);
                    }
                    Horaire::create([
                        'service_id' => $service->id,
                        'jour_semaine' => 'Samedi',
                        'ouverture' => '08:00:00',
                        'fermeture' => '13:00:00',
                        'note' => 'Urgences uniquement',
                    ]);
                    Horaire::create([
                        'service_id' => $service->id,
                        'jour_semaine' => 'Dimanche',
                        'ouverture' => '09:00:00',
                        'fermeture' => '12:00:00',
                        'note' => 'Urgences uniquement sur appel',
                    ]);
                    break;

                default:
                    // Autres services : Lun-Ven 8h-17h, Sam 8h-12h
                    $joursEnSemaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
                    foreach ($joursEnSemaine as $jour) {
                        Horaire::create([
                            'service_id' => $service->id,
                            'jour_semaine' => $jour,
                            'ouverture' => '08:00:00',
                            'fermeture' => '17:00:00',
                            'note' => 'Consultations sur rendez-vous',
                        ]);
                    }
                    Horaire::create([
                        'service_id' => $service->id,
                        'jour_semaine' => 'Samedi',
                        'ouverture' => '08:00:00',
                        'fermeture' => '12:00:00',
                        'note' => 'Consultations limitées',
                    ]);
                    Horaire::create([
                        'service_id' => $service->id,
                        'jour_semaine' => 'Dimanche',
                        'ouverture' => '00:00:00',
                        'fermeture' => '00:00:00',
                        'note' => 'Fermé sauf urgences',
                    ]);
                    break;
            }
        }

        $this->command->info('✅ Horaires créés pour tous les services !');
    }
}
