<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Button from '@/Components/Button.vue'
import { ChevronRight, Briefcase, Globe, MapPin, Phone, CheckCircle } from 'lucide-vue-next'

// Props
const props = defineProps({
    medecin: {
        type: Object,
        required: true
    }
})

// State
const photoError = ref(false)

// Methods
const getInitials = (nom) => {
    if (!nom) return 'DR'
    return nom
        .split(' ')
        .map(word => word[0])
        .join('')
        .toUpperCase()
        .slice(0, 2)
}

const parseLangues = (languesStr) => {
    if (!languesStr) return []
    return languesStr.split(',').map(l => l.trim())
}

const getLangageColor = (langue) => {
    const colors = {
        'FR': 'bg-blue-100 text-blue-700',
        'EN': 'bg-green-100 text-green-700',
        'Français': 'bg-blue-100 text-blue-700',
        'Anglais': 'bg-green-100 text-green-700',
    }
    return colors[langue] || 'bg-gray-100 text-gray-700'
}

const parseDiplomes = (diplomesStr) => {
    if (!diplomesStr) return []
    return diplomesStr.split('\n').filter(d => d.trim())
}

const handleImageError = () => {
    photoError.value = true
}

// Format time
const formatTime = (time) => {
    if (!time) return ''
    const [hours, minutes] = time.split(':')
    return `${hours}h${minutes}`
}

// Check if any service has horaires
const hasHoraires = () => {
    if (!props.medecin?.services || !Array.isArray(props.medecin.services)) {
        return false
    }
    return props.medecin.services.some(s => s?.horaires && Array.isArray(s.horaires) && s.horaires.length > 0)
}

// Get services with horaires only
const getServicesWithHoraires = () => {
    if (!props.medecin?.services || !Array.isArray(props.medecin.services)) {
        return []
    }
    return props.medecin.services.filter(s => s?.horaires && Array.isArray(s.horaires) && s.horaires.length > 0)
}
</script>

