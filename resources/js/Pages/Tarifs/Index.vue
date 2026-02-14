<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Button from '@/Components/Button.vue'
import { DollarSign, Search, CreditCard, Shield, Heart, ChevronDown, ChevronUp } from 'lucide-vue-next'

// Props
const props = defineProps({
    servicesTarifs: {
        type: Array,
        required: true
    }
})

// State
const searchQuery = ref('')
const activeFilter = ref('tous')
const expandedFaqs = ref({})

// Catégories de filtres
const categories = [
    { value: 'tous', label: 'Tous' },
    { value: 'consultations', label: 'Consultations' },
    { value: 'examens', label: 'Examens' },
    { value: 'interventions', label: 'Interventions' },
    { value: 'maternite', label: 'Maternité' }
]

// FAQ items
const faqs = [
    {
        id: 1,
        question: "Les tarifs incluent-ils les médicaments ?",
        answer: "Non, les médicaments sont facturés séparément selon la prescription du médecin. Cependant, nous avons une pharmacie sur place avec tarifs compétitifs."
    },
    {
        id: 2,
        question: "Puis-je payer en plusieurs fois ?",
        answer: "Oui, des arrangements sont possibles pour les interventions coûteuses. Veuillez nous contacter pour discuter les modalités avant votre intervention."
    },
    {
        id: 3,
        question: "Ma mutuelle est-elle acceptée ?",
        answer: "Nous acceptons les principales mutuelles (CNPS, ASCOMA, CAMTEL, etc.). Pour les autres mutuelles, vous pouvez payer d'abord et demander un remboursement auprès de votre mutuelle."
    },
    {
        id: 4,
        question: "Y a-t-il des frais cachés ?",
        answer: "Non, nous garantissons une transparence totale. Un devis détaillé vous est fourni avant toute intervention importante."
    },
    {
        id: 5,
        question: "Tarifs étudiants : comment en bénéficier ?",
        answer: "Présentez simplement votre carte d'étudiant valide lors de votre première consultation. Une réduction de 20-30% s'appliquera automatiquement."
    }
]

// Logique de filtrage
const filteredServices = computed(() => {
    let services = props.servicesTarifs

    // Filtre par recherche (nom service ou désignation tarif)
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        services = services.filter(service =>
            service.nom.toLowerCase().includes(query) ||
            service.tarifs.some(t =>
                t.designation.toLowerCase().includes(query)
            )
        )
    }

    // Filtre par catégorie
    if (activeFilter.value !== 'tous') {
        services = services.filter(service => {
            const serviceType = mapServiceToCategory(service.nom)
            return serviceType === activeFilter.value
        })
    }

    return services
})

// Mapper service à catégorie
const mapServiceToCategory = (serviceName) => {
    const name = serviceName.toLowerCase()

    if (name.includes('consultation') || name.includes('générale')) return 'consultations'
    if (name.includes('examen') || name.includes('radiologie') || name.includes('laboratoire')) return 'examens'
    if (name.includes('chirurgie') || name.includes('intervention')) return 'interventions'
    if (name.includes('accouchement') || name.includes('maternité') || name.includes('gynéco')) return 'maternite'

    return 'consultations' // Par défaut
}

// Obtenir tarif étudiant pour un tarif
const getTarifEtudiant = (tarif, allTarifs) => {
    const studentTarif = allTarifs?.find(t =>
        t.designation === tarif.designation &&
        t.type_patient === 'etudiant'
    )
    return studentTarif?.montant || null
}

// Vérifier s'il y a un tarif étudiant pour ce tarif normal
const hasTarifEtudiant = (tarif, allTarifs) => {
    return getTarifEtudiant(tarif, allTarifs) !== null
}

// Toggle FAQ
const toggleFaq = (id) => {
    expandedFaqs.value[id] = !expandedFaqs.value[id]
}

// Totaux de tarifs par service
const getTarifStats = (service) => {
    const tarifNormals = service.tarifs.filter(t => t.type_patient === 'normal')
    return tarifNormals.length
}
</script>

