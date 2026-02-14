<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Button from '@/Components/Button.vue'
import { Users, Briefcase, CheckCircle } from 'lucide-vue-next'

// Props
const props = defineProps({
    medecins: {
        type: Array,
        default: () => []
    },
    specialites: {
        type: Array,
        default: () => []
    }
})

// State
const activeFilter = ref('tous')

// Computed
const filteredMedecins = computed(() => {
    if (activeFilter.value === 'tous') {
        return props.medecins
    }
    return props.medecins.filter(m =>
        m.specialite.toLowerCase().includes(activeFilter.value.toLowerCase())
    )
})

// Get initials for avatar fallback
const getInitials = (nom) => {
    return nom
        .split(' ')
        .map(word => word[0])
        .join('')
        .toUpperCase()
        .slice(0, 2)
}

// Parse langues string
const parseLangues = (languesStr) => {
    if (!languesStr) return []
    return languesStr.split(',').map(l => l.trim())
}

// Get language color
const getLangageColor = (langue) => {
    const colors = {
        'FR': 'bg-blue-100 text-blue-700',
        'EN': 'bg-green-100 text-green-700',
        'Français': 'bg-blue-100 text-blue-700',
        'Anglais': 'bg-green-100 text-green-700',
    }
    return colors[langue] || 'bg-gray-100 text-gray-700'
}

// Set filter
const setFilter = (filter) => {
    activeFilter.value = filter
}
</script>

<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-20 relative overflow-hidden">
            <!-- Formes de fond -->
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary-500 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <Users class="w-16 h-16 text-white animate-bounce" />
                </div>

                <!-- Titre -->
                <h1 class="text-4xl sm:text-5xl font-bold mb-4 animate-fade-in">
                    Notre Équipe Médicale
                </h1>

                <!-- Sous-titre -->
                <p class="text-xl text-primary-100 mb-4 animate-fade-in animation-delay-200">
                    Plus de 50 professionnels dévoués à votre santé
                </p>

                <!-- Description -->
                <p class="text-primary-100 max-w-2xl mx-auto animate-fade-in animation-delay-400">
                    Des médecins qualifiés, formés aux meilleures pratiques internationales
                </p>
            </div>
        </section>

        <!-- Section Filtres -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 border-b border-gray-200">
            <div class="flex flex-wrap items-center justify-center gap-3 mb-8 animate-fade-in animation-delay-600">
                <button
                    @click="setFilter('tous')"
                    :class="[
                        'px-6 py-2 rounded-lg font-medium transition-all duration-300',
                        activeFilter === 'tous'
                            ? 'bg-primary-500 text-white shadow-lg'
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                    ]"
                >
                    Tous
                </button>

                <button
                    v-for="specialite in specialites"
                    :key="specialite"
                    @click="setFilter(specialite)"
                    :class="[
                        'px-6 py-2 rounded-lg font-medium transition-all duration-300',
                        activeFilter === specialite
                            ? 'bg-primary-500 text-white shadow-lg'
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                    ]"
                >
                    {{ specialite }}
                </button>
            </div>

            <!-- Compteur résultats -->
            <div class="text-center text-gray-600">
                <p>
                    {{ filteredMedecins.length }}
                    médecin<span v-if="filteredMedecins.length > 1">s</span>
                    trouvé<span v-if="filteredMedecins.length > 1">s</span>
                </p>
            </div>
        </section>

        <!-- Grid Médecins -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div v-if="filteredMedecins.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    v-for="(medecin, index) in filteredMedecins"
                    :key="medecin.id"
                    class="bg-white rounded-xl shadow-md border-2 border-transparent hover:border-primary-500 hover:shadow-xl hover:scale-105 transition-all duration-300 p-8 text-center overflow-hidden card-fade-in"
                    :style="{ '--card-delay': `${index * 100}ms` }"
                >
                    <!-- Photo ou Avatar -->
                    <div class="mb-6">
                        <div v-if="medecin.photo" class="w-32 h-32 mx-auto rounded-full overflow-hidden shadow-lg mb-4">
                            <img
                                :src="`/storage/${medecin.photo}`"
                                :alt="medecin.nom"
                                class="w-full h-full object-cover"
                                @error="$event.target.style.display = 'none'"
                            />
                        </div>

                        <div v-else class="w-32 h-32 mx-auto bg-primary-100 rounded-full flex items-center justify-center shadow-lg mb-4">
                            <span class="text-5xl font-bold text-primary-600">
                                {{ getInitials(medecin.nom) }}
                            </span>
                        </div>

                        <!-- Badge Disponible -->
                        <div class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                            ✓ Disponible
                        </div>
                    </div>

                    <!-- Nom -->
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        Dr. {{ medecin.nom }}
                    </h3>

                    <!-- Spécialité -->
                    <p class="text-primary-600 font-medium mb-3">
                        {{ medecin.specialite }}
                    </p>

                    <!-- Diplômes (aperçu) -->
                    <p v-if="medecin.diplomes" class="text-sm text-gray-600 italic mb-4 line-clamp-2">
                        {{ medecin.diplomes.split('\n')[0] }}
                    </p>

                    <!-- Langues -->
                    <div v-if="medecin.langues" class="flex flex-wrap justify-center gap-2 mb-6">
                        <span
                            v-for="langue in parseLangues(medecin.langues)"
                            :key="langue"
                            :class="[
                                'px-3 py-1 rounded-full text-xs font-semibold',
                                getLangageColor(langue)
                            ]"
                        >
                            {{ langue }}
                        </span>
                    </div>

                    <!-- Bouton Profil -->
                    <Link
                        :href="`/equipe/${medecin.slug}`"
                        class="inline-flex items-center justify-center gap-2 bg-primary-500 hover:bg-primary-600 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 w-full"
                    >
                        Voir le profil
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </Link>
                </div>
            </div>

            <!-- Pas de résultats -->
            <div v-else class="text-center py-20 text-gray-500">
                <p class="text-lg">Aucun médecin trouvé pour cette spécialité.</p>
            </div>
        </section>

        <!-- Section Rejoindre Équipe -->
        <section class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <Briefcase class="w-16 h-16 text-primary-600 mx-auto mb-6" />

                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Envie de Rejoindre Notre Équipe ?
                </h2>

                <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-8">
                    Nous recrutons régulièrement des professionnels de santé qualifiés et motivés.
                </p>

                <Button
                    href="/contact"
                    variant="primary"
                    size="lg"
                    class="group"
                >
                    <span>Voir les Offres d'Emploi</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </Button>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes fade-in {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.card-fade-in {
    animation: fadeInScale 0.5s ease-out forwards;
    animation-delay: var(--card-delay, 0ms);
}

.animate-fade-in {
    animation: fade-in 0.5s ease-out forwards;
    opacity: 0;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}

.animation-delay-600 {
    animation-delay: 0.6s;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
