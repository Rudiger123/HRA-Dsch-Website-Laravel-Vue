<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medecin;
use App\Models\Service;

class MedecinSeeder extends Seeder
{
    /**
     * Insérer les médecins de l'HRAD avec leurs spécialités
     */
    public function run(): void
    {
        $medecins = [
            [
                'nom' => 'Dr. Marie-Claire TCHUENTE',
                'slug' => 'dr-marie-claire-tchuente',
                'specialite' => 'Pédiatre',
                'diplomes' => "• Doctorat en Médecine - Université de Yaoundé I (2010)\n• Spécialisation en Pédiatrie - CHU de Yaoundé (2014)\n• Formation en Néonatologie - Hôpital Laquintinie Douala (2016)\n• Certificat de Prise en charge de la malnutrition infantile",
                'photo' => 'medecins/dr-tchuente.jpg',
                'bio' => 'Passionnée par la santé infantile, Dr. TCHUENTE a plus de 12 ans d\'expérience en pédiatrie. Elle se spécialise dans le suivi de la croissance, les vaccinations et le traitement des maladies courantes de l\'enfant.',
                'langues' => 'Français, Anglais',
                'actif' => true,
            ],
            [
                'nom' => 'Dr. Jean-Paul FOKA',
                'slug' => 'dr-jean-paul-foka',
                'specialite' => 'Cardiologue',
                'diplomes' => "• Doctorat en Médecine - Université de Douala (2008)\n• Spécialisation en Cardiologie - Hôpital Général de Douala (2013)\n• Fellowship en Échocardiographie - Hôpital Central de Yaoundé (2015)\n• Diplôme Universitaire d'Hypertension Artérielle",
                'photo' => 'medecins/dr-foka.jpg',
                'bio' => 'Expert en maladies cardiovasculaires avec 14 ans de pratique. Dr. FOKA assure le diagnostic et le suivi des patients atteints d\'hypertension, d\'insuffisance cardiaque et autres pathologies cardiaques.',
                'langues' => 'Français, Anglais, Allemand',
                'actif' => true,
            ],
            [
                'nom' => 'Dr. Sandrine NGUEMO',
                'slug' => 'dr-sandrine-nguemo',
                'specialite' => 'Gynécologue-Obstétricienne',
                'diplomes' => "• Doctorat en Médecine - Université de Dschang (2012)\n• Spécialisation en Gynécologie-Obstétrique - CHU de Yaoundé (2017)\n• Formation en Échographie Obstétricale (2018)\n• Certificat de Gestion des Grossesses à Haut Risque",
                'photo' => 'medecins/dr-nguemo.jpg',
                'bio' => 'Spécialiste en santé de la femme, Dr. NGUEMO accompagne les femmes enceintes tout au long de leur grossesse. Elle pratique également la gynécologie générale et les accouchements.',
                'langues' => 'Français, Anglais',
                'actif' => true,
            ],
            [
                'nom' => 'Dr. Pascal KAMGA',
                'slug' => 'dr-pascal-kamga',
                'specialite' => 'Chirurgien Général',
                'diplomes' => "• Doctorat en Médecine - Université de Yaoundé I (2009)\n• Spécialisation en Chirurgie Générale - CHU de Yaoundé (2015)\n• Formation en Chirurgie Laparoscopique - Hôpital Laquintinie (2017)\n• Certificat en Gestion des Urgences Chirurgicales",
                'photo' => 'medecins/dr-kamga.jpg',
                'bio' => 'Chirurgien expérimenté avec plus de 10 ans de pratique. Dr. KAMGA réalise des interventions chirurgicales digestives, viscérales et de la paroi. Expert en chirurgie d\'urgence.',
                'langues' => 'Français, Anglais',
                'actif' => true,
            ],
            [
                'nom' => 'Dr. Stéphanie NJOYA',
                'slug' => 'dr-stephanie-njoya',
                'specialite' => 'Médecin Généraliste',
                'diplomes' => "• Doctorat en Médecine - Université de Dschang (2015)\n• Formation en Médecine d'Urgence - CUSS Dschang (2017)\n• Certificat en Gestion des Maladies Chroniques (2019)\n• Formation en Médecine Préventive",
                'photo' => 'medecins/dr-njoya.jpg',
                'bio' => 'Médecin généraliste dévouée, Dr. NJOYA assure les consultations médicales pour toute la famille. Elle se consacre à la médecine préventive et à l\'éducation sanitaire des patients.',
                'langues' => 'Français, Anglais, Medumba',
                'actif' => true,
            ],
            [
                'nom' => 'Dr. Rodrigue NKEMBI',
                'slug' => 'dr-rodrigue-nkembi',
                'specialite' => 'Urgentiste',
                'diplomes' => "• Doctorat en Médecine - Université de Bamenda (2011)\n• Spécialisation en Médecine d'Urgence - Hôpital Central Yaoundé (2016)\n• Formation ACLS (Advanced Cardiac Life Support)\n• Certificat en Traumatologie d'Urgence",
                'photo' => 'medecins/dr-nkembi.jpg',
                'bio' => 'Spécialiste des urgences avec 11 ans d\'expérience. Dr. NKEMBI est formé à la prise en charge rapide et efficace des urgences médicales et traumatiques 24h/24.',
                'langues' => 'Français, Anglais',
                'actif' => true,
            ],
            [
                'nom' => 'Dr. Françoise TALLA',
                'slug' => 'dr-francoise-talla',
                'specialite' => 'Radiologue',
                'diplomes' => "• Doctorat en Médecine - Université de Douala (2010)\n• Spécialisation en Radiologie - CHU de Yaoundé (2015)\n• Formation en Échographie Doppler (2017)\n• Certificat en Mammographie et Imagerie de la Femme",
                'photo' => 'medecins/dr-talla.jpg',
                'bio' => 'Experte en imagerie médicale, Dr. TALLA réalise et interprète les examens radiologiques et échographiques. Elle assure des compte-rendus détaillés et précis.',
                'langues' => 'Français, Anglais',
                'actif' => true,
            ],
            [
                'nom' => 'Dr. André MOUKOURI',
                'slug' => 'dr-andre-moukouri',
                'specialite' => 'Biologiste Médical',
                'diplomes' => "• Doctorat en Biologie Médicale - Université de Yaoundé I (2012)\n• Spécialisation en Analyses Médicales (2015)\n• Formation en Contrôle Qualité des Laboratoires\n• Certificat en Parasitologie Clinique",
                'photo' => 'medecins/dr-moukouri.jpg',
                'bio' => 'Biologiste médical chevronné, Dr. MOUKOURI dirige le laboratoire de l\'HRAD. Il garantit la qualité et la fiabilité des analyses médicales réalisées.',
                'langues' => 'Français, Anglais',
                'actif' => true,
            ],
        ];

        // Créer les médecins et les associer aux services
        foreach ($medecins as $medecinData) {
            $medecin = Medecin::create($medecinData);

            // Association automatique selon la spécialité
            switch ($medecin->specialite) {
                case 'Pédiatre':
                    $service = Service::where('slug', 'pediatrie')->first();
                    break;
                case 'Cardiologue':
                    $service = Service::where('slug', 'cardiologie')->first();
                    break;
                case 'Gynécologue-Obstétricienne':
                    $service = Service::where('slug', 'maternite')->first();
                    break;
                case 'Chirurgien Général':
                    $service = Service::where('slug', 'chirurgie')->first();
                    break;
                case 'Médecin Généraliste':
                    $service = Service::where('slug', 'medecine-generale')->first();
                    break;
                case 'Urgentiste':
                    $service = Service::where('slug', 'urgences')->first();
                    break;
                case 'Radiologue':
                    $service = Service::where('slug', 'radiologie')->first();
                    break;
                case 'Biologiste Médical':
                    $service = Service::where('slug', 'laboratoire')->first();
                    break;
                default:
                    $service = null;
            }
            if ($service) {
                $medecin->services()->attach($service->id);
            }
        }

        $this->command->info('✅ 8 médecins créés et associés à leurs services !');
    }
}
