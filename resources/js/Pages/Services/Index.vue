<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import ServiceCard from '@/Components/ServiceCard.vue'
import Button from '@/Components/Button.vue'
import { Search, ChevronRight } from 'lucide-vue-next'

// Props
const props = defineProps({
    services: {
        type: Array,
        default: () => []
    }
})

// State
const searchQuery = ref('')
const activeFilter = ref('tous')

// Filter options
const filters = [
    { id: 'tous', label: 'Tous les services' },
    { id: 'consultations', label: 'Consultations' },
    { id: 'urgences', label: 'Urgences' }
]

// Filtered services computed
const filteredServices = computed(() => {
    let result = props.services

    // Apply search filter
    if (searchQuery.value.trim()) {
        const query = searchQuery.value.toLowerCase()
        result = result.filter(service =>
            service.nom.toLowerCase().includes(query) ||
            service.description.toLowerCase().includes(query)
        )
    }

    // Apply category filter
    if (activeFilter.value === 'consultations') {
        result = result.filter(service => service.tarif_consultation > 0)
    } else if (activeFilter.value === 'urgences') {
        // Urgences sont identifiées par le slug contenant 'urgences'
        result = result.filter(service => service.slug.includes('urgences'))
    }

    return result
})

// Check if no results
const hasResults = computed(() => filteredServices.value.length > 0)
</script>

<template>
    <AppLayout>
        <!-- Header Section avec Breadcrumb -->
        <section class="bg-gradient-to-b from-primary-50 to-white py-12 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 mb-8 text-sm">
                    <Link href="/" class="text-primary-600 hover:text-primary-700 transition-colors">Accueil</Link>
                    <ChevronRight class="w-4 h-4 text-gray-400" />
                    <span class="text-gray-600">Services</span>
                </div>

                <!-- Titre et sous-titre -->
                <div class="text-center">
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4 animate-fade-in">
                        Nos Services Médicaux
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 animate-fade-in animation-delay-200">
                        Des soins d'excellence dans 8 spécialités
                    </p>

                    <!-- Search Bar -->
                    <div class="max-w-2xl mx-auto animate-fade-in animation-delay-400">
                        <div class="relative">
                            <Search class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Rechercher un service médical..."
                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all duration-300"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filtres rapides -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-wrap items-center justify-center gap-4 animate-fade-in animation-delay-600">
                <button
                    v-for="filter in filters"
                    :key="filter.id"
                    @click="activeFilter = filter.id"
                    :class="[
                        'px-6 py-2 rounded-lg font-medium transition-all duration-300',
                        activeFilter === filter.id
                            ? 'bg-primary-500 text-white shadow-lg'
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                    ]"
                >
                    {{ filter.label }}
                </button>
            </div>
        </section>

        <!-- Grid Services -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div v-if="hasResults" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <ServiceCard
                    v-for="(service, index) in filteredServices"
                    :key="service.id"
                    :service="service"
                    :style="{ animationDelay: `${index * 100}ms` }"
                    class="animate-scale-in"
                />
            </div>

            <!-- No Results Message -->
            <div v-else class="text-center py-20">
                <div class="mb-4 text-6xl">🔍</div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">
                    Aucun service trouvé
                </h3>
                <p class="text-gray-600 mb-8">
                    Nous n'avons trouvé aucun service correspondant à votre recherche "{{ searchQuery }}".
                    <br />Veuillez réessayer avec d'autres mots-clés.
                </p>
                <button
                    @click="searchQuery = ''; activeFilter = 'tous'"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 text-white font-medium rounded-lg hover:bg-primary-600 transition-colors"
                >
                    Réinitialiser les filtres
                </button>
            </div>

            <!-- Compteur de résultats -->
            <div v-if="hasResults" class="text-center mt-12 text-gray-600">
                <p>{{ filteredServices.length }} service<span v-if="filteredServices.length > 1">s</span> trouvé<span v-if="filteredServices.length > 1">s</span></p>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-16 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                    Vous ne trouvez pas le service recherché ?
                </h2>
                <p class="text-primary-100 text-lg mb-8 max-w-2xl mx-auto">
                    Notre équipe est à votre disposition pour vous aider et répondre à toutes vos questions.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <Button
                        href="/contact"
                        variant="secondary"
                        size="lg"
                        class="bg-white text-primary-600 hover:bg-gray-100 font-semibold"
                    >
                        Contactez-nous
                    </Button>
                    <Button
                        href="/rendez-vous"
                        variant="secondary"
                        size="lg"
                        class="bg-primary-500 text-white border-2 border-white hover:bg-primary-600 font-semibold"
                    >
                        Prendre RDV
                    </Button>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
@keyframes scale-in {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-scale-in {
    animation: scale-in 0.3s ease-out forwards;
}

@keyframes fade-in {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
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
</style>
