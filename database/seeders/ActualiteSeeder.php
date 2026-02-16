<?php

namespace Database\Seeders;

use App\Models\Actualite;
use Illuminate\Database\Seeder;

class ActualiteSeeder extends Seeder
{
    public function run(): void
    {
        $actualites = [
            [
                'titre' => 'Nouvelle Unité de Cardiologie à l\'HRA Dschang',
                'extrait' => 'L\'HRA franchit une nouvelle étape avec l\'ouverture d\'une unité de cardiologie moderne équipée des dernières technologies.',
                'contenu' => 'L\'Hôpital Régional Annexe de Dschang est fier d\'annoncer l\'ouverture de sa nouvelle unité de cardiologie interventionnelle. Cette unité de dernière génération permettra de prendre en charge efficacement les maladies cardiovasculaires qui touchent une part croissante de la population.

Des équipements de pointe
L\'unité est équipée d\'un électrocardiographe numérique, d\'un échographe cardiaque Doppler et d\'un système de monitoring avancé. Ces équipements permettront des diagnostics plus précis et des traitements plus efficaces.

Une équipe spécialisée
Deux cardiologues expérimentés rejoignent l\'équipe de l\'HRA pour accompagner le lancement de cette nouvelle unité. Des formations continues sont prévues pour l\'ensemble du personnel.

Les consultations de cardiologie sont disponibles du lundi au vendredi de 8h à 17h. Pour prendre rendez-vous, contactez le +237 233 XX XX XX.',
                'image' => '/images/actualites/cardiologie.jpg',
                'categorie' => 'Événements',
                'auteur' => 'Dr. Marie Kouassi',
                'publie' => true,
                'date_publication' => now()->subDays(2),
            ],
            [
                'titre' => '10 Aliments pour Renforcer votre Système Immunitaire',
                'extrait' => 'Découvrez les super-aliments qui peuvent aider à booster naturellement vos défenses immunitaires.',
                'contenu' => 'Un système immunitaire fort est votre première ligne de défense contre les maladies. Voici 10 aliments à intégrer dans votre alimentation quotidienne.

1. Les agrumes
Riches en vitamine C, les oranges, citrons et pamplemousses stimulent la production de globules blancs.

2. Le gingembre
Ses propriétés anti-inflammatoires aident à combattre les infections et réduire l\'inflammation.

3. L\'ail
Reconnu pour ses propriétés antibactériennes et antivirales naturelles.

4. Le curcuma
Cette épice dorée contient de la curcumine, un puissant antioxydant.

5. Les épinards
Riches en vitamines C, bêta-carotène et antioxydants.

Consultez nos nutritionnistes à l\'HRA pour un plan alimentaire personnalisé.',
                'image' => '/images/actualites/nutrition.jpg',
                'categorie' => 'Nutrition',
                'auteur' => 'Dr. Jean Mbala',
                'publie' => true,
                'date_publication' => now()->subDays(5),
            ],
            [
                'titre' => 'Hypertension : Les Signes à ne pas Ignorer',
                'extrait' => 'L\'hypertension artérielle est souvent silencieuse. Apprenez à reconnaître les symptômes.',
                'contenu' => 'L\'hypertension artérielle touche plus de 30% des adultes au Cameroun. Souvent appelée "tueuse silencieuse", elle peut causer de graves complications si elle n\'est pas traitée.

Les signes d\'alerte

Maux de tête persistants, surtout le matin
Vertiges ou étourdissements
Vision floue
Douleurs thoraciques
Essoufflement
Saignements de nez fréquents


Facteurs de risque
L\'âge, l\'obésité, le manque d\'exercice, une alimentation trop salée, le stress et les antécédents familiaux augmentent les risques.

Prévention
Adoptez une alimentation équilibrée, pratiquez une activité physique régulière, limitez le sel et l\'alcool, et faites contrôler votre tension régulièrement.

L\'HRA propose des dépistages gratuits tous les premiers mercredis du mois.',
                'image' => '/images/actualites/hypertension.jpg',
                'categorie' => 'Prévention',
                'auteur' => 'Dr. Sarah Toumi',
                'publie' => true,
                'date_publication' => now()->subDays(7),
            ],
            [
                'titre' => 'L\'Exercice Physique : Un Médicament Naturel',
                'extrait' => 'Découvrez comment 30 minutes d\'activité physique par jour peuvent transformer votre santé.',
                'contenu' => 'L\'activité physique régulière est l\'un des investissements les plus importants que vous pouvez faire pour votre santé. Les bénéfices sont multiples et scientifiquement prouvés.

Bénéfices sur la santé physique

Renforce le système cardiovasculaire
Aide à maintenir un poids santé
Améliore la densité osseuse
Réduit le risque de diabète de type 2
Renforce le système immunitaire


Bénéfices sur la santé mentale

Réduit le stress et l\'anxiété
Améliore la qualité du sommeil
Augmente la confiance en soi
Libère des endorphines (hormones du bonheur)


Comment commencer ?
Inutile de viser la performance ! 30 minutes de marche rapide par jour suffisent. L\'important est la régularité.',
                'image' => '/images/actualites/sport.jpg',
                'categorie' => 'Sport & Santé',
                'auteur' => 'Dr. Paul Ndjock',
                'publie' => true,
                'date_publication' => now()->subDays(10),
            ],
            [
                'titre' => 'Guide Complet de la Grossesse Trimestre par Trimestre',
                'extrait' => 'Suivez l\'évolution de votre grossesse avec nos conseils d\'experts pour chaque étape.',
                'contenu' => 'La grossesse est une aventure extraordinaire qui dure environ 40 semaines, divisées en trois trimestres. Voici ce à quoi vous pouvez vous attendre.

Premier trimestre (Semaines 1-12)
C\'est la période des grands changements. Fatigue, nausées et sensibilité des seins sont courants. Le fœtus se développe rapidement : formation des organes vitaux.
À faire : Première consultation prénatale, prise d\'acide folique, éviter alcool et tabac.

Deuxième trimestre (Semaines 13-26)
Souvent appelé "lune de miel de la grossesse". Les nausées diminuent, l\'énergie revient. Vous commencez à sentir bébé bouger vers 20 semaines.
À faire : Échographie morphologique, continuer les consultations mensuelles.

Troisième trimestre (Semaines 27-40)
Le bébé grandit rapidement. Vous pouvez ressentir fatigue, essoufflement, contractions de Braxton Hicks. Préparez votre sac pour la maternité.
À faire : Consultations plus rapprochées, cours de préparation à l\'accouchement.

Notre service de maternité est disponible 24/7. Contactez-nous pour un suivi personnalisé.',
                'image' => '/images/actualites/grossesse.jpg',
                'categorie' => 'Maternité',
                'auteur' => 'Dr. Aïcha Diallo',
                'publie' => true,
                'date_publication' => now()->subDays(12),
            ],
            [
                'titre' => 'Gérer le Stress au Quotidien : Techniques Efficaces',
                'extrait' => 'Le stress chronique peut avoir des effets néfastes sur votre santé. Découvrez des stratégies éprouvées.',
                'contenu' => 'Le stress fait partie de la vie, mais lorsqu\'il devient chronique, il peut nuire gravement à votre santé physique et mentale.

Reconnaître les signes du stress chronique

Troubles du sommeil
Irritabilité
Maux de tête fréquents
Problèmes digestifs
Difficulté à se concentrer


Techniques de gestion du stress

1. La respiration profonde
Inspirez lentement par le nez pendant 4 secondes, retenez 4 secondes, expirez par la bouche pendant 6 secondes. Répétez 5 fois.

2. La méditation
10 minutes par jour peuvent réduire significativement le niveau de stress.

3. L\'activité physique
L\'exercice libère des endorphines et aide à évacuer les tensions.

4. Organiser son temps
Priorisez vos tâches, apprenez à dire non, déléguer quand c\'est possible.

Si le stress devient ingérable, n\'hésitez pas à consulter. Notre service de santé mentale est là pour vous.',
                'image' => '/images/actualites/stress.jpg',
                'categorie' => 'Santé Mentale',
                'auteur' => 'Dr. Fatou Sow',
                'publie' => true,
                'date_publication' => now()->subDays(15),
            ],
        ];

        foreach ($actualites as $actualite) {
            Actualite::create($actualite);
        }
    }
}

