<?php

namespace App\Traits;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

trait HasSEO
{
    /**
     * Configurer les meta tags SEO pour une page
     */
    protected function setSEO(array $data)
    {
        // Meta tags basiques
        SEOMeta::setTitle($data['title'] ?? config('seotools.meta.defaults.title'));
        SEOMeta::setDescription($data['description'] ?? config('seotools.meta.defaults.description'));
        SEOMeta::setCanonical($data['canonical'] ?? url()->current());
        SEOMeta::addKeyword($data['keywords'] ?? config('seotools.meta.defaults.keywords'));

        // Open Graph (Facebook, WhatsApp)
        OpenGraph::setTitle($data['title'] ?? config('seotools.opengraph.defaults.title'));
        OpenGraph::setDescription($data['description'] ?? config('seotools.opengraph.defaults.description'));
        OpenGraph::setUrl($data['canonical'] ?? url()->current());
        OpenGraph::setType($data['type'] ?? 'website');

        if (isset($data['image'])) {
            OpenGraph::addImage($data['image']);
        } else {
            OpenGraph::addImage(asset('/images/og-image.jpg'));
        }

        // Twitter Card
        TwitterCard::setTitle($data['title'] ?? config('seotools.twitter.defaults.title'));
        TwitterCard::setDescription($data['description'] ?? config('seotools.twitter.defaults.description'));
        TwitterCard::setType($data['twitter_card'] ?? 'summary_large_image');

        if (isset($data['image'])) {
            TwitterCard::setImage($data['image']);
        }
    }

    /**
     * Ajouter Schema.org JSON-LD
     */
    protected function setJsonLd(array $data)
    {
        JsonLd::setTitle($data['title'] ?? '');
        JsonLd::setDescription($data['description'] ?? '');
        JsonLd::setType($data['type'] ?? 'WebPage');
        JsonLd::addValue('url', $data['url'] ?? url()->current());
    }
}
