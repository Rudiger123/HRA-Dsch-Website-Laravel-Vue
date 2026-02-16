<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import {
  ShieldCheck, Database, Lock, Eye, Trash2,
  Download, XCircle, FileText, Mail, AlertTriangle
} from 'lucide-vue-next'
</script>

<template>
  <Head title="Politique de Confidentialité - HRA Dschang" />

  <AppLayout>
    <!-- Hero Section -->
    <section class="gradient-hrad py-16 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center animate-fade-in-down">
          <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6">
            <ShieldCheck :size="40" />
          </div>
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Politique de Confidentialité</h1>
          <p class="text-xl text-primary-100">
            Votre vie privée est notre priorité
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
              <p class="text-gray-700">Cette politique de confidentialité a été mise à jour le 14 février 2026.</p>
            </div>
          </div>
        </div>

        <!-- Introduction -->
        <div class="mb-12 animate-fade-in-up">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Introduction</h2>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              L'HRA Dschang accorde une importance primordiale à la protection de vos données personnelles et au respect de votre vie privée. Cette politique de confidentialité vous informe sur la manière dont nous collectons, utilisons, protégeons et partageons vos informations personnelles.
            </p>
            <p>
              En utilisant notre site web ou nos services, vous acceptez les pratiques décrites dans cette politique. Nous vous encourageons à lire attentivement ce document pour comprendre comment vos données sont traitées.
            </p>
          </div>
        </div>

        <!-- 1. Responsable du traitement -->
        <div class="mb-12 animate-fade-in-up animation-delay-200">
          <div class="flex items-center gap-3 mb-6 pb-3 border-b-2 border-primary-600">
            <Database :size="28" class="text-primary-600" />
            <h2 class="text-2xl font-bold text-gray-900">1. Responsable du traitement des données</h2>
          </div>
          <div class="space-y-3 text-gray-700 leading-relaxed bg-gray-50 rounded-lg p-6">
            <p><strong class="text-gray-900">Identité :</strong> Hôpital Régional Annexe de Dschang (HRA Dschang)</p>
            <p><strong class="text-gray-900">Adresse :</strong> Dschang, Région de l'Ouest, Cameroun</p>
            <p><strong class="text-gray-900">Email :</strong> <a href="mailto:dpo@hradschang.cm" class="text-primary-600 hover:underline">dpo@hradschang.cm</a></p>
            <p><strong class="text-gray-900">Délégué à la Protection des Données :</strong> Dr. Sophie Mvondo</p>
            <p><strong class="text-gray-900">Contact DPO :</strong> <a href="mailto:dpo@hradschang.cm" class="text-primary-600 hover:underline">dpo@hradschang.cm</a></p>
          </div>
        </div>

        <!-- 2. Données collectées -->
        <div class="mb-12 animate-fade-in-up animation-delay-300">
          <div class="flex items-center gap-3 mb-6 pb-3 border-b-2 border-primary-600">
            <Database :size="28" class="text-primary-600" />
            <h2 class="text-2xl font-bold text-gray-900">2. Données personnelles collectées</h2>
          </div>

          <div class="space-y-6">
            <!-- Données d'identification -->
            <div class="bg-blue-50 rounded-lg p-6">
              <h3 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2">
                <Eye :size="20" class="text-blue-600" />
                2.1 Données d'identification
              </h3>
              <ul class="list-disc ml-6 space-y-2 text-gray-700">
                <li>Nom et prénom</li>
                <li>Date et lieu de naissance</li>
                <li>Adresse postale</li>
                <li>Numéro de téléphone</li>
                <li>Adresse email</li>
              </ul>
            </div>

            <!-- Données médicales -->
            <div class="bg-danger-50 rounded-lg p-6">
              <h3 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2">
                <ShieldCheck :size="20" class="text-danger-600" />
                2.2 Données médicales (avec votre consentement)
              </h3>
              <p class="text-sm text-danger-700 mb-3 font-semibold">
                ⚕️ Conformément au secret médical
              </p>
              <ul class="list-disc ml-6 space-y-2 text-gray-700">
                <li>Motif de consultation</li>
                <li>Service médical demandé</li>
                <li>Historique de rendez-vous</li>
              </ul>
            </div>

            <!-- Données de navigation -->
            <div class="bg-purple-50 rounded-lg p-6">
              <h3 class="text-xl font-semibold text-gray-900 mb-3 flex items-center gap-2">
                <Eye :size="20" class="text-purple-600" />
                2.3 Données de navigation
              </h3>
              <ul class="list-disc ml-6 space-y-2 text-gray-700">
                <li>Adresse IP</li>
                <li>Type de navigateur et système d'exploitation</li>
                <li>Pages visitées et durée de visite</li>
                <li>Données de cookies</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- 3. Finalités du traitement -->
        <div class="mb-12 animate-fade-in-up animation-delay-400">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            3. Finalités du traitement des données
          </h2>

          <div class="space-y-4">
            <div class="bg-gray-50 rounded-lg p-5">
              <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                <span class="w-2 h-2 bg-primary-600 rounded-full"></span>
                Gestion des demandes de rendez-vous
              </h4>
              <p class="text-gray-700 ml-4">Traiter et confirmer vos demandes de rendez-vous médicaux.</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-5">
              <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                <span class="w-2 h-2 bg-primary-600 rounded-full"></span>
                Communication
              </h4>
              <p class="text-gray-700 ml-4">Répondre à vos messages via le formulaire de contact.</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-5">
              <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                <span class="w-2 h-2 bg-primary-600 rounded-full"></span>
                Amélioration de nos services
              </h4>
              <p class="text-gray-700 ml-4">Analyser l'utilisation du site pour améliorer l'expérience utilisateur.</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-5">
              <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                <span class="w-2 h-2 bg-primary-600 rounded-full"></span>
                Obligations légales
              </h4>
              <p class="text-gray-700 ml-4">Respecter nos obligations légales et réglementaires.</p>
            </div>
          </div>
        </div>

        <!-- 4. Durée de conservation -->
        <div class="mb-12 animate-fade-in-up animation-delay-600">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            4. Durée de conservation des données
          </h2>

          <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 border-b">Type de données</th>
                  <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 border-b">Durée de conservation</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr>
                  <td class="px-6 py-4 text-sm text-gray-700">Demandes de rendez-vous</td>
                  <td class="px-6 py-4 text-sm text-gray-700">3 ans après dernier contact</td>
                </tr>
                <tr class="bg-gray-50">
                  <td class="px-6 py-4 text-sm text-gray-700">Messages de contact</td>
                  <td class="px-6 py-4 text-sm text-gray-700">3 ans après traitement</td>
                </tr>
                <tr>
                  <td class="px-6 py-4 text-sm text-gray-700">Données de navigation</td>
                  <td class="px-6 py-4 text-sm text-gray-700">13 mois maximum</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- 5. Sécurité des données -->
        <div class="mb-12 animate-fade-in-up animation-delay-900">
          <div class="flex items-center gap-3 mb-6 pb-3 border-b-2 border-primary-600">
            <Lock :size="28" class="text-primary-600" />
            <h2 class="text-2xl font-bold text-gray-900">5. Sécurité et protection des données</h2>
          </div>

          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              L'HRA Dschang met en œuvre toutes les mesures techniques et organisationnelles appropriées pour garantir la sécurité de vos données :
            </p>
            <div class="grid md:grid-cols-2 gap-4 mt-6">
              <div class="bg-blue-50 rounded-lg p-5">
                <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                  <Lock :size="20" class="text-blue-600" />
                  Mesures techniques
                </h4>
                <ul class="text-sm space-y-1 ml-6 list-disc text-gray-700">
                  <li>Cryptage des données sensibles</li>
                  <li>Serveurs sécurisés</li>
                  <li>Pare-feu et antivirus</li>
                  <li>Sauvegardes régulières</li>
                  <li>Protocoles HTTPS</li>
                </ul>
              </div>
              <div class="bg-green-50 rounded-lg p-5">
                <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                  <ShieldCheck :size="20" class="text-green-600" />
                  Mesures organisationnelles
                </h4>
                <ul class="text-sm space-y-1 ml-6 list-disc text-gray-700">
                  <li>Accès limité aux personnes autorisées</li>
                  <li>Formation du personnel</li>
                  <li>Politique de mots de passe robustes</li>
                  <li>Audits de sécurité réguliers</li>
                  <li>Confidentialité contractuelle</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- 6. Vos droits -->
        <div class="mb-12 animate-fade-in-up animation-delay-1000">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            6. Vos droits sur vos données personnelles
          </h2>

          <p class="text-gray-700 mb-6">Conformément à la réglementation, vous disposez des droits suivants :</p>

          <div class="space-y-3">
            <div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded-r-lg">
              <h4 class="font-semibold text-gray-900 mb-1 flex items-center gap-2">
                <Eye :size="18" />
                Droit d'accès
              </h4>
              <p class="text-sm text-gray-700">Obtenir une copie de vos données personnelles</p>
            </div>

            <div class="border-l-4 border-green-500 bg-green-50 p-4 rounded-r-lg">
              <h4 class="font-semibold text-gray-900 mb-1 flex items-center gap-2">
                <FileText :size="18" />
                Droit de rectification
              </h4>
              <p class="text-sm text-gray-700">Corriger ou compléter vos données si inexactes</p>
            </div>

            <div class="border-l-4 border-red-500 bg-red-50 p-4 rounded-r-lg">
              <h4 class="font-semibold text-gray-900 mb-1 flex items-center gap-2">
                <Trash2 :size="18" />
                Droit à l'effacement
              </h4>
              <p class="text-sm text-gray-700">Demander la suppression de vos données</p>
            </div>

            <div class="border-l-4 border-purple-500 bg-purple-50 p-4 rounded-r-lg">
              <h4 class="font-semibold text-gray-900 mb-1 flex items-center gap-2">
                <XCircle :size="18" />
                Droit d'opposition
              </h4>
              <p class="text-sm text-gray-700">Vous opposer au traitement de vos données</p>
            </div>

            <div class="border-l-4 border-indigo-500 bg-indigo-50 p-4 rounded-r-lg">
              <h4 class="font-semibold text-gray-900 mb-1 flex items-center gap-2">
                <Download :size="18" />
                Droit à la portabilité
              </h4>
              <p class="text-sm text-gray-700">Recevoir vos données dans un format structuré</p>
            </div>
          </div>

          <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl p-6 mt-6">
            <h4 class="font-bold mb-3 text-lg">Comment exercer vos droits ?</h4>
            <p class="mb-4 text-primary-100">Pour exercer vos droits, contactez-nous :</p>
            <ul class="space-y-2">
              <li class="flex items-center gap-2">
                <Mail :size="16" />
                <strong>Email :</strong> dpo@hradschang.cm
              </li>
              <li class="flex items-center gap-2">
                <Mail :size="16" />
                <strong>Courrier :</strong> Service DPO, HRA Dschang, Dschang, Cameroun
              </li>
            </ul>
            <p class="mt-4 text-sm text-primary-100">
              Une pièce d'identité pourra vous être demandée. Nous vous répondrons dans un délai maximum d'un mois.
            </p>
          </div>
        </div>

        <!-- 7. Modifications -->
        <div class="mb-12 animate-fade-in-up">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-primary-600">
            7. Modifications de la politique
          </h2>
          <div class="space-y-4 text-gray-700 leading-relaxed">
            <p>
              L'HRA Dschang se réserve le droit de modifier cette politique de confidentialité à tout moment. Toute modification sera publiée sur cette page avec une nouvelle date de mise à jour.
            </p>
            <p>
              En cas de modification substantielle, nous vous en informerons par email ou via un avis visible sur notre site web.
            </p>
          </div>
        </div>

        <!-- Contact -->
        <div class="bg-gradient-to-r from-primary-50 to-primary-100 rounded-xl p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
            <Mail :size="28" class="text-primary-600" />
            Questions ou préoccupations ?
          </h2>
          <div class="space-y-3 text-gray-700">
            <p>Pour toute question concernant cette politique de confidentialité :</p>
            <div class="grid md:grid-cols-2 gap-4 mt-4">
              <div>
                <h4 class="font-semibold text-gray-900 mb-2">Délégué à la Protection des Données</h4>
                <ul class="space-y-2 text-sm">
                  <li class="flex items-center gap-2">
                    <span class="text-primary-600">👤</span> Dr. Sophie Mvondo
                  </li>
                  <li class="flex items-center gap-2">
                    <span class="text-primary-600">📧</span> dpo@hradschang.cm
                  </li>
                </ul>
              </div>
              <div>
                <h4 class="font-semibold text-gray-900 mb-2">Contact général</h4>
                <ul class="space-y-2 text-sm">
                  <li class="flex items-center gap-2">
                    <span class="text-primary-600">📧</span> contact@hradschang.cm
                  </li>
                  <li class="flex items-center gap-2">
                    <span class="text-primary-600">📍</span> Dschang, Cameroun
                  </li>
                  <li>
                    <Link href="/contact" class="text-primary-600 hover:underline">
                      💬 Formulaire de contact
                    </Link>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Liens vers autres documents -->
    <section class="py-12 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl font-bold text-gray-900 text-center mb-8">Documents associés</h3>
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
              Conditions d'utilisation du site et de nos services
            </p>
          </Link>
        </div>
      </div>
    </section>
  </AppLayout>
</template>
