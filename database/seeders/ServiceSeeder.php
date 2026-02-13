<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Insérer les services médicaux de l'HRAD
     */
    public function run(): void
    {
        $services = [
            [
                'nom' => 'Pédiatrie',
                'slug' => 'pediatrie',
                'description' => 'Soins médicaux complets pour les enfants de 0 à 15 ans. Notre équipe de pédiatres qualifiés assure le suivi de la croissance, les vaccinations et le traitement des maladies infantiles courantes. Consultation de puériculture, traitement des infections, suivi nutritionnel.',
                'icon' => 'Baby',
                'tarif_consultation' => 5000,
                'actif' => true,
                'ordre' => 1,
            ],
            [
                'nom' => 'Maternité',
                'slug' => 'maternite',
                'description' => 'Accompagnement complet de la grossesse : consultations prénatales, accouchements sécurisés et soins post-partum. Salle d\'accouchement moderne équipée, échographies obstétricales, suivi des grossesses à risque. Équipe de sages-femmes et gynécologues disponible 24h/24.',
                'icon' => 'Heart',
                'tarif_consultation' => 5000,
                'actif' => true,
                'ordre' => 2,
            ],
            [
                'nom' => 'Cardiologie',
                'slug' => 'cardiologie',
                'description' => 'Diagnostic et traitement des maladies cardiovasculaires. Électrocardiogramme (ECG), échographie cardiaque, épreuve d\'effort, Holter tensionnel. Suivi des patients hypertendus, diabétiques et insuffisants cardiaques. Consultation de cardiologie préventive.',
                'icon' => 'HeartPulse',
                'tarif_consultation' => 8000,
                'actif' => true,
                'ordre' => 3,
            ],
            [
                'nom' => 'Chirurgie Générale',
                'slug' => 'chirurgie',
                'description' => 'Interventions chirurgicales programmées et d\'urgence. Chirurgie digestive, viscérale, pariétale et urgences chirurgicales. Bloc opératoire moderne équipé avec matériel de pointe. Équipe chirurgicale expérimentée pour appendicectomie, hernies, césariennes.',
                'icon' => 'Scissors',
                'tarif_consultation' => 10000,
                'actif' => true,
                'ordre' => 4,
            ],
            [
                'nom' => 'Urgences',
                'slug' => 'urgences',
                'description' => 'Service d\'urgences disponible 24h/24 et 7j/7. Prise en charge rapide des accidents, traumatismes, urgences médicales et chirurgicales. Salle de déchocage, monitoring continu, équipe médicale permanente. Ambulance médicalisée disponible.',
                'icon' => 'Ambulance',
                'tarif_consultation' => 7500,
                'actif' => true,
                'ordre' => 5,
            ],
            [
                'nom' => 'Médecine Générale',
                'slug' => 'medecine-generale',
                'description' => 'Consultations médicales pour adultes et adolescents. Diagnostic et traitement des pathologies courantes : infections, maladies chroniques, bilan de santé. Orientation vers spécialistes si nécessaire. Médecine préventive et conseils santé.',
                'icon' => 'Stethoscope',
                'tarif_consultation' => 5000,
                'actif' => true,
                'ordre' => 6,
            ],
            [
                'nom' => 'Laboratoire',
                'slug' => 'laboratoire',
                'description' => 'Analyses médicales complètes : examens sanguins (NFS, glycémie, bilan lipidique), analyses urinaires, parasitologie, sérologies. Matériel moderne et personnel qualifié. Résultats rapides et fiables. Prélèvements possibles à domicile sur demande.',
                'icon' => 'FlaskConical',
                'tarif_consultation' => 0, // Pas de consultation, tarifs par analyse
                'actif' => true,
                'ordre' => 7,
            ],
            [
                'nom' => 'Radiologie',
                'slug' => 'radiologie',
                'description' => 'Imagerie médicale moderne : radiographie numérique, échographie générale et obstétricale, échographie Doppler. Examens osseux, thoraciques, abdominaux. Interprétation par radiologues qualifiés. Résultats disponibles rapidement avec compte-rendu détaillé.',
                'icon' => 'Scan',
                'tarif_consultation' => 0, // Tarifs par type d'examen
                'actif' => true,
                'ordre' => 8,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $this->command->info('✅ 8 services médicaux créés avec succès !');
    }
}
