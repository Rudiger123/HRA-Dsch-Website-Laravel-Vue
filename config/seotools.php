<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'inertia' => env('SEO_TOOLS_INERTIA', false),
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "HRA Dschang - Hôpital Régional Annexe de Dschang", // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => 'Hôpital Régional Annexe de Dschang : soins médicaux de qualité. Services : Pédiatrie, Maternité, Cardiologie, Urgences 24/7. Prenez rendez-vous en ligne.', // set false to total remove
            'separator'    => ' | ',
            'keywords'     => ['hôpital dschang', 'hra dschang', 'médecin dschang', 'santé cameroun', 'urgences dschang', 'maternité dschang'],
            'canonical'    => null, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots'       => 'index, follow', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'HRA Dschang - Hôpital Régional Annexe', // set false to total remove
            'description' => 'Soins médicaux de qualité à Dschang. Pédiatrie, Maternité, Cardiologie, Chirurgie, Urgences 24/7.', // set false to total remove
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'type'        => 'website',
            'site_name'   => 'HRA Dschang',
            'images'      => ['/images/og-image.jpg'],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'summary_large_image',
            'site'        => '@hradschang',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'HRA Dschang - Hôpital Régional Annexe de Dschang', // set false to total remove
            'description' => 'Soins médicaux de qualité à Dschang', // set false to total remove
            'url'         => null, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type'        => 'WebPage',
            'images'      => ['/images/og-image.jpg'],
        ],
    ],
];
