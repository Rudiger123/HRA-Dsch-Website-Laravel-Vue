<script setup>
import { ref, onMounted } from 'vue'
import { useIntersectionObserver } from '@vueuse/core'
import AppLayout from '@/Layouts/AppLayout.vue'
import Button from '@/Components/Button.vue'
import ServiceCard from '@/Components/ServiceCard.vue'
import {
    Phone, Calendar, Heart, Users,
    Clock, MapPin, Award, Zap
} from 'lucide-vue-next'

// Props
const props = defineProps({
    services: {
        type: Array,
        default: () => []
    }
})

// Stats section avec Intersection Observer
const statsSection = ref(null)
const statsVisible = ref(false)
const stats = ref({
    patients: 0,
    services: 0,
    professionals: 0,
    hours: 24
})

useIntersectionObserver(statsSection, ([{ isIntersecting }]) => {
    if (isIntersecting && !statsVisible.value) {
        statsVisible.value = true
        animateStats()
    }
})

// Animation des compteurs avec easing
const animateStats = () => {
    const duration = 2000
    const steps = 60
    const interval = duration / steps

    const targetValues = {
        patients: 30000,
        services: 15,
        professionals: 50,
        hours: 24
    }

    let step = 0
    const timer = setInterval(() => {
        step++
        const progress = step / steps
        // Ease out quart pour animation fluide
        const easeOutQuart = 1 - Math.pow(1 - progress, 4)

        stats.value.patients = Math.floor(targetValues.patients * easeOutQuart)
        stats.value.services = Math.floor(targetValues.services * easeOutQuart)
        stats.value.professionals = Math.floor(targetValues.professionals * easeOutQuart)

        if (step >= steps) {
            clearInterval(timer)
            stats.value.patients = targetValues.patients
            stats.value.services = targetValues.services
            stats.value.professionals = targetValues.professionals
        }
    }, interval)
}
</script>

