<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Button from '@/Components/Button.vue'
import { ChevronRight, Phone, Calendar } from 'lucide-vue-next'

// Props
const props = defineProps({
    service: {
        type: Object,
        required: true
    }
})

// State
const showMobileSchedule = ref(false)

// Computed
const jours_semaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']

const horairesParJour = computed(() => {
    const map = {}
    jours_semaine.forEach(jour => {
        map[jour] = props.service.horaires?.find(h => h.jour_semaine === jour) || null
    })
    return map
})

const hasHoraires = computed(() => props.service.horaires && props.service.horaires.length > 0)
const hasMedecins = computed(() => props.service.medecins && props.service.medecins.length > 0)
const hasTarifs = computed(() => props.service.tarifs && props.service.tarifs.length > 0)

const tarifsByType = computed(() => {
    const result = {
        normal: [],
        etudiant: [],
        urgence: []
    }
    props.service.tarifs?.forEach(tarif => {
        result[tarif.type_patient || 'normal'].push(tarif)
    })
    return result
})

// Format time helper
const formatTime = (time) => {
    if (!time) return ''
    const [hours, minutes] = time.split(':')
    return `${hours}h${minutes}`
}

// Get initials for avatar fallback
const getInitials = (name) => {
    return name
        .split(' ')
        .map(word => word[0])
        .join('')
        .toUpperCase()
        .slice(0, 2)
}
</script>