<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-primary-50 to-white py-16 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center text-center">
                    <!-- Icon -->
                    <div class="mb-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-primary-100 rounded-full">
                            <DollarSign class="w-12 h-12 text-primary-600" />
                        </div>
                    </div>

                    <!-- Titre et sous-titre -->
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
                        Nos Tarifs & Paiements
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 max-w-2xl">
                        Transparence totale sur nos prix. Soins de qualité à tarifs justes et accessibles à tous.
                    </p>

                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold">
                        ✓ Mutuelles CNPS acceptées
                    </div>
                </div>
            </div>
        </section>

        <!-- Barre de Recherche -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="relative">
                <Search class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Rechercher un tarif ou un service..."
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-600 focus:border-transparent"
                />
            </div>
        </section>

        <!-- Filtres Rapides -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
            <div class="flex flex-wrap gap-3">
                <button
                    v-for="cat in categories"
                    :key="cat.value"
                    @click="activeFilter = cat.value"
                    :class="[
                        'px-4 py-2 rounded-full font-semibold transition-all duration-300',
                        activeFilter === cat.value
                            ? 'bg-primary-600 text-white shadow-lg'
                            : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                    ]"
                >
                    {{ cat.label }}
                </button>
            </div>
        </section>

        <!-- Grille Tarifs par Service -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div v-if="filteredServices.length > 0" class="space-y-12">
                <!-- Card Service Tarifaire -->
                <div
                    v-for="service in filteredServices"
                    :key="service.id"
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow"
                >
                    <!-- Header Service -->
                    <div class="bg-gradient-to-r from-primary-50 to-primary-100 px-6 sm:px-8 py-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-primary-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-2xl text-white">🏥</span>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ service.nom }}</h2>
                            </div>
                            <div class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ getTarifStats(service) }} tarif{{ getTarifStats(service) > 1 ? 's' : '' }}
                            </div>
                        </div>
                    </div>

                    <!-- Tableau Tarifs -->
                    <div class="overflow-x-auto">
                        <!-- Desktop Table -->
                        <table class="hidden md:table w-full">
                            <thead class="bg-primary-50 border-b-2 border-gray-200">
                                <tr>
                                    <th class="text-left px-6 py-4 font-semibold text-gray-900">Désignation</th>
                                    <th class="text-right px-6 py-4 font-semibold text-gray-900">Tarif Normal</th>
                                    <th class="text-right px-6 py-4 font-semibold text-gray-900">Tarif Étudiant</th>
                                    <th class="text-left px-6 py-4 font-semibold text-gray-900">Détails</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(tarif, index) in service.tarifs.filter(t => t.type_patient === 'normal')"
                                    :key="tarif.id"
                                    :class="[
                                        'border-b border-gray-200 hover:bg-blue-50 transition-colors',
                                        index % 2 === 0 ? 'bg-white' : 'bg-gray-50'
                                    ]"
                                >
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ tarif.designation }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-2xl font-bold text-primary-600">
                                            {{ tarif.montant.toLocaleString() }}
                                        </span>
                                        <span class="text-sm text-gray-600 ml-1">FCFA</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span
                                            v-if="hasTarifEtudiant(tarif, service.tarifs)"
                                            class="text-2xl font-bold text-secondary-600"
                                        >
                                            {{ getTarifEtudiant(tarif, service.tarifs).toLocaleString() }} FCFA
                                        </span>
                                        <span v-else class="text-gray-400">—</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ tarif.details || '—' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Mobile Cards -->
                        <div class="md:hidden space-y-4 p-6">
                            <div
                                v-for="tarif in service.tarifs.filter(t => t.type_patient === 'normal')"
                                :key="tarif.id"
                                class="bg-gray-50 rounded-lg p-4 border border-gray-200"
                            >
                                <div class="font-semibold text-gray-900 mb-3">{{ tarif.designation }}</div>

                                <!-- Prix Normal -->
                                <div class="mb-2">
                                    <div class="text-sm text-gray-600 mb-1">Tarif Normal</div>
                                    <div class="text-3xl font-bold text-primary-600">
                                        {{ tarif.montant.toLocaleString() }} FCFA
                                    </div>
                                </div>

                                <!-- Prix Étudiant -->
                                <div v-if="hasTarifEtudiant(tarif, service.tarifs)" class="mb-3">
                                    <span class="inline-flex items-center gap-2 bg-secondary-100 text-secondary-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        📚 Étudiant : {{ getTarifEtudiant(tarif, service.tarifs).toLocaleString() }} FCFA
                                    </span>
                                </div>

                                <!-- Détails -->
                                <div v-if="tarif.details" class="text-sm text-gray-600 border-t border-gray-300 pt-3 mt-3">
                                    {{ tarif.details }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aucun résultat -->
            <div v-else class="bg-blue-50 rounded-xl p-12 text-center border-2 border-blue-200">
                <p class="text-xl text-blue-900 mb-4">
                    Aucun tarif ne correspond à votre recherche.
                </p>
                <Button
                    @click="searchQuery = ''; activeFilter = 'tous'"
                    variant="primary"
                    size="md"
                >
                    Réinitialiser les filtres
                </Button>
            </div>
        </section>

        <!-- Section Informations Paiements -->
        <section class="bg-gray-50 py-16 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">
                    Moyens de Paiement & Partenaires
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Moyens de Paiement -->
                    <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <CreditCard class="w-6 h-6 text-blue-600" />
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Moyens de Paiement</h3>
                        </div>

                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center gap-2 text-gray-700">
                                <span class="w-2 h-2 bg-primary-600 rounded-full"></span>
                                Espèces
                            </li>
                            <li class="flex items-center gap-2 text-gray-700">
                                <span class="w-2 h-2 bg-primary-600 rounded-full"></span>
                                Mobile Money (MTN, Orange)
                            </li>
                            <li class="flex items-center gap-2 text-gray-700">
                                <span class="w-2 h-2 bg-primary-600 rounded-full"></span>
                                Chèque
                            </li>
                        </ul>

                        <p class="text-sm text-gray-600 bg-blue-50 p-3 rounded">
                            💳 Paiement en plusieurs fois possible. Nous consulter.
                        </p>
                    </div>

                    <!-- Mutuelles Partenaires -->
                    <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <Shield class="w-6 h-6 text-green-600" />
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Mutuelles Partenaires</h3>
                        </div>

                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center gap-2 text-gray-700">
                                <span class="w-2 h-2 bg-primary-600 rounded-full"></span>
                                CNPS
                            </li>
                            <li class="flex items-center gap-2 text-gray-700">
                                <span class="w-2 h-2 bg-primary-600 rounded-full"></span>
                                ASCOMA
                            </li>
                            <li class="flex items-center gap-2 text-gray-700">
                                <span class="w-2 h-2 bg-primary-600 rounded-full"></span>
                                CAMTEL
                            </li>
                        </ul>

                        <p class="text-sm text-gray-600 bg-green-50 p-3 rounded">
                            🔗 Tiers payant según mutuelle. Autres : paiement puis remboursement.
                        </p>
                    </div>

                    <!-- Aide Sociale -->
                    <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <Heart class="w-6 h-6 text-red-600" />
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Aide Sociale</h3>
                        </div>

                        <p class="text-gray-700 mb-6">
                            Tarifs réduits disponibles pour familles nombreuses et cas sociaux.
                        </p>

                        <Link
                            href="/contact"
                            class="inline-block bg-primary-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-primary-700 transition-colors"
                        >
                            Nous Contacter
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">
                Questions Fréquentes
            </h2>

            <div class="space-y-4">
                <div
                    v-for="faq in faqs"
                    :key="faq.id"
                    class="bg-white rounded-lg border border-gray-200 overflow-hidden"
                >
                    <!-- FAQ Question (Header) -->
                    <button
                        @click="toggleFaq(faq.id)"
                        class="w-full flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors"
                    >
                        <h3 class="text-lg font-semibold text-gray-900 text-left">
                            {{ faq.question }}
                        </h3>
                        <span class="flex-shrink-0 ml-4">
                            <ChevronDown
                                v-if="!expandedFaqs[faq.id]"
                                class="w-5 h-5 text-gray-500 transition-transform"
                            />
                            <ChevronUp
                                v-else
                                class="w-5 h-5 text-primary-600 transition-transform"
                            />
                        </span>
                    </button>

                    <!-- FAQ Answer (Content) -->
                    <transition
                        enter-active-class="transition-all duration-300"
                        leave-active-class="transition-all duration-300"
                        enter-from-class="max-h-0 opacity-0"
                        enter-to-class="max-h-96 opacity-100"
                        leave-from-class="max-h-96 opacity-100"
                        leave-to-class="max-h-0 opacity-0"
                    >
                        <div v-show="expandedFaqs[faq.id]" class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <p class="text-gray-700 leading-relaxed">
                                {{ faq.answer }}
                            </p>
                        </div>
                    </transition>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-16 mt-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                    Vous avez des questions sur nos tarifs ?
                </h2>
                <p class="text-primary-100 text-lg mb-8">
                    Notre équipe administrative est à votre disposition pour clarifier nos tarifs.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <Link
                        href="/contact"
                        class="inline-flex items-center justify-center gap-2 bg-white text-primary-700 font-semibold py-3 px-8 rounded-lg hover:bg-gray-100 transition-colors"
                    >
                        Nous Contacter
                    </Link>
                    <Link
                        href="/rendez-vous"
                        class="inline-flex items-center justify-center gap-2 border-2 border-white text-white font-semibold py-3 px-8 rounded-lg hover:bg-white hover:text-primary-700 transition-colors"
                    >
                        Prendre Rendez-vous
                    </Link>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
/* Optimisations pour lisibilité des prix */
:deep(.text-3xl) {
    font-size: 1.875rem;
    line-height: 2.25rem;
}

@media (max-width: 640px) {
    :deep(.text-3xl) {
        font-size: 2rem;
        line-height: 2.5rem;
    }
}

/* Contraste des prix */
.text-primary-600 {
    color: #00A651;
}

/* Transitions lisses */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}
</style>
