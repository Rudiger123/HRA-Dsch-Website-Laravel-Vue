<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Service;
use App\Models\Medecin;
use App\Models\Actualite;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Générer le sitemap XML du site';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Page d'accueil
        $sitemap->add(
            Url::create('/')
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        // Pages statiques
        $staticPages = [
            '/services' => 0.9,
            '/equipe' => 0.8,
            '/tarifs' => 0.7,
            '/actualites' => 0.8,
            '/rendez-vous' => 0.9,
            '/contact' => 0.7,
            '/faq' => 0.6,
            '/a-propos' => 0.5,
        ];

        foreach ($staticPages as $url => $priority) {
            $sitemap->add(
                Url::create($url)
                    ->setPriority($priority)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        }

        // Services
        Service::actif()->get()->each(function (Service $service) use ($sitemap) {
            $sitemap->add(
                Url::create("/services/{$service->slug}")
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setLastModificationDate($service->updated_at)
            );
        });

        // Médecins
        Medecin::actif()->get()->each(function (Medecin $medecin) use ($sitemap) {
            $sitemap->add(
                Url::create("/equipe/{$medecin->slug}")
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setLastModificationDate($medecin->updated_at)
            );
        });

        // Actualités
        Actualite::publie()->get()->each(function (Actualite $actualite) use ($sitemap) {
            $sitemap->add(
                Url::create("/actualites/{$actualite->slug}")
                    ->setPriority(0.6)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setLastModificationDate($actualite->updated_at)
            );
        });

        // Sauvegarder
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ Sitemap généré avec succès : public/sitemap.xml');
    }
}
