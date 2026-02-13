<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarif;
use App\Models\Service;

class TarifSeeder extends Seeder
{
    /**
     * Insérer les tarifs pour chaque service médical
     */
    public function run(): void
    {
        // PÉDIATRIE
        $pediatrie = Service::where('slug', 'pediatrie')->first();
        if ($pediatrie) {
            Tarif::create([
                'service_id' => $pediatrie->id,
                'designation' => 'Consultation pédiatrique',
                'montant' => 5000,
                'type_patient' => 'normal',
                'details' => 'Consultation complète avec examen clinique',
            ]);
            Tarif::create([
                'service_id' => $pediatrie->id,
                'designation' => 'Vaccination (par vaccin)',
                'montant' => 3000,
                'type_patient' => 'normal',
                'details' => 'Vaccin + consultation + carnet de vaccination',
            ]);
            Tarif::create([
                'service_id' => $pediatrie->id,
                'designation' => 'Suivi de croissance',
                'montant' => 3500,
                'type_patient' => 'normal',
                'details' => 'Pesée, mesure, conseils nutritionnels',
            ]);
        }

        // MATERNITÉ
        $maternite = Service::where('slug', 'maternite')->first();
        if ($maternite) {
            Tarif::create([
                'service_id' => $maternite->id,
                'designation' => 'Consultation prénatale',
                'montant' => 5000,
                'type_patient' => 'normal',
                'details' => 'Examen clinique + tension + poids',
            ]);
            Tarif::create([
                'service_id' => $maternite->id,
                'designation' => 'Échographie obstétricale',
                'montant' => 15000,
                'type_patient' => 'normal',
                'details' => 'Échographie complète avec compte-rendu et photos',
            ]);
            Tarif::create([
                'service_id' => $maternite->id,
                'designation' => 'Accouchement normal',
                'montant' => 25000,
                'type_patient' => 'normal',
                'details' => 'Accouchement + surveillance 24h + kit nouveau-né',
            ]);
            Tarif::create([
                'service_id' => $maternite->id,
                'designation' => 'Césarienne',
                'montant' => 75000,
                'type_patient' => 'normal',
                'details' => 'Intervention + anesthésie + hospitalisation 3 jours',
            ]);
            Tarif::create([
                'service_id' => $maternite->id,
                'designation' => 'Accouchement normal',
                'montant' => 20000,
                'type_patient' => 'etudiant',
                'details' => 'Tarif réduit pour étudiants avec carte',
            ]);
        }

        // CARDIOLOGIE
        $cardiologie = Service::where('slug', 'cardiologie')->first();
        if ($cardiologie) {
            Tarif::create([
                'service_id' => $cardiologie->id,
                'designation' => 'Consultation cardiologique',
                'montant' => 8000,
                'type_patient' => 'normal',
                'details' => 'Consultation spécialisée avec auscultation',
            ]);
            Tarif::create([
                'service_id' => $cardiologie->id,
                'designation' => 'Électrocardiogramme (ECG)',
                'montant' => 10000,
                'type_patient' => 'normal',
                'details' => 'ECG + interprétation par cardiologue',
            ]);
            // ...existing code...
        }
        // ...existing code...
    }
}