<template>
    <AppLayout>
        <!-- Hero Section PREMIUM avec gradient animé -->
        <section class="relative overflow-hidden">
            <!-- Gradient animé -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800">
                <!-- Formes géométriques animées (cercles flottants) -->
                <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-blob"></div>
                <div
                    class="absolute top-40 right-20 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-blob animation-delay-2000">
                </div>
                <div
                    class="absolute bottom-20 left-1/3 w-80 h-80 bg-white/10 rounded-full blur-3xl animate-blob animation-delay-4000">
                </div>
            </div>

            <!-- Contenu Hero -->
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
                <div class="text-center">
                    <!-- Badge "Certifié" avec animation -->
                    <div
                        class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full mb-8 animate-fade-in-down">
                        <Award class="w-5 h-5" />
                        <span class="text-sm font-medium">Hôpital Certifié ISO 9001</span>
                    </div>

                    <!-- Titre principal avec animation décalée -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 animate-fade-in-up">
                        Hôpital Régional Annexe
                        <span class="block text-secondary-400 mt-2">de Dschang</span>
                    </h1>

                    <!-- Sous-titre avec animation -->
                    <p
                        class="text-xl sm:text-2xl text-white/90 mb-10 max-w-3xl mx-auto animate-fade-in-up animation-delay-300">
                        Soins de qualité, équipe dédiée,<br class="hidden sm:block" />
                        disponible <span class="font-bold text-secondary-400">24h/24</span>
                    </p>

                    <!-- CTAs avec hover effects -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animation-delay-600">
                        <Button variant="secondary" size="lg" href="/rendez-vous"
                            class="group transform hover:scale-105 transition-all duration-300">
                            <Calendar class="w-5 h-5 group-hover:rotate-12 transition-transform" />
                            <span>Prendre Rendez-vous</span>
                        </Button>

                        <a href="tel:+237XXXXXXXXX"
                            class="inline-flex items-center justify-center gap-3 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-semibold py-4 px-8 rounded-lg transition-all duration-300 border-2 border-white/30 hover:border-white/60 transform hover:scale-105">
                            <Phone class="w-5 h-5" />
                            <span>Appeler Maintenant</span>
                        </a>
                    </div>

                    <!-- Indicateurs de confiance -->
                    <div
                        class="flex flex-wrap items-center justify-center gap-6 mt-12 text-white/80 text-sm animate-fade-in-up animation-delay-900">
                        <div class="flex items-center gap-2">
                            <Zap class="w-4 h-4 text-secondary-400" />
                            <span>Réponse en 2h</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <Heart class="w-4 h-4 text-secondary-400" />
                            <span>30,000+ Patients/an</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <Users class="w-4 h-4 text-secondary-400" />
                            <span>50+ Professionnels</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vague SVG séparateur -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                    <path
                        d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                        fill="white" />
                </svg>
            </div>
        </section>

        <!-- Bande info rapide avec animation -->
        <section class="bg-white -mt-1 py-8 shadow-lg relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <!-- Horaires -->
                    <div class="flex items-center justify-center gap-3 animate-slide-in-left">
                        <div class="bg-primary-100 p-3 rounded-full">
                            <Clock class="w-6 h-6 text-primary-600" />
                        </div>
                        <div class="text-left">
                            <div class="text-sm text-gray-600">Horaires</div>
                            <div class="font-semibold text-gray-900">Lun-Ven 8h-17h</div>
                        </div>
                    </div>

                    <!-- Urgences -->
                    <div class="flex items-center justify-center gap-3 animate-slide-in-up animation-delay-200">
                        <div class="bg-danger-100 p-3 rounded-full animate-pulse">
                            <Phone class="w-6 h-6 text-danger-600" />
                        </div>
                        <div class="text-left">
                            <div class="text-sm text-gray-600">Urgences 24/7</div>
                            <a href="tel:+237XXXXXXXXX"
                                class="font-bold text-danger-600 hover:text-danger-700 text-lg transition-colors">
                                +237 XXX XXX XXX
                            </a>
                        </div>
                    </div>

                    <!-- Localisation -->
                    <div class="flex items-center justify-center gap-3 animate-slide-in-right animation-delay-400">
                        <div class="bg-secondary-100 p-3 rounded-full">
                            <MapPin class="w-6 h-6 text-secondary-600" />
                        </div>
                        <div class="text-left">
                            <div class="text-sm text-gray-600">Localisation</div>
                            <div class="font-semibold text-gray-900">Dschang, Cameroun</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services avec grid animé -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center mb-16">
                <div
                    class="inline-block bg-primary-100 text-primary-700 px-4 py-2 rounded-full text-sm font-medium mb-4 animate-fade-in">
                    Nos Spécialités
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-4 animate-fade-in animation-delay-200">
                    Services Médicaux d'Excellence
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto animate-fade-in animation-delay-400">
                    Une équipe multidisciplinaire à votre service pour tous vos besoins de santé
                </p>
            </div>

            <!-- Grid services avec stagger animation -->
            <div v-if="services.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <ServiceCard v-for="(service, index) in services.slice(0, 8)" :key="service.id" :service="service"
                    :style="{ animationDelay: `${index * 100}ms` }" class="animate-scale-in" />
            </div>

            <!-- Fallback si pas de services -->
            <div v-else class="text-center py-12 text-gray-500">
                Aucun service disponible pour le moment.
            </div>

            <div class="text-center mt-12 animate-fade-in animation-delay-1000">
                <Button variant="primary" size="lg" href="/services" class="group">
                    <span>Découvrir tous nos services</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </Button>
            </div>
        </section>

        <!-- Stats Section avec compteurs animés -->
        <section ref="statsSection"
            class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 text-white py-20 relative overflow-hidden">
            <!-- Formes de fond -->
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary-500 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold mb-4">HRAD en Chiffres</h2>
                    <p class="text-primary-100">La confiance de milliers de patients chaque année</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <!-- Stat 1: Patients -->
                    <div class="text-center transform transition-all duration-700"
                        :class="statsVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                        <div class="text-5xl font-bold mb-2 text-secondary-400">
                            {{ stats.patients.toLocaleString() }}+
                        </div>
                        <div class="text-primary-100">Patients/an</div>
                    </div>

                    <!-- Stat 2: Services -->
                    <div class="text-center transform transition-all duration-700 delay-200"
                        :class="statsVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                        <div class="text-5xl font-bold mb-2 text-secondary-400">
                            {{ stats.services }}+
                        </div>
                        <div class="text-primary-100">Services</div>
                    </div>

                    <!-- Stat 3: Professionnels -->
                    <div class="text-center transform transition-all duration-700 delay-400"
                        :class="statsVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                        <div class="text-5xl font-bold mb-2 text-secondary-400">
                            {{ stats.professionals }}+
                        </div>
                        <div class="text-primary-100">Professionnels</div>
                    </div>

                    <!-- Stat 4: Urgences -->
                    <div class="text-center transform transition-all duration-700 delay-600"
                        :class="statsVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                        <div class="text-5xl font-bold mb-2 text-secondary-400">
                            {{ stats.hours }}/7
                        </div>
                        <div class="text-primary-100">Urgences</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pourquoi nous choisir -->
        <section class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div
                        class="inline-block bg-primary-100 text-primary-700 px-4 py-2 rounded-full text-sm font-medium mb-4 animate-fade-in">
                        Nos Engagements
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4 animate-fade-in animation-delay-200">
                        Pourquoi Choisir HRAD ?
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto animate-fade-in animation-delay-400">
                        Depuis 1987, nous mettons notre expertise au service de votre santé
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Avantage 1: Équipe Qualifiée -->
                    <div
                        class="group bg-gray-50 hover:bg-white p-8 rounded-xl border-2 border-transparent hover:border-primary-500 transition-all duration-300 hover:shadow-xl">
                        <div
                            class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <Award class="w-8 h-8 text-primary-600" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">
                            Équipe Qualifiée
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Plus de 50 professionnels de santé expérimentés et diplômés des meilleures universités,
                            dédiés à votre bien-être.
                        </p>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Médecins spécialistes certifiés</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Formation continue obligatoire</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Avantage 2: Équipements Modernes -->
                    <div
                        class="group bg-gray-50 hover:bg-white p-8 rounded-xl border-2 border-transparent hover:border-primary-500 transition-all duration-300 hover:shadow-xl">
                        <div
                            class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <Zap class="w-8 h-8 text-secondary-600" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">
                            Équipements Modernes
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Technologies médicales de pointe pour des diagnostics précis et des traitements efficaces.
                        </p>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Scanner & échographes récents</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Laboratoire certifié</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Avantage 3: Disponibilité 24/7 -->
                    <div
                        class="group bg-gray-50 hover:bg-white p-8 rounded-xl border-2 border-transparent hover:border-primary-500 transition-all duration-300 hover:shadow-xl">
                        <div
                            class="w-16 h-16 bg-danger-100 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <Clock class="w-8 h-8 text-danger-600" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">
                            Disponibilité 24/7
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Service d'urgences opérationnel jour et nuit pour répondre à toutes vos urgences médicales.
                        </p>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Urgences ouvertes 24h/24</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Ambulance disponible</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Avantage 4: Soins Personnalisés -->
                    <div
                        class="group bg-gray-50 hover:bg-white p-8 rounded-xl border-2 border-transparent hover:border-primary-500 transition-all duration-300 hover:shadow-xl">
                        <div
                            class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <Heart class="w-8 h-8 text-primary-600" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">
                            Soins Personnalisés
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Approche centrée sur le patient avec écoute attentive et accompagnement individualisé.
                        </p>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Suivi post-consultation</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Dossier médical centralisé</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Avantage 5: Tarifs Accessibles -->
                    <div
                        class="group bg-gray-50 hover:bg-white p-8 rounded-xl border-2 border-transparent hover:border-primary-500 transition-all duration-300 hover:shadow-xl">
                        <div
                            class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <Users class="w-8 h-8 text-secondary-600" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">
                            Tarifs Accessibles
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Des soins de qualité à des prix adaptés, avec transparence totale sur les coûts.
                        </p>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Devis gratuit avant intervention</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Conventions mutuelles</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Avantage 6: Localisation Centrale -->
                    <div
                        class="group bg-gray-50 hover:bg-white p-8 rounded-xl border-2 border-transparent hover:border-primary-500 transition-all duration-300 hover:shadow-xl">
                        <div
                            class="w-16 h-16 bg-danger-100 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <MapPin class="w-8 h-8 text-danger-600" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">
                            Localisation Centrale
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Situé au cœur de Dschang, facilement accessible depuis toute la région de l'Ouest.
                        </p>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Parking gratuit disponible</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Accès transport en commun</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Témoignages patients -->
        <section class="bg-gradient-to-br from-gray-50 to-white py-20">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-16">
                    <div
                        class="inline-block bg-secondary-100 text-secondary-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
                        Ce qu'ils disent de nous
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Témoignages de Nos Patients
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Votre satisfaction est notre priorité. Découvrez les expériences de ceux qui nous ont fait
                        confiance.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Témoignage 1 -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow border-t-4 border-primary-500">
                        <div class="flex items-center gap-1 mb-4">
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <p class="text-gray-700 mb-6 italic leading-relaxed">
                            "J'ai accouché à la maternité de HRAD et je suis très satisfaite. L'équipe est
                            professionnelle, à l'écoute et bienveillante. Mon bébé et moi avons été très bien suivis."
                        </p>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 font-bold">
                                MN
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Mme Marie N.</div>
                                <div class="text-sm text-gray-600">Maternité • Janvier 2026</div>
                            </div>
                        </div>
                    </div>

                    <!-- Témoignage 2 -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow border-t-4 border-secondary-500">
                        <div class="flex items-center gap-1 mb-4">
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <p class="text-gray-700 mb-6 italic leading-relaxed">
                            "Le service pédiatrie est exceptionnel. Mon fils a été pris en charge rapidement et avec
                            beaucoup de douceur. Les pédiatres prennent vraiment le temps d'expliquer."
                        </p>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 bg-secondary-100 rounded-full flex items-center justify-center text-secondary-600 font-bold">
                                PD
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">M. Pascal D.</div>
                                <div class="text-sm text-gray-600">Pédiatrie • Décembre 2025</div>
                            </div>
                        </div>
                    </div>

                    <!-- Témoignage 3 -->
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow border-t-4 border-danger-500">
                        <div class="flex items-center gap-1 mb-4">
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-secondary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <p class="text-gray-700 mb-6 italic leading-relaxed">
                            "Urgences réactives et efficaces ! Mon père a été pris en charge immédiatement pour un
                            problème cardiaque. L'équipe a été formidable du début à la fin. Merci HRAD !"
                        </p>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 bg-danger-100 rounded-full flex items-center justify-center text-danger-600 font-bold">
                                ST
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Mme Sandrine T.</div>
                                <div class="text-sm text-gray-600">Urgences • Février 2026</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA témoignages -->
                <div class="text-center mt-12">
                    <p class="text-gray-600 mb-6">Vous aussi, partagez votre expérience</p>
                    <Button variant="outline" href="/temoignages">
                        Laisser un témoignage
                    </Button>
                </div>
            </div>
        </section>

        <!-- CTA Final avec parallax -->
        <section class="relative py-24 overflow-hidden">
            <!-- Background avec overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900 to-gray-800"></div>
            <div class="absolute inset-0 opacity-20 bg-cover bg-center"
                style="background-image: url('/images/hospital-bg.jpg');"></div>

            <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
                <Heart class="w-16 h-16 mx-auto mb-6 text-danger-400 animate-pulse" />

                <h2 class="text-4xl font-bold mb-4 animate-fade-in">
                    Besoin de Soins Médicaux ?
                </h2>

                <p class="text-xl text-gray-300 mb-10 animate-fade-in animation-delay-200">
                    Notre équipe médicale dévouée est à votre disposition 24h/24 et 7j/7<br class="hidden sm:block" />
                    pour vous accompagner dans tous vos besoins de santé
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in animation-delay-400">
                    <a href="tel:+237XXXXXXXXX"
                        class="group inline-flex items-center justify-center gap-3 bg-danger-500 hover:bg-danger-600 text-white font-bold py-4 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <Phone class="w-5 h-5 group-hover:rotate-12 transition-transform" />
                        <span>Appeler Urgences</span>
                    </a>

                    <Button variant="outline" size="lg" href="/rendez-vous"
                        class="!border-white !text-white hover:!bg-white hover:!text-gray-900 transform hover:scale-105">
                        <Calendar class="w-5 h-5" />
                        <span>Prendre Rendez-vous</span>
                    </Button>
                </div>

                <!-- Réassurance -->
                <div class="flex flex-wrap items-center justify-center gap-8 mt-12 text-sm text-gray-400">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Réponse garantie en 2h</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Équipe qualifiée 24/7</span>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
