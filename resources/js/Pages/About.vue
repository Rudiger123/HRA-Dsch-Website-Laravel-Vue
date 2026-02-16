<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import {
  Calendar, Users, Heart, Activity,
  DollarSign, Shield, Lightbulb,
  GraduationCap, CheckCircle, Award,
  BadgeCheck, Star, Zap, Target, HandshakeIcon
} from 'lucide-vue-next'
import { ref } from 'vue'

const certifications = [
  { id: 1, image: '/images/certifications/1.jpg', title: 'Certification ISO 9001:2015', desc: 'Qualité des services' },
  { id: 3, image: '/images/certifications/3.jpg', title: 'Accréditation Ministérielle', desc: 'Santé Publique' },
  { id: 5, image: '/images/certifications/5.jpg', title: 'Excellence Médicale', desc: 'Reconnaissance régionale' },
  { id: 6, image: '/images/certifications/6.jpg', title: 'Label Qualité', desc: 'Services aux patients' },
]

const hoveredCert = ref(null)
</script>

<template>
  <Head title="À Propos - HRA Dschang" />

  <AppLayout>
    <!-- Hero Section -->
    <section class="gradient-hrad min-h-[40vh] flex items-center justify-center text-white animate-fade-in-down">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">À Propos de l'HRA Dschang</h1>
        <p class="text-xl text-primary-100">Plus de 25 ans au service de votre santé</p>
      </div>
    </section>

    <!-- Histoire Section -->
    <section class="py-16 md:py-24 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <!-- Texte -->
          <div class="animate-slide-in-left">
            <span class="inline-block bg-primary-100 text-primary-700 text-sm font-semibold px-4 py-2 rounded-full">
              Notre Histoire
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-6 mb-6">
              Une tradition d'excellence médicale
            </h2>
            <div class="space-y-4 text-gray-600 leading-relaxed">
              <p>
                Fondé en 1998, l'Hôpital Régional Annexe (HRA) de Dschang est né d'une vision ambitieuse : offrir des soins médicaux de qualité mondiale à la population de la région tout en restant accessible à tous. Depuis sa création, notre établissement s'est imposé comme une référence incontournable en matière de santé publique.
              </p>
              <p>
                De modestes débuts avec une petite clinique privée, nous avons progressivement évolué pour devenir un hôpital moderne disposant de plus de 15 services spécialisés. Cette transformation s'est accompagnée d'investissements massifs dans l'infrastructure, l'équipement médical dernier cri et la formation continue de nos équipes.
              </p>
              <p>
                Aujourd'hui, l'HRA Dschang accueille annuellement plusieurs milliers de patients provenant de toute la région. Notre succès repose sur l'engagement inébranlable de nos médecins, infirmiers et personnel administratif qui œuvrent quotidiennement à l'amélioration de la santé de la communauté.
              </p>
            </div>
          </div>

          <!-- Cards Statistiques -->
          <div class="space-y-4 animate-slide-in-right">
            <!-- Card 1 -->
            <div class="bg-white rounded-xl shadow-lg p-6 flex items-center justify-between hover:shadow-xl transition-shadow duration-300 animation-delay-200">
              <div>
                <p class="text-4xl font-bold text-primary-600">1998</p>
                <p class="text-gray-600 font-medium">Année de fondation</p>
              </div>
              <Calendar :size="48" class="text-primary-500" />
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-xl shadow-lg p-6 flex items-center justify-between hover:shadow-xl transition-shadow duration-300 animation-delay-400">
              <div>
                <p class="text-4xl font-bold text-primary-600">50+</p>
                <p class="text-gray-600 font-medium">Professionnels de santé</p>
              </div>
              <Users :size="48" class="text-primary-500" />
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-xl shadow-lg p-6 flex items-center justify-between hover:shadow-xl transition-shadow duration-300 animation-delay-600">
              <div>
                <p class="text-4xl font-bold text-primary-600">15k+</p>
                <p class="text-gray-600 font-medium">Patients par an</p>
              </div>
              <Heart :size="48" class="text-danger-500" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Mission & Valeurs Section -->
    <section class="py-16 md:py-24 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            Notre Mission
          </h2>
          <p class="text-lg text-gray-600">
            Ce qui nous guide chaque jour
          </p>
        </div>

        <!-- Mission Cards -->
        <div class="grid md:grid-cols-3 gap-8">
          <!-- Card 1: Excellence -->
          <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition-shadow duration-300 animate-fade-in-up animation-delay-200">
            <div class="w-14 h-14 bg-primary-100 rounded-lg flex items-center justify-center mb-6">
              <Activity :size="32" class="text-primary-600" />
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">
              Excellence Médicale
            </h3>
            <p class="text-gray-600 leading-relaxed">
              Fournir des soins de la plus haute qualité en utilisant les dernières avancées médicales et les protocoles internationaux d'excellence.
            </p>
          </div>

          <!-- Card 2: Accessibilité -->
          <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition-shadow duration-300 animate-fade-in-up animation-delay-400">
            <div class="w-14 h-14 bg-secondary-100 rounded-lg flex items-center justify-center mb-6">
              <DollarSign :size="32" class="text-secondary-600" />
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">
              Accessibilité
            </h3>
            <p class="text-gray-600 leading-relaxed">
              Rendre les soins de santé accessibles à tous avec des tarifs adaptés et des plans de paiement flexibles pour chaque catégorie de patients.
            </p>
          </div>

          <!-- Card 3: Compassion -->
          <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition-shadow duration-300 animate-fade-in-up animation-delay-600">
            <div class="w-14 h-14 bg-danger-100 rounded-lg flex items-center justify-center mb-6">
              <Heart :size="32" class="text-danger-600" />
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">
              Compassion
            </h3>
            <p class="text-gray-600 leading-relaxed">
              Traiter chaque patient avec dignité, respect et empathie, en reconnaissant leur valeur comme personne et pas seulement comme cas médical.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Valeurs Fondamentales Section - PREMIUM DESIGN -->
    <section class="gradient-hrad py-16 md:py-28 text-white relative overflow-hidden">
      <!-- Fond décoratif -->
      <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -mr-48 -mt-48"></div>
      <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -ml-48 -mb-48"></div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
          <div class="inline-block mb-4">
            <span class="bg-white/20 text-white text-xs font-bold px-4 py-2 rounded-full backdrop-blur">✨ NOS PRINCIPES</span>
          </div>
          <h2 class="text-4xl text-white md:text-5xl font-bold mb-6">
            Nos Valeurs Fondamentales
          </h2>
          <p class="text-lg text-primary-100 max-w-3xl mx-auto leading-relaxed">
            Ces principes inébranlables guident chaque décision et chaque action au sein de notre établissement
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Intégrité -->
          <div class="group animate-fade-in-up animation-delay-200">
            <div class="bg-white/10 backdrop-blur-xl hover:bg-white/20 rounded-2xl p-8 transition-all duration-500 border border-white/20 hover:border-white/40 cursor-pointer">
              <div class="flex items-start gap-6">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                  <Shield :size="40" class="text-white" />
                </div>
                <div>
                  <h3 class="text-2xl font-bold mb-3">Intégrité</h3>
                  <p class="text-primary-100 leading-relaxed">
                    Honnêteté absolue et transparence dans toutes nos relations. Nous agissons selon nos principes, même lorsque personne ne nous regarde.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Innovation -->
          <div class="group animate-fade-in-up animation-delay-300">
            <div class="bg-white/10 backdrop-blur-xl hover:bg-white/20 rounded-2xl p-8 transition-all duration-500 border border-white/20 hover:border-white/40 cursor-pointer">
              <div class="flex items-start gap-6">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                  <Lightbulb :size="40" class="text-white" />
                </div>
                <div>
                  <h3 class="text-2xl font-bold mb-3">Innovation</h3>
                  <p class="text-primary-100 leading-relaxed">
                    Amélioration continue et adoption des technologies de pointe pour offrir les meilleurs soins possibles à nos patients.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Collaboration -->
          <div class="group animate-fade-in-up animation-delay-400">
            <div class="bg-white/10 backdrop-blur-xl hover:bg-white/20 rounded-2xl p-8 transition-all duration-500 border border-white/20 hover:border-white/40 cursor-pointer">
              <div class="flex items-start gap-6">
                <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                  <HandshakeIcon :size="40" class="text-white" />
                </div>
                <div>
                  <h3 class="text-2xl font-bold mb-3">Collaboration</h3>
                  <p class="text-primary-100 leading-relaxed">
                    Travail d'équipe remarquable où chaque voix compte. Ensemble, nous accomplissons l'impossible pour nos patients.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Formation Continue -->
          <div class="group animate-fade-in-up animation-delay-600">
            <div class="bg-white/10 backdrop-blur-xl hover:bg-white/20 rounded-2xl p-8 transition-all duration-500 border border-white/20 hover:border-white/40 cursor-pointer">
              <div class="flex items-start gap-6">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                  <GraduationCap :size="40" class="text-white" />
                </div>
                <div>
                  <h3 class="text-2xl font-bold mb-3">Excellence Professionnelle</h3>
                  <p class="text-primary-100 leading-relaxed">
                    Formation continue et développement constant de nos équipes pour maintenir les plus hauts standards de qualité médicale.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Certifications Creative Gallery Section -->
    <section class="py-16 md:py-24 bg-gradient-to-br from-gray-50 via-white to-primary-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <div class="inline-block mb-4">
            <span class="bg-primary-100 text-primary-700 text-xs font-bold px-4 py-2 rounded-full">🏆 RECONNAISSANCE</span>
          </div>
          <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Certifications & Accréditations
          </h2>
          <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            Des labels d'excellence qui témoignent de notre engagement envers la qualité
          </p>
        </div>

        <!-- Certifications Gallery -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
          <div
            v-for="cert in certifications"
            :key="cert.id"
            @mouseenter="hoveredCert = cert.id"
            @mouseleave="hoveredCert = null"
            class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 animate-scale-in cursor-pointer"
          >
            <!-- Image -->
            <img
              :src="cert.image"
              :alt="cert.title"
              class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
            />

            <!-- Overlay gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

            <!-- Content overlay -->
            <div class="absolute inset-0 flex flex-col justify-end p-6 text-white transform group-hover:translate-y-0 translate-y-2 transition-transform duration-300">
              <h3 class="text-lg font-bold mb-2">{{ cert.title }}</h3>
              <p class="text-sm text-primary-100">{{ cert.desc }}</p>
            </div>
          </div>
        </div>

        <!-- Text Info Grid -->
        <div class="grid md:grid-cols-3 gap-8">
          <!-- ISO Certification -->
          <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl p-8 transition-all duration-300 animate-fade-in-up animation-delay-200 border border-gray-100 hover:border-primary-300">
            <div class="inline-block w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
              <Award :size="28" class="text-blue-600" />
            </div>
            <h4 class="text-xl font-bold text-gray-900 mb-3">Certification ISO 9001:2015</h4>
            <p class="text-gray-600 leading-relaxed mb-4">
              Certifiée pour la qualité de nos services médicaux et administratifs selon les standards internationaux.
            </p>
            <div class="flex items-center gap-2 text-blue-600 text-sm font-semibold">
              <Zap :size="16" />
              <span>Validée depuis 2015</span>
            </div>
          </div>

          <!-- Ministry Accreditation -->
          <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl p-8 transition-all duration-300 animate-fade-in-up animation-delay-400 border border-gray-100 hover:border-primary-300">
            <div class="inline-block w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
              <BadgeCheck :size="28" class="text-green-600" />
            </div>
            <h4 class="text-xl font-bold text-gray-900 mb-3">Accréditation Ministérielle</h4>
            <p class="text-gray-600 leading-relaxed mb-4">
              Accréditée par le Ministère Camerounais de la Santé Publique avec renouvellement biennal positif.
            </p>
            <div class="flex items-center gap-2 text-green-600 text-sm font-semibold">
              <Target :size="16" />
              <span>Depuis 2005</span>
            </div>
          </div>

          <!-- Excellence Label -->
          <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl p-8 transition-all duration-300 animate-fade-in-up animation-delay-600 border border-gray-100 hover:border-primary-300">
            <div class="inline-block w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
              <Star :size="28" class="text-purple-600" />
            </div>
            <h4 class="text-xl font-bold text-gray-900 mb-3">Label Excellence</h4>
            <p class="text-gray-600 leading-relaxed mb-4">
              Reconnue pour sa contribution exceptionnelle au système de santé régional et son service client.
            </p>
            <div class="flex items-center gap-2 text-purple-600 text-sm font-semibold">
              <Heart :size="16" />
              <span>Récompensée</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Équipements Section -->
    <section class="py-16 md:py-24 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <div class="inline-block mb-4">
            <span class="bg-primary-100 text-primary-700 text-xs font-bold px-4 py-2 rounded-full">⚙️ INFRASTRUCTURE</span>
          </div>
          <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            Nos Équipements de Pointe
          </h2>
          <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            Des installations modernes au service de votre santé
          </p>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
          <!-- Équipements médecals -->
          <div class="animate-slide-in-left">
            <div class="space-y-4">
              <div class="flex items-start gap-4 group">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-primary-600 group-hover:scale-110 transition-all duration-300 shadow-md">
                  <CheckCircle :size="24" class="text-primary-600 group-hover:text-white transition-colors" />
                </div>
                <div class="group-hover:translate-x-2 transition-transform duration-300">
                  <p class="font-semibold text-gray-900 text-lg">Scanner IRM dernière génération</p>
                  <p class="text-gray-600 text-sm">Imagerie médicale haute résolution</p>
                </div>
              </div>

              <div class="flex items-start gap-4 group">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-primary-600 group-hover:scale-110 transition-all duration-300 shadow-md">
                  <CheckCircle :size="24" class="text-primary-600 group-hover:text-white transition-colors" />
                </div>
                <div class="group-hover:translate-x-2 transition-transform duration-300">
                  <p class="font-semibold text-gray-900 text-lg">Blocs opératoires modernes</p>
                  <p class="text-gray-600 text-sm">4 salles équipées de technologie avancée</p>
                </div>
              </div>

              <div class="flex items-start gap-4 group">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-primary-600 group-hover:scale-110 transition-all duration-300 shadow-md">
                  <CheckCircle :size="24" class="text-primary-600 group-hover:text-white transition-colors" />
                </div>
                <div class="group-hover:translate-x-2 transition-transform duration-300">
                  <p class="font-semibold text-gray-900 text-lg">Laboratoire d'analyse 24h/24</p>
                  <p class="text-gray-600 text-sm">Résultats rapides et fiables</p>
                </div>
              </div>

              <div class="flex items-start gap-4 group">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-primary-600 group-hover:scale-110 transition-all duration-300 shadow-md">
                  <CheckCircle :size="24" class="text-primary-600 group-hover:text-white transition-colors" />
                </div>
                <div class="group-hover:translate-x-2 transition-transform duration-300">
                  <p class="font-semibold text-gray-900 text-lg">Service d'urgence permanent</p>
                  <p class="text-gray-600 text-sm">Disponible 24h/24, 7j/7</p>
                </div>
              </div>

              <div class="flex items-start gap-4 group">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-primary-600 group-hover:scale-110 transition-all duration-300 shadow-md">
                  <CheckCircle :size="24" class="text-primary-600 group-hover:text-white transition-colors" />
                </div>
                <div class="group-hover:translate-x-2 transition-transform duration-300">
                  <p class="font-semibold text-gray-900 text-lg">Dossier médical électronique</p>
                  <p class="text-gray-600 text-sm">Gestion intégrée des patients</p>
                </div>
              </div>

              <div class="flex items-start gap-4 group">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-primary-600 group-hover:scale-110 transition-all duration-300 shadow-md">
                  <CheckCircle :size="24" class="text-primary-600 group-hover:text-white transition-colors" />
                </div>
                <div class="group-hover:translate-x-2 transition-transform duration-300">
                  <p class="font-semibold text-gray-900 text-lg">Ambulances médicalisées</p>
                  <p class="text-gray-600 text-sm">Transport sécurisé des patients</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Image illustration -->
          <div class="animate-slide-in-right">
            <img src="/images/hopital.jpg" alt="Infrastructure HRA Dschang" class="rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-500 w-full h-full object-cover" />
          </div>
        </div>
      </div>
    </section>

    <!-- Leadership Section - DIRECTEUR -->
    <section class="py-16 md:py-24 bg-gradient-to-r from-primary-50 via-white to-secondary-50">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <div class="inline-block mb-4">
            <span class="bg-primary-100 text-primary-700 text-xs font-bold px-4 py-2 rounded-full">👨‍💼 LEADERSHIP</span>
          </div>
          <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            À la Tête de Notre Mission
          </h2>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden animate-scale-in">
          <div class="grid md:grid-cols-2 gap-0">
            <!-- Image -->
            <div class="relative overflow-hidden h-96 md:h-auto">
              <img
                src="/images/hopital.jpg"
                alt="Directeur HRA Dschang"
                class="w-full h-full object-cover"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
              <div class="absolute bottom-0 left-0 right-0 p-6">
                <div class="w-20 h-20 bg-gradient-to-br from-primary-400 to-primary-600 rounded-2xl shadow-lg flex items-center justify-center">
                  <Heart :size="40" class="text-white" />
                </div>
              </div>
            </div>

            <!-- Content -->
            <div class="p-8 md:p-12 flex flex-col justify-center">
              <div class="mb-6">
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                  Dr. [Nom du Directeur]
                </h3>
                <p class="text-xl text-primary-600 font-semibold mb-4">Directeur Général</p>
                <div class="h-1 w-20 bg-gradient-to-r from-primary-600 to-secondary-500 rounded-full"></div>
              </div>

              <p class="text-gray-600 leading-relaxed mb-6">
                Avec plus de 20 ans d'expérience en administration hospitalière et gestion sanitaire moderne, le Directeur Général incarne l'engagement de l'HRA Dschang envers l'excellence médicale et l'innovation.
              </p>

              <div class="space-y-3 mb-8">
                <div class="flex items-center gap-3">
                  <Award :size="20" class="text-primary-600" />
                  <span class="text-gray-700">Dirigeant reconnu en santé publique camerounaise</span>
                </div>
                <div class="flex items-center gap-3">
                  <Star :size="20" class="text-secondary-600" />
                  <span class="text-gray-700">Vision stratégique pour l'HRA depuis 2010</span>
                </div>
                <div class="flex items-center gap-3">
                  <Lightbulb :size="20" class="text-primary-600" />
                  <span class="text-gray-700">Initiateur des programmes d'innovation médicale</span>
                </div>
              </div>

              <p class="text-sm text-gray-600 italic border-l-4 border-primary-600 pl-4">
                "Notre succès réside dans le dévouement de nos équipes et la confiance de nos patients. Chaque jour, nous nous efforçons de dépasser les attentes et d'offrir les meilleurs soins possibles."
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="gradient-hrad py-16 md:py-20 text-white relative overflow-hidden">
      <!-- Decorative background -->
      <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
      </div>

      <div class="max-w-4xl mx-auto px-4 text-primary-50 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 animate-fade-in-down">
          Rejoignez Notre Famille HRA
        </h2>
        <p class="text-lg text-primary-50 mb-8 animate-fade-in-up animation-delay-200">
          Que vous soyez patient cherchant des soins de qualité ou professionnel de santé désireux de rejoindre notre équipe, nous vous accueillons les bras ouverts. Votre bien-être et votre succès sont nos priorités.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animation-delay-400">
          <Link
            href="/rendez-vous"
            class="group relative bg-white text-primary-600 px-8 py-4 rounded-xl font-semibold inline-block overflow-hidden transition-all duration-500 transform hover:scale-105 hover:shadow-2xl"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              Prendre Rendez-vous
              <span class="group-hover:translate-x-1 transition-transform duration-300">→</span>
            </span>
            <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-primary-600 opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
          </Link>
          <Link
            href="/contact"
            class="group relative border-2 border-white text-white px-8 py-4 rounded-xl font-semibold inline-block overflow-hidden transition-all duration-500 transform hover:scale-105 hover:shadow-2xl hover:border-secondary-300"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              Nous Contacter
              <span class="group-hover:translate-x-1 transition-transform duration-300">→</span>
            </span>
            <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
          </Link>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<style scoped>
/* Animations avec delays additionnels si besoin */
</style>
