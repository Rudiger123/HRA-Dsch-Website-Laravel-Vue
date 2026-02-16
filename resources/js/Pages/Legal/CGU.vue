<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import {
  FileText, CheckCircle, XCircle, AlertTriangle,
  Shield, Scale, Mail, Globe
} from 'lucide-vue-next'
</script>

<template>
  <Head title="Conditions Générales d'Utilisation - HRA Dschang" />

  <AppLayout>
    <!-- Hero Section -->
    <section class="gradient-hrad py-16 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center animate-fade-in-down">
          <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6">
            <FileText :size="40" />
          </div>
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Conditions Générales d'Utilisation</h1>
          <p class="text-xl text-primary-100">
            Règles d'utilisation du site web de l'HRA Dschang
          </p>
        </div>
      </div>
    </section>

    <!-- Contenu -->
    <section class="py-16 bg-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Info mise à jour -->
        <div class="bg-primary-50 border-l-4 border-primary-600 p-6 mb-8 rounded-r-lg animate-fade-in">
          <div class="flex items-start">
            <AlertTriangle :size="24" class="text-primary-600 mr-4 flex-shrink-0 mt-1" />
            <div>
              <h3 class="font-semibold text-gray-900 mb-2">Dernière mise à jour</h3>
              <p class="text-gray-700">Ces conditions générales d'utilisation ont été mises à jour le 14 février 2026.</p>
            </div>
          </div>
        </div>

        <!-- Introduction -->
        <div class="mb-12 animate-fade-in-up">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Préambule</h2>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              Les présentes Conditions Générales d'Utilisation (ci-après « CGU ») régissent l'accès et l'utilisation du site web de l'Hôpital Régional Annexe de Dschang (ci-après « HRA Dschang » ou « nous »), accessible à l'adresse www.hradschang.cm.
            </p>
            <p>
              En accédant ou en utilisant ce site, vous acceptez sans réserve les présentes CGU. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser ce site.
            </p>
          </div>
        </div>

        <!-- 1. Objet -->
        <div class="mb-12 animate-fade-in-up animation-delay-200">
          <div class="flex items-center gap-3 mb-6 pb-3 border-b-2 border-primary-600">
            <Globe :size="28" class="text-primary-600" />
            <h2 class="text-2xl font-bold text-gray-900">1. Objet du site</h2>
          </div>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              Le site www.hradschang.cm a pour objet de :
            </p>
            <ul class="list-disc ml-6 space-y-2">
              <li>Présenter les services médicaux de l'HRA Dschang</li>
              <li>Permettre la prise de rendez-vous médical en ligne</li>
              <li>Fournir des informations sur l'équipe médicale</li>
              <li>Diffuser des informations de santé publique</li>
              <li>Faciliter la communication entre les patients et l'hôpital</li>
            </ul>
          </div>
        </div>

        <!-- 2. Accès au site -->
        <div class="mb-12 animate-fade-in-up animation-delay-300">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            2. Accès au site
          </h2>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
              <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                <CheckCircle :size="20" class="text-green-600" />
                Accès libre
              </h4>
              <p>
                Le site est accessible gratuitement à tout utilisateur disposant d'un accès Internet. Tous les frais liés à l'accès au site (matériel informatique, connexion Internet, etc.) sont à la charge de l'utilisateur.
              </p>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg">
              <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                <AlertTriangle :size="20" class="text-yellow-600" />
                Disponibilité
              </h4>
              <p>
                L'HRA Dschang met tout en œuvre pour assurer la disponibilité du site 24h/24 et 7j/7. Toutefois, nous nous réservons le droit d'interrompre temporairement l'accès au site pour des raisons de maintenance, de mise à jour ou pour toute autre raison technique.
              </p>
            </div>

            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
              <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                <XCircle :size="20" class="text-red-600" />
                Responsabilité
              </h4>
              <p>
                L'HRA Dschang ne saurait être tenu responsable des interruptions de service, quelle qu'en soit la cause, et des conséquences qui pourraient en découler pour l'utilisateur.
              </p>
            </div>
          </div>
        </div>

        <!-- 3. Utilisation du site -->
        <div class="mb-12 animate-fade-in-up animation-delay-400">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            3. Utilisation du site
          </h2>

          <div class="space-y-6">
            <div>
              <h3 class="text-xl font-semibold text-gray-900 mb-3">3.1 Utilisation conforme</h3>
              <p class="text-gray-700 mb-3">L'utilisateur s'engage à utiliser le site de manière loyale et conforme à sa destination. Il est notamment interdit de :</p>
              <ul class="list-disc ml-6 space-y-2 text-gray-700">
                <li>Utiliser le site à des fins illégales ou frauduleuses</li>
                <li>Tenter d'accéder de manière non autorisée au site ou aux systèmes informatiques de l'HRA</li>
                <li>Diffuser des virus, logiciels malveillants ou tout code nuisible</li>
                <li>Collecter ou stocker des données personnelles d'autres utilisateurs</li>
                <li>Usurper l'identité d'une autre personne</li>
                <li>Perturber le fonctionnement normal du site</li>
              </ul>
            </div>

            <div>
              <h3 class="text-xl font-semibold text-gray-900 mb-3">3.2 Demandes de rendez-vous</h3>
              <div class="bg-gray-50 rounded-lg p-5">
                <p class="text-gray-700 mb-3">
                  Les demandes de rendez-vous effectuées via le site sont des <strong>demandes préalables</strong> et non des confirmations définitives.
                </p>
                <div class="space-y-2 text-sm text-gray-600">
                  <p>✅ Nous vous contacterons pour confirmer votre rendez-vous</p>
                  <p>✅ Délai de réponse : sous 24h ouvrées</p>
                  <p>✅ En cas d'urgence, contactez directement le +237 233 XX XX XX</p>
                </div>
              </div>
            </div>

            <div>
              <h3 class="text-xl font-semibold text-gray-900 mb-3">3.3 Messages de contact</h3>
              <p class="text-gray-700">
                Les messages envoyés via le formulaire de contact sont traités dans un délai de 48h ouvrées. Pour les urgences médicales, veuillez contacter directement notre service d'urgence.
              </p>
            </div>
          </div>
        </div>

        <!-- 4. Informations médicales -->
        <div class="mb-12 animate-fade-in-up animation-delay-600">
          <div class="flex items-center gap-3 mb-6 pb-3 border-b-2 border-primary-600">
            <Shield :size="28" class="text-primary-600" />
            <h2 class="text-2xl font-bold text-gray-900">4. Informations médicales</h2>
          </div>

          <div class="bg-danger-50 border-l-4 border-danger-600 p-6 rounded-r-lg">
            <h4 class="font-bold text-danger-900 mb-3 flex items-center gap-2">
              <AlertTriangle :size="24" />
              ⚠️ AVERTISSEMENT IMPORTANT
            </h4>
            <div class="space-y-3 text-gray-700">
              <p>
                Les informations médicales présentes sur ce site sont fournies à <strong>titre informatif uniquement</strong> et ne constituent en aucun cas :
              </p>
              <ul class="list-disc ml-6 space-y-2">
                <li>Un diagnostic médical</li>
                <li>Une prescription médicale</li>
                <li>Un avis médical personnalisé</li>
                <li>Un substitut à une consultation médicale</li>
              </ul>
              <p class="font-semibold text-danger-900 mt-4">
                En cas de problème de santé, consultez toujours un professionnel de santé qualifié.
              </p>
            </div>
          </div>
        </div>

        <!-- 5. Propriété intellectuelle -->
        <div class="mb-12 animate-fade-in-up animation-delay-900">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            5. Propriété intellectuelle
          </h2>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              L'ensemble des éléments du site (textes, images, graphismes, logos, icônes, sons, logiciels, etc.) est la propriété exclusive de l'HRA Dschang ou fait l'objet d'une autorisation d'utilisation.
            </p>
            <p>
              Toute reproduction, représentation, modification, publication ou adaptation de tout ou partie des éléments du site, quel que soit le moyen ou le procédé utilisé, est interdite sans l'autorisation écrite préalable de l'HRA Dschang.
            </p>
            <div class="bg-gray-50 rounded-lg p-5">
              <h4 class="font-semibold text-gray-900 mb-2">Exception : Usage personnel</h4>
              <p class="text-sm">
                Vous pouvez consulter et télécharger les pages du site pour un usage strictement personnel et privé, à l'exclusion de toute utilisation à des fins commerciales ou publicitaires.
              </p>
            </div>
          </div>
        </div>

        <!-- 6. Données personnelles -->
        <div class="mb-12 animate-fade-in-up animation-delay-1000">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            6. Protection des données personnelles
          </h2>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              Le traitement de vos données personnelles est effectué conformément à notre Politique de Confidentialité et à la réglementation camerounaise en vigueur.
            </p>
            <p>
              Pour plus d'informations sur la collecte, le traitement, la conservation et la protection de vos données personnelles, veuillez consulter notre
              <Link href="/confidentialite" class="text-primary-600 hover:underline font-semibold">Politique de Confidentialité</Link>.
            </p>
          </div>
        </div>

        <!-- 7. Liens externes -->
        <div class="mb-12 animate-fade-in-up">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            7. Liens hypertextes
          </h2>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              Le site peut contenir des liens hypertextes vers d'autres sites web. L'HRA Dschang n'exerce aucun contrôle sur ces sites externes et décline toute responsabilité quant à leur contenu, leur disponibilité ou leur politique de confidentialité.
            </p>
            <p>
              La présence de liens vers des sites tiers n'implique pas l'approbation ou l'endossement de ces sites par l'HRA Dschang.
            </p>
          </div>
        </div>

        <!-- 8. Limitation de responsabilité -->
        <div class="mb-12 animate-fade-in-up">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            8. Limitation de responsabilité
          </h2>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              L'HRA Dschang s'efforce d'assurer l'exactitude et la mise à jour des informations diffusées sur ce site. Toutefois, nous ne pouvons garantir :
            </p>
            <ul class="list-disc ml-6 space-y-2">
              <li>L'exactitude, la précision ou l'exhaustivité des informations</li>
              <li>L'absence d'erreurs techniques ou typographiques</li>
              <li>La disponibilité continue du site</li>
              <li>L'absence de virus ou autres éléments nuisibles</li>
            </ul>
            <p class="mt-4">
              En conséquence, l'utilisateur reconnaît utiliser le site à ses propres risques. L'HRA Dschang ne saurait être tenu responsable des dommages directs ou indirects résultant de l'accès au site ou de l'utilisation des informations qui y figurent.
            </p>
          </div>
        </div>

        <!-- 9. Modification des CGU -->
        <div class="mb-12 animate-fade-in-up">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            9. Modification des CGU
          </h2>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              L'HRA Dschang se réserve le droit de modifier les présentes CGU à tout moment. Les nouvelles CGU seront applicables dès leur mise en ligne sur le site.
            </p>
            <p>
              Il est recommandé de consulter régulièrement cette page pour prendre connaissance des éventuelles modifications. L'utilisation continue du site après modification des CGU vaut acceptation de ces modifications.
            </p>
          </div>
        </div>

        <!-- 10. Droit applicable -->
        <div class="mb-12 animate-fade-in-up">
          <div class="flex items-center gap-3 mb-6 pb-3 border-b-2 border-primary-600">
            <Scale :size="28" class="text-primary-600" />
            <h2 class="text-2xl font-bold text-gray-900">10. Droit applicable et juridiction</h2>
          </div>
          <div class="space-y-4 text-gray-700 leading-relaxed bg-gray-50 rounded-lg p-6">
            <p>
              Les présentes CGU sont régies par le droit camerounais. Tout litige relatif à l'interprétation ou à l'exécution des présentes CGU sera soumis aux tribunaux compétents de Dschang, Cameroun.
            </p>
            <p>
              En cas de différend, les parties s'engagent à rechercher une solution amiable avant toute action judiciaire.
            </p>
          </div>
        </div>

        <!-- Contact -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl p-8 text-white">
          <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
            <Mail :size="28" />
            Questions sur les CGU ?
          </h2>
          <div class="space-y-3">
            <p>Pour toute question concernant ces conditions générales d'utilisation :</p>
            <div class="grid md:grid-cols-2 gap-4 mt-4">
              <div class="bg-white/10 rounded-lg p-4">
                <p class="font-semibold mb-2">📧 Email</p>
                <a href="mailto:contact@hradschang.cm" class="text-secondary-300 hover:text-secondary-200">contact@hradschang.cm</a>
              </div>
              <div class="bg-white/10 rounded-lg p-4">
                <p class="font-semibold mb-2">📞 Téléphone</p>
                <a href="tel:+237233XXXXXX" class="text-secondary-300 hover:text-secondary-200">+237 233 XX XX XX</a>
              </div>
              <div class="bg-white/10 rounded-lg p-4">
                <p class="font-semibold mb-2">📮 Courrier</p>
                <p class="text-primary-100">HRA Dschang, BP 1234, Dschang, Cameroun</p>
              </div>
              <div class="bg-white/10 rounded-lg p-4">
                <p class="font-semibold mb-2">💬 Formulaire</p>
                <Link href="/contact" class="text-secondary-300 hover:text-secondary-200 underline">Page de contact</Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Liens vers autres pages légales -->
    <section class="py-12 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl font-bold text-gray-900 text-center mb-8">Documents légaux associés</h3>
        <div class="grid md:grid-cols-2 gap-6 max-w-3xl mx-auto">
          <Link
            href="/mentions-legales"
            class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition group"
          >
            <div class="flex items-center mb-3">
              <FileText :size="24" class="text-primary-600 mr-3" />
              <h4 class="font-bold text-gray-900 group-hover:text-primary-600 transition">
                Mentions Légales
              </h4>
            </div>
            <p class="text-gray-600 text-sm">
              Informations légales et réglementaires de l'HRA Dschang
            </p>
          </Link>

          <Link
            href="/confidentialite"
            class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition group"
          >
            <div class="flex items-center mb-3">
              <Shield :size="24" class="text-primary-600 mr-3" />
              <h4 class="font-bold text-gray-900 group-hover:text-primary-600 transition">
                Politique de Confidentialité
              </h4>
            </div>
            <p class="text-gray-600 text-sm">
              Comment nous protégeons vos données personnelles
            </p>
          </Link>
        </div>
      </div>
    </section>
  </AppLayout>
</template>