/* Animations personnalisées */
@keyframes blob {

    0%,
    100% {
        transform: translate(0, 0) scale(1);
    }

    33% {
        transform: translate(30px, -50px) scale(1.1);
    }

    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

/* Animations d'entrée */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
}

.animate-fade-in-down {
    animation: fadeInDown 0.8s ease-out forwards;
}

.animate-fade-in {
    animation: fadeInUp 0.6s ease-out forwards;
}

.animate-slide-in-left {
    animation: slideInLeft 0.6s ease-out forwards;
}

.animate-slide-in-right {
    animation: slideInRight 0.6s ease-out forwards;
}

.animate-slide-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
}

.animate-scale-in {
    animation: scaleIn 0.5s ease-out forwards;
    opacity: 0;
}

/* Délais d'animation */
.animation-delay-200 {
    animation-delay: 200ms;
}

.animation-delay-300 {
    animation-delay: 300ms;
}

.animation-delay-400 {
    animation-delay: 400ms;
}

.animation-delay-600 {
    animation-delay: 600ms;
}

.animation-delay-900 {
    animation-delay: 900ms;
}

.animation-delay-1000 {
    animation-delay: 1000ms;
}

/* Transitions de délai pour les stats */
.delay-200 {
    transition-delay: 200ms;
}

.delay-400 {
    transition-delay: 400ms;
}

.delay-600 {
    transition-delay: 600ms;
}
</style>
