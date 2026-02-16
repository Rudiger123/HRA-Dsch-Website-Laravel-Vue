<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import {
  FileText, Building2, Server, Copyright,
  Shield, Mail, Phone, MapPin, Scale
} from 'lucide-vue-next'
</script>

<template>
  <Head title="Mentions Légales - HRA Dschang" />

  <AppLayout>
    <!-- Hero Section -->
    <section class="gradient-hrad py-16 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center animate-fade-in-down">
          <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6">
            <FileText :size="40" />
          </div>
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Mentions Légales</h1>
          <p class="text-xl text-primary-100">
            Informations légales et réglementaires de l'HRA Dschang
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
            <Shield :size="24" class="text-primary-600 mr-4 flex-shrink-0 mt-1" />
            <div>
              <h3 class="font-semibold text-gray-900 mb-2">Dernière mise à jour</h3>
              <p class="text-gray-700">Ces mentions légales ont été mises à jour le 14 février 2026.</p>
            </div>
          </div>
        </div>

        <!-- 1. Éditeur du site -->
        <div class="mb-12 animate-fade-in-up">
          <div class="flex items-center gap-3 mb-6 pb-3 border-b-2 border-primary-600">
            <Building2 :size="28" class="text-primary-600" />
            <h2 class="text-2xl font-bold text-gray-900">1. Éditeur du site</h2>
          </div>
          <div class="space-y-3 text-gray-700 leading-relaxed bg-gray-50 rounded-lg p-6">
            <p><strong class="text-gray-900">Raison sociale :</strong> Hôpital Régional Annexe de Dschang (HRA Dschang)</p>
            <p><strong class="text-gray-900">Forme juridique :</strong> Établissement hospitalier public</p>
            <p><strong class="text-gray-900">Siège social :</strong> Dschang, Région de l'Ouest, Cameroun</p>
            <p><strong class="text-gray-900">Numéro d'immatriculation :</strong> RC/DSG/2024/H/001</p>
            <p><strong class="text-gray-900">Autorisation d'exploitation :</strong> N° AE-2024-HRA délivrée par le Ministère de la Santé Publique du Cameroun</p>
            <div class="pt-4 border-t border-gray-200">
              <p class="font-semibold text-gray-900 mb-2">Coordonnées :</p>
              <div class="space-y-2 ml-4">
                <p class="flex items-center gap-2">
                  <Phone :size="16" class="text-primary-600" />
                  +237 233 XX XX XX
                </p>
                <p class="flex items-center gap-2">
                  <Mail :size="16" class="text-primary-600" />
                  <a href="mailto:contact@hradschang.cm" class="text-primary-600 hover:underline">contact@hradschang.cm</a>
                </p>
                <p class="flex items-center gap-2">
                  <MapPin :size="16" class="text-primary-600" />
                  Dschang, Région de l'Ouest, Cameroun
                </p>
              </div>
            </div>
            <p class="pt-4 border-t border-gray-200">
              <strong class="text-gray-900">Directeur de la publication :</strong> Dr. Emmanuel Fotso, Directeur de l'HRA Dschang
            </p>
          </div>
        </div>

        <!-- 2. Hébergement -->
        <div class="mb-12 animate-fade-in-up animation-delay-200">
          <div class="flex items-center gap-3 mb-6 pb-3 border-b-2 border-primary-600">
            <Server :size="28" class="text-primary-600" />
            <h2 class="text-2xl font-bold text-gray-900">2. Hébergement du site</h2>
          </div>
          <div class="space-y-3 text-gray-700 leading-relaxed bg-gray-50 rounded-lg p-6">
            <p><strong class="text-gray-900">Hébergeur :</strong> [Nom de l'hébergeur]</p>
            <p><strong class="text-gray-900">Adresse :</strong> [Adresse complète de l'hébergeur]</p>
            <p><strong class="text-gray-900">Téléphone :</strong> [Numéro de téléphone]</p>
            <p><strong class="text-gray-900">Site web :</strong> <a href="#" class="text-primary-600 hover:underline">[URL de l'hébergeur]</a></p>
          </div>
        </div>

        <!-- 3. Propriété intellectuelle -->
        <div class="mb-12 animate-fade-in-up animation-delay-300">
          <div class="flex items-center gap-3 mb-6 pb-3 border-b-2 border-primary-600">
            <Copyright :size="28" class="text-primary-600" />
            <h2 class="text-2xl font-bold text-gray-900">3. Propriété intellectuelle</h2>
          </div>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              L'ensemble du contenu de ce site (structure, textes, logos, images, vidéos, sons, bases de données, logiciels, etc.) est la propriété exclusive de l'HRA Dschang ou fait l'objet d'une autorisation d'utilisation.
            </p>
            <p>
              Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des éléments du site, quel que soit le moyen ou le procédé utilisé, est interdite, sauf autorisation écrite préalable de l'HRA Dschang.
            </p>
            <p>
              Toute exploitation non autorisée du site ou de l'un des éléments qu'il contient sera considérée comme constitutive d'une contrefaçon et poursuivie conformément aux dispositions légales en vigueur au Cameroun.
            </p>
            <p>
              Les marques et logos présents sur le site sont des marques déposées par l'HRA Dschang ou par des tiers. Toute utilisation de ces marques sans autorisation expresse est strictement interdite.
            </p>
          </div>
        </div>

        <!-- 4. Responsabilité -->
        <div class="mb-12 animate-fade-in-up animation-delay-400">
          <div class="flex items-center gap-3 mb-6 pb-3 border-b-2 border-primary-600">
            <Shield :size="28" class="text-primary-600" />
            <h2 class="text-2xl font-bold text-gray-900">4. Limitation de responsabilité</h2>
          </div>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              L'HRA Dschang s'efforce d'assurer l'exactitude et la mise à jour des informations diffusées sur ce site. Toutefois, nous ne pouvons garantir l'exactitude, la précision ou l'exhaustivité des informations mises à disposition.
            </p>
            <div class="bg-secondary-50 border-l-4 border-secondary-500 p-4 rounded-r-lg my-4">
              <p class="font-semibold text-gray-900 mb-2">⚠️ Important - Informations médicales</p>
              <p>
                Les informations médicales présentes sur ce site ont un caractère purement informatif et ne sauraient en aucun cas se substituer à une consultation médicale. En cas de doute, consultez toujours un professionnel de santé qualifié.
              </p>
            </div>
            <p>
              L'HRA Dschang ne pourra être tenu responsable des dommages directs ou indirects résultant de l'accès au site ou de l'utilisation des informations qui y figurent.
            </p>
            <p>
              L'utilisateur est seul responsable de l'utilisation qu'il fait des informations et contenus présents sur le site. L'HRA Dschang ne saurait être tenu responsable des éventuelles erreurs ou omissions.
            </p>
          </div>
        </div>

        <!-- 5. Liens hypertextes -->
        <div class="mb-12 animate-fade-in-up animation-delay-600">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            5. Liens hypertextes
          </h2>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              Le site peut contenir des liens hypertextes vers d'autres sites. L'HRA Dschang n'exerce aucun contrôle sur ces sites et décline toute responsabilité quant à leur contenu ou leur accessibilité.
            </p>
            <p>
              La mise en place d'un lien hypertexte vers le site de l'HRA Dschang nécessite une autorisation écrite préalable. Pour toute demande, veuillez nous contacter à l'adresse :
              <a href="mailto:contact@hradschang.cm" class="text-primary-600 hover:underline font-semibold">contact@hradschang.cm</a>
            </p>
          </div>
        </div>

        <!-- 6. Protection des données -->
        <div class="mb-12 animate-fade-in-up animation-delay-900">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            6. Protection des données personnelles
          </h2>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              L'HRA Dschang accorde une grande importance à la protection de vos données personnelles. Le traitement de vos données est effectué dans le respect de la réglementation camerounaise en vigueur.
            </p>
            <p>
              Pour plus d'informations sur la collecte, le traitement et la protection de vos données personnelles, nous vous invitons à consulter notre
              <Link href="/confidentialite" class="text-primary-600 hover:underline font-semibold">Politique de Confidentialité</Link>.
            </p>
          </div>
        </div>

        <!-- 7. Droit applicable -->
        <div class="mb-12 animate-fade-in-up animation-delay-1000">
          <div class="flex items-center gap-3 mb-6 pb-3 border-b-2 border-primary-600">
            <Scale :size="28" class="text-primary-600" />
            <h2 class="text-2xl font-bold text-gray-900">7. Droit applicable et juridiction</h2>
          </div>
          <div class="space-y-4 text-gray-700 leading-relaxed bg-gray-50 rounded-lg p-6">
            <p>
              Les présentes mentions légales sont régies par le droit camerounais. En cas de litige et à défaut d'accord amiable, le différend sera porté devant les tribunaux compétents de Dschang, Cameroun.
            </p>
          </div>
        </div>

        <!-- Contact -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl p-8 text-white">
          <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
            <Mail :size="28" />
            Nous contacter
          </h2>
          <div class="space-y-3">
            <p>Pour toute question concernant ces mentions légales, vous pouvez nous contacter par :</p>
            <div class="grid md:grid-cols-2 gap-4 mt-4">
              <div class="bg-white/10 rounded-lg p-4">
                <p class="font-semibold mb-2">📧 Email</p>
                <a href="mailto:legal@hradschang.cm" class="text-secondary-300 hover:text-secondary-200">legal@hradschang.cm</a>
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
              Comment nous collectons, utilisons et protégeons vos données personnelles
            </p>
          </Link>

          <Link
            href="/cgu"
            class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition group"
          >
            <div class="flex items-center mb-3">
              <FileText :size="24" class="text-primary-600 mr-3" />
              <h4 class="font-bold text-gray-900 group-hover:text-primary-600 transition">
                Conditions Générales
              </h4>
            </div>
            <p class="text-gray-600 text-sm">
              Conditions d'utilisation de notre site web et de nos services
            </p>
          </Link>
        </div>
      </div>
    </section>
  </AppLayout>
</template>