<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-primary-50 to-white py-12 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 mb-8 text-sm">
                    <Link href="/" class="text-primary-600 hover:text-primary-700 transition-colors">Accueil</Link>
                    <ChevronRight class="w-4 h-4 text-gray-400" />
                    <Link href="/services" class="text-primary-600 hover:text-primary-700 transition-colors">Services</Link>
                    <ChevronRight class="w-4 h-4 text-gray-400" />
                    <span class="text-gray-600">{{ service.nom }}</span>
                </div>

                <!-- Content -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-8">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-5xl">🏥</span>
                        </div>
                    </div>

                    <!-- Titre et description -->
                    <div class="flex-1">
                        <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
                            {{ service.nom }}
                        </h1>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ service.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Tarifs -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Tarifs & Paiements</h2>
                <p class="text-lg text-gray-600">Transparence des prix pour votre tranquillité</p>
            </div>

            <!-- Tarifs disponibles -->
            <div v-if="hasTarifs">
                <!-- Tarifs Normal -->
                <div v-if="tarifsByType.normal.length > 0" class="mb-16">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-8">Tarifs Standard</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div
                            v-for="tarif in tarifsByType.normal"
                            :key="tarif.id"
                            class="bg-white border-2 border-gray-200 rounded-xl p-8 hover:border-primary-500 hover:shadow-lg transition-all duration-300"
                        >
                            <!-- Désignation -->
                            <h4 class="text-xl font-semibold text-gray-900 mb-4">
                                {{ tarif.designation }}
                            </h4>

                            <!-- Prix en GROS -->
                            <div class="mb-6 pb-6 border-b-2 border-gray-100">
                                <div class="text-6xl font-bold text-primary-600">
                                    {{ tarif.montant.toLocaleString() }}
                                </div>
                                <div class="text-lg text-gray-600 mt-2">FCFA</div>
                            </div>

                            <!-- Détails -->
                            <div v-if="tarif.details" class="text-gray-600 text-sm">
                                <h5 class="font-semibold text-gray-900 mb-3">Inclus :</h5>
                                <ul class="space-y-2">
                                    <li v-for="(line, i) in tarif.details.split('\n').filter(l => l.trim())" :key="i"
                                        class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-primary-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ line.trim() }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarifs Étudiant -->
                <div v-if="tarifsByType.etudiant.length > 0" class="mb-16">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-8 flex items-center gap-3">
                        <span class="inline-block bg-secondary-100 text-secondary-700 px-4 py-1 rounded-full text-lg font-bold">
                            👨‍🎓
                        </span>
                        Tarifs Étudiant
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div
                            v-for="tarif in tarifsByType.etudiant"
                            :key="tarif.id"
                            class="bg-gradient-to-br from-secondary-50 to-white border-2 border-secondary-300 rounded-xl p-8 hover:border-secondary-500 hover:shadow-lg transition-all duration-300"
                        >
                            <h4 class="text-xl font-semibold text-gray-900 mb-4">
                                {{ tarif.designation }}
                            </h4>
                            <div class="mb-6 pb-6 border-b-2 border-secondary-200">
                                <div class="text-6xl font-bold text-secondary-600">
                                    {{ tarif.montant.toLocaleString() }}
                                </div>
                                <div class="text-lg text-gray-600 mt-2">FCFA</div>
                            </div>
                            <div class="bg-secondary-100 text-secondary-800 px-4 py-2 rounded-lg text-sm font-medium">
                                Preuve d'inscription requise
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarifs Urgence -->
                <div v-if="tarifsByType.urgence.length > 0" class="mb-16">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-8 flex items-center gap-3">
                        <span class="inline-block bg-danger-100 text-danger-700 px-4 py-1 rounded-full text-lg font-bold">
                            🚑
                        </span>
                        Tarifs Urgences
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div
                            v-for="tarif in tarifsByType.urgence"
                            :key="tarif.id"
                            class="bg-danger-50 border-2 border-danger-300 rounded-xl p-8 hover:border-danger-500 hover:shadow-lg transition-all duration-300"
                        >
                            <h4 class="text-xl font-semibold text-gray-900 mb-4">
                                {{ tarif.designation }}
                            </h4>
                            <div class="mb-6 pb-6 border-b-2 border-danger-200">
                                <div class="text-6xl font-bold text-danger-600">
                                    {{ tarif.montant.toLocaleString() }}
                                </div>
                                <div class="text-lg text-gray-600 mt-2">FCFA</div>
                            </div>
                            <div class="bg-danger-100 text-danger-800 px-4 py-2 rounded-lg text-sm font-medium">
                                Disponible 24h/24, 7j/7
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Badge Mutuelles -->
                <div class="flex flex-wrap gap-4 mt-12 pt-8 border-t-2 border-gray-200">
                    <div class="flex items-center gap-2 bg-primary-50 border border-primary-300 rounded-lg px-4 py-3">
                        <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-primary-900 font-medium">Mutuelles acceptées</span>
                    </div>
                </div>
            </div>

            <!-- No tarifs -->
            <div v-else class="bg-blue-50 border-2 border-blue-300 rounded-xl p-8">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Tarifs sur demande</h3>
                <p class="text-blue-800 mb-4">
                    Les tarifs spécifiques pour ce service ne sont pas encore disponibles en ligne.
                </p>
                <a href="tel:+237XXXXXXXXX"
                    class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-semibold">
                    <Phone class="w-5 h-5" />
                    Appelez-nous directement
                </a>
            </div>
        </section>

        <!-- Section Horaires -->
        <section v-if="hasHoraires || true" class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-4xl font-bold text-gray-900 mb-12">Horaires de Consultation</h2>

                <!-- Desktop Table -->
                <div v-if="hasHoraires" class="hidden md:block overflow-x-auto bg-white rounded-xl shadow-md">
                    <table class="w-full">
                        <thead class="bg-primary-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold text-gray-900">Jour</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-900">Horaires</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-900">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="jour in jours_semaine" :key="jour" class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ jour }}</td>
                                <td v-if="horairesParJour[jour]" class="px-6 py-4 text-gray-700">
                                    {{ formatTime(horairesParJour[jour].ouverture) }} - {{ formatTime(horairesParJour[jour].fermeture) }}
                                </td>
                                <td v-else class="px-6 py-4 text-gray-500 italic">Fermé</td>
                                <td class="px-6 py-4 text-gray-600">
                                    <span v-if="horairesParJour[jour]?.note" class="bg-danger-100 text-danger-700 px-3 py-1 rounded-full text-sm">
                                        {{ horairesParJour[jour].note }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div v-if="hasHoraires" class="md:hidden space-y-4">
                    <div v-for="jour in jours_semaine" :key="jour" class="bg-white rounded-lg border-l-4 border-primary-500 p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">{{ jour }}</h4>
                        <div v-if="horairesParJour[jour]" class="text-gray-700 mb-2">
                            <p class="flex items-center gap-2">
                                <span class="text-primary-600 font-bold">🕐</span>
                                {{ formatTime(horairesParJour[jour].ouverture) }} - {{ formatTime(horairesParJour[jour].fermeture) }}
                            </p>
                            <p v-if="horairesParJour[jour].note" class="text-danger-600 font-medium mt-1">
                                ⚠️ {{ horairesParJour[jour].note }}
                            </p>
                        </div>
                        <div v-else class="text-gray-500 italic">Fermé</div>
                    </div>
                </div>

                <!-- Default horaires si pas de données -->
                <div v-if="!hasHoraires" class="bg-blue-50 border-2 border-blue-300 rounded-xl p-8">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Horaires Standards</h3>
                    <p class="text-blue-800">Lundi à vendredi : 8h00 - 17h00</p>
                    <p class="text-blue-800">Fermé le week-end</p>
                </div>
            </div>
        </section>

        <!-- Section Équipe Médicale -->
        <section v-if="hasMedecins" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <h2 class="text-4xl font-bold text-gray-900 mb-12">Notre Équipe Médicale</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    v-for="medecin in service.medecins"
                    :key="medecin.id"
                    class="bg-white rounded-xl overflow-hidden border-2 border-gray-200 hover:border-primary-500 hover:shadow-lg transition-all duration-300"
                >
                    <!-- Photo ou avatar -->
                    <div class="h-48 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                        <div v-if="medecin.photo" class="w-full h-full">
                            <img :src="medecin.photo" :alt="medecin.nom" class="w-full h-full object-cover" />
                        </div>
                        <div v-else class="text-5xl font-bold text-primary-600">
                            {{ getInitials(medecin.nom) }}
                        </div>
                    </div>

                    <!-- Infos -->
                    <div class="p-6">
                        <!-- Nom -->
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                            {{ medecin.nom }}
                        </h3>

                        <!-- Spécialité -->
                        <p class="text-sm text-gray-600 mb-4">
                            {{ medecin.specialite }}
                        </p>

                        <!-- Diplômes -->
                        <div v-if="medecin.diplomes" class="mb-4 pb-4 border-b border-gray-200">
                            <h4 class="text-xs font-semibold text-gray-700 mb-2 uppercase">Diplômes</h4>
                            <div class="space-y-1">
                                <p v-for="(diploma, i) in medecin.diplomes.split('\n').filter(d => d.trim())" :key="i" class="text-xs text-gray-600">
                                    ✓ {{ diploma.trim() }}
                                </p>
                            </div>
                        </div>

                        <!-- Langues -->
                        <div v-if="medecin.langues" class="flex flex-wrap gap-2">
                            <span v-for="langue in medecin.langues.split(',').map(l => l.trim())" :key="langue"
                                class="inline-block bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-xs font-medium">
                                {{ langue }}
                            </span>
                        </div>

                        <!-- Bio -->
                        <p v-if="medecin.bio" class="text-sm text-gray-600 mt-4 line-clamp-2">
                            {{ medecin.bio }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-20 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                    Besoin de consulter en {{ service.nom }} ?
                </h2>
                <p class="text-primary-100 text-lg mb-8 max-w-2xl mx-auto">
                    Prenez rendez-vous en ligne ou appelez-nous pour une consultation rapide.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <Button
                        href="/rendez-vous"
                        variant="secondary"
                        size="lg"
                        class="bg-secondary-500 text-white hover:bg-secondary-600 font-semibold inline-flex items-center gap-2"
                    >
                        <Calendar class="w-5 h-5" />
                        Prendre Rendez-vous
                    </Button>
                    <a href="tel:+237XXXXXXXXX"
                        class="inline-flex items-center justify-center gap-3 bg-white text-primary-700 font-semibold py-4 px-8 rounded-lg transition-all duration-300 border-2 border-white hover:bg-gray-100 shadow-md">
                        <Phone class="w-5 h-5" />
                        <span>Appeler Maintenant</span>
                    </a>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
/* Ligne-clamp utility pour mobile */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