<template>
    <AppLayout>
        <!-- Vérifier que medecin existe -->
        <div v-if="!medecin">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
                <p class="text-xl text-gray-600">Médecin non trouvé.</p>
            </div>
        </div>

        <div v-else>
            <!-- Breadcrumb & Hero Section -->
            <section class="bg-gradient-to-b from-primary-50 to-white py-12 border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Breadcrumb -->
                    <div class="flex items-center gap-2 mb-8 text-sm">
                        <Link href="/" class="text-primary-600 hover:text-primary-700 transition-colors">Accueil</Link>
                        <ChevronRight class="w-4 h-4 text-gray-400" />
                        <Link href="/equipe" class="text-primary-600 hover:text-primary-700 transition-colors">Équipe</Link>
                        <ChevronRight class="w-4 h-4 text-gray-400" />
                        <span class="text-gray-600">Dr. {{ medecin.nom }}</span>
                    </div>

                    <!-- Hero Content - 2 colonnes -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
                        <!-- Colonne Photo (40%) -->
                        <div class="flex justify-center">
                            <!-- Photo -->
                            <div v-if="medecin.photo && !photoError" class="relative">
                                <img
                                    :src="`/storage/${medecin.photo}`"
                                    :alt="medecin.nom || 'Médecin'"
                                    class="w-64 h-64 rounded-2xl shadow-2xl object-cover"
                                    @error="handleImageError"
                                />
                                <!-- Badge Disponible -->
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold shadow-lg">
                                    ✓ Disponible
                                </div>
                            </div>

                            <!-- Avatar Fallback -->
                            <div v-else class="relative">
                                <div class="w-64 h-64 bg-primary-100 rounded-2xl flex items-center justify-center shadow-2xl">
                                    <span class="text-7xl font-bold text-primary-600">
                                        {{ getInitials(medecin.nom) }}
                                    </span>
                                </div>
                                <!-- Badge Disponible -->
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold shadow-lg">
                                    ✓ Disponible
                                </div>
                            </div>
                        </div>

                        <!-- Colonne Infos (60%) -->
                        <div class="lg:col-span-2">
                            <!-- Titre -->
                            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-2">
                                Dr. {{ medecin.nom || 'Inconnu' }}
                            </h1>

                            <!-- Spécialité -->
                            <h2 class="text-3xl text-primary-600 font-semibold mb-8">
                                {{ medecin.specialite || 'Spécialité non précisée' }}
                            </h2>

                            <!-- Expérience -->
                            <div class="flex items-center gap-3 mb-6 text-lg text-gray-700">
                                <Briefcase class="w-6 h-6 text-primary-600 flex-shrink-0" />
                                <span>Médecin spécialiste à HRAD Dschang</span>
                            </div>

                            <!-- Langues -->
                            <div v-if="medecin.langues" class="flex items-start gap-3 mb-8">
                                <Globe class="w-6 h-6 text-primary-600 flex-shrink-0 mt-1" />
                                <div>
                                    <p class="font-semibold text-gray-900 mb-2">Langues parlées</p>
                                    <div class="flex flex-wrap gap-2">
                                        <span
                                            v-for="langue in parseLangues(medecin.langues)"
                                            :key="langue"
                                            :class="[
                                                'px-3 py-1 rounded-full text-sm font-semibold',
                                                getLangageColor(langue)
                                            ]"
                                        >
                                            {{ langue }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Localisation -->
                            <div class="flex items-center gap-3 text-lg text-gray-700">
                                <MapPin class="w-6 h-6 text-primary-600 flex-shrink-0" />
                                <span>Consultations à HRAD Dschang, Cameroun</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Biographie -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Parcours & Expertise</h2>

                <div v-if="medecin.bio" class="bg-white rounded-xl p-8 border border-gray-200">
                    <p class="text-lg text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ medecin.bio }}
                    </p>
                </div>

                <div v-else class="bg-primary-50 rounded-xl p-8 border-2 border-primary-200">
                    <p class="text-lg text-primary-900">
                        Dr. {{ medecin.nom || 'Ce médecin' }} est un(e) {{ medecin.specialite || 'spécialiste' }} expérimenté(e) au service des patients de l'Hôpital Régional Annexe de Dschang.
                        Dédié(e) à l'excellence médicale et au bien-être de ses patients, il/elle met à profit ses compétences et son savoir-faire pour assurer des soins de qualité.
                    </p>
                </div>
            </section>

            <!-- Section Diplômes & Certifications -->
            <section v-if="medecin.diplomes" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-200">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Diplômes & Certifications</h2>

                <div class="space-y-4">
                    <div v-for="(diploma, i) in parseDiplomes(medecin.diplomes)" :key="i" class="flex items-start gap-4 bg-white p-6 rounded-lg border border-gray-200 hover:border-primary-300 transition-colors">
                        <CheckCircle class="w-6 h-6 text-primary-600 flex-shrink-0 mt-1" />
                        <p class="text-gray-800">{{ diploma }}</p>
                    </div>
                </div>
            </section>

            <!-- Section Services Associés -->
            <section v-if="medecin.services && medecin.services.length > 0" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-200">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Services Médicaux</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <Link
                        v-for="service in medecin.services"
                        :key="service.id"
                        :href="`/services/${service.slug}`"
                        class="group bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-primary-500 hover:shadow-lg transition-all duration-300"
                    >
                        <!-- Icon Service -->
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <span class="text-2xl">🏥</span>
                        </div>

                        <!-- Nom Service -->
                        <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                            {{ service.nom || 'Service' }}
                        </h3>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ service.description || 'Aucune description disponible' }}
                        </p>

                        <!-- Lien -->
                        <div class="inline-flex items-center gap-2 text-primary-600 font-semibold group-hover:gap-3 transition-all">
                            Voir le service
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </Link>
                </div>
            </section>

            <!-- Section Horaires - CORRIGÉE -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-200">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Horaires de Consultation</h2>

                <div v-if="hasHoraires()">
                    <div v-for="service in getServicesWithHoraires()" :key="service.id" class="mb-12">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ service.nom || 'Service' }}</h3>

                        <!-- Desktop Table -->
                        <div class="hidden md:block overflow-x-auto bg-white rounded-xl shadow-md">
                            <table class="w-full">
                                <thead class="bg-primary-50 border-b-2 border-gray-200">
                                    <tr>
                                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Jour</th>
                                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Horaires</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="horaire in service.horaires" :key="horaire.id" class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="px-6 py-4 font-semibold text-gray-900">{{ horaire?.jour_semaine || '-' }}</td>
                                        <td class="px-6 py-4 text-gray-700">
                                            {{ formatTime(horaire?.ouverture) }} - {{ formatTime(horaire?.fermeture) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Cards -->
                        <div class="md:hidden space-y-3">
                            <div v-for="horaire in service.horaires" :key="horaire.id" class="bg-white rounded-lg p-4 border-l-4 border-primary-500">
                                <p class="font-semibold text-gray-900">{{ horaire?.jour_semaine || '-' }}</p>
                                <p class="text-gray-700 mt-1">{{ formatTime(horaire?.ouverture) }} - {{ formatTime(horaire?.fermeture) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="bg-blue-50 rounded-xl p-8 border-2 border-blue-300">
                    <p class="text-blue-900">
                        Consultations sur rendez-vous. Contactez le secrétariat pour connaître les disponibilités.
                    </p>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-16 mt-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                        Souhaitez-vous consulter Dr. {{ medecin.nom || 'ce médecin' }} ?
                    </h2>
                    <p class="text-primary-100 text-lg mb-8 max-w-2xl mx-auto">
                        Prenez rendez-vous en ligne ou contactez notre secrétariat pour une consultation.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <Button
                            href="/rendez-vous"
                            variant="secondary"
                            size="lg"
                            class="bg-secondary-500 text-white hover:bg-secondary-600 font-semibold"
                        >
                            Prendre Rendez-vous
                        </Button>
                        <a href="tel:+237XXXXXXXXX"
                            class="inline-flex items-center justify-center gap-3 bg-white text-primary-700 font-semibold py-4 px-8 rounded-lg transition-all duration-300 border-2 border-white hover:bg-gray-100 shadow-md">
                            <Phone class="w-5 h-5" />
                            <span>Contacter le Secrétariat</span>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
