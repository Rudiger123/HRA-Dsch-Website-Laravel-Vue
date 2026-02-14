<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { HelpCircle, Search, ChevronDown } from 'lucide-vue-next'

// State
const searchQuery = ref('')
const activeCategory = ref('toutes')
const openQuestions = ref([])

// FAQ Data
const faqData = [
  {
    id: 1,
    categorie: 'Consultations',
    question: 'Comment prendre rendez-vous ?',
    reponse: 'Vous pouvez prendre rendez-vous en ligne via notre formulaire, par téléphone au +237 XXX XXX XXX, ou directement au secrétariat. Les rendez-vous en ligne sont généralement confirmés dans les 24 heures.'
  },
  {
    id: 2,
    categorie: 'Tarifs',
    question: 'Les tarifs incluent-ils les médicaments ?',
    reponse: 'Non, les médicaments sont facturés séparément selon la prescription du médecin. Nous vous fournissons une ordonnance que vous pouvez honorer à notre pharmacie ou en ville.'
  },
  {
    id: 3,
    categorie: 'Horaires',
    question: 'Quels sont vos horaires d\'ouverture ?',
    reponse: 'Nous sommes ouverts du lundi au vendredi de 8h à 17h, et le samedi de 8h à 12h. Le service des urgences est disponible 24h/24 et 7j/7.'
  },
  {
    id: 4,
    categorie: 'Services',
    question: 'Quels services médicaux proposez-vous ?',
    reponse: 'HRAD propose 8 services : Pédiatrie, Maternité, Cardiologie, Chirurgie, Urgences, Médecine Générale, Laboratoire, et Radiologie. Chaque service est dirigé par des médecins spécialistes expérimentés.'
  },
  {
    id: 5,
    categorie: 'Rendez-vous',
    question: 'Dois-je prendre rendez-vous pour les urgences ?',
    reponse: 'Non, le service des urgences ne nécessite pas de rendez-vous. Présentez-vous directement avec votre carte d\'identité et moyens de paiement. Notre équipe d\'urgence est disponible 24h/24.'
  },
  {
    id: 6,
    categorie: 'Tarifs',
    question: 'Acceptez-vous les mutuelles ?',
    reponse: 'Oui, nous avons des conventions avec plusieurs mutuelles dont CNPS, ASCOMA, et CAMTEL. Le tiers payant est possible selon votre mutuelle. Veuillez nous présenter votre carte mutuelle.'
  },
  {
    id: 7,
    categorie: 'Tarifs',
    question: 'Y a-t-il des tarifs étudiants ?',
    reponse: 'Oui, les étudiants bénéficient de tarifs réduits sur présentation d\'une carte étudiante valide. Réduction de 20 à 40% selon les services consultés.'
  },
  {
    id: 8,
    categorie: 'Services',
    question: 'Faites-vous des accouchements ?',
    reponse: 'Oui, notre service maternité est disponible 24h/24. Accouchements normaux et césariennes sont pratiqués par des sages-femmes et gynécologues expérimentés.'
  },
  {
    id: 9,
    categorie: 'Consultations',
    question: 'Faut-il une ordonnance pour les consultations spécialisées ?',
    reponse: 'Non, vous pouvez consulter directement les médecins spécialistes sans ordonnance. Cependant, votre médecin généraliste peut vous orienter pour des consultations plus adaptées.'
  },
  {
    id: 10,
    categorie: 'Horaires',
    question: 'Avez-vous des services le dimanche ?',
    reponse: 'Le Centre HRAD n\'est pas ouvert le dimanche, sauf pour les cas d\'urgence. Le service des urgences reste disponible pour toute situation critique.'
  },
  {
    id: 11,
    categorie: 'Services',
    question: 'Faites-vous des analyses de laboratoire ?',
    reponse: 'Oui, notre service de laboratoire est équipé pour réaliser tous les types d\'analyses médicales courantes. Les résultats sont généralement disponibles sous 24 à 48 heures.'
  },
  {
    id: 12,
    categorie: 'Rendez-vous',
    question: 'Puis-je annuler ou reporter mon rendez-vous ?',
    reponse: 'Oui, vous pouvez annuler ou reporter votre rendez-vous en nous contactant au moins 24 heures à l\'avance. Contactez le secrétariat par téléphone ou via notre plateforme en ligne.'
  },
  {
    id: 13,
    categorie: 'Consultations',
    question: 'Les enfants peuvent-ils être consultés ?',
    reponse: 'Oui, HRAD dispose d\'un service de Pédiatrie avec des médecins spécialisés dans la santé des enfants. Les enfants sont reçus sur rendez-vous avec un parent ou tuteur.'
  },
  {
    id: 14,
    categorie: 'Tarifs',
    question: 'Proposez-vous des forfaits ou packages santé ?',
    reponse: 'Nous proposons plusieurs forfaits santé incluant des consultations régulières, des analyses de laboratoire et des suivis médicaux personnalisés. Contactez-nous pour plus d\'informations.'
  },
  {
    id: 15,
    categorie: 'Services',
    question: 'Ferez-vous de la radiologie et imagerie médicale ?',
    reponse: 'Oui, notre service de radiologie dispose d\'équipements modernes y compris radiographie et échographie. Les examens d\'imagerie peuvent être réalisés sur prescription médicale.'
  },
  {
    id: 16,
    categorie: 'Consultations',
    question: 'Comment accéder à dossier médical en ligne ?',
    reponse: 'Une fois inscrit, vous recevez des identifiants pour accéder à votre espace patient sécurisé. Vous y retrouverez vos antécédents, prescriptions et résultats d\'analyses.'
  }
]

// Catégories disponibles
const categories = [
  'toutes',
  'Consultations',
  'Tarifs',
  'Horaires',
  'Services',
  'Rendez-vous'
]

// Computed
const filteredFAQ = computed(() => {
  let faqs = faqData

  // Filtre catégorie
  if (activeCategory.value !== 'toutes') {
    faqs = faqs.filter(f => f.categorie === activeCategory.value)
  }

  // Recherche
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    faqs = faqs.filter(f =>
      f.question.toLowerCase().includes(query) ||
      f.reponse.toLowerCase().includes(query)
    )
  }

  return faqs
})

// Methods
const toggleQuestion = (id) => {
  if (openQuestions.value.includes(id)) {
    openQuestions.value = openQuestions.value.filter(i => i !== id)
  } else {
    openQuestions.value.push(id)
  }
}

const isOpen = (id) => openQuestions.value.includes(id)

const getCategoryLabel = (category) => {
  const labels = {
    'toutes': 'Toutes',
    'Consultations': 'Consultations',
    'Tarifs': 'Tarifs',
    'Horaires': 'Horaires',
    'Services': 'Services',
    'Rendez-vous': 'Rendez-vous'
  }
  return labels[category] || category
}
</script>

<template>
  <AppLayout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-primary-50 to-primary-100 py-20">
      <div class="container mx-auto px-4">
        <div class="flex flex-col items-center justify-center text-center">
          <div class="mb-6 p-4 bg-white rounded-full shadow-lg">
            <HelpCircle class="w-12 h-12 text-primary-600" />
          </div>
          <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Questions Fréquentes</h1>
          <p class="text-lg text-gray-600 max-w-2xl">
            Trouvez rapidement les réponses à vos questions
          </p>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
      <div class="container mx-auto px-4 max-w-3xl">
        <!-- Barre Recherche -->
        <div class="mb-8">
          <div class="relative">
            <Search class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Rechercher une question..."
              class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary-500 transition-colors"
            />
          </div>
        </div>

        <!-- Filtres Catégories -->
        <div class="mb-8 flex flex-wrap gap-3 justify-center">
          <button
            v-for="category in categories"
            :key="category"
            @click="activeCategory = category"
            :class="[
              'px-4 py-2 rounded-full font-medium transition-all duration-200',
              activeCategory === category
                ? 'bg-primary-600 text-white shadow-lg'
                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
            ]"
          >
            {{ getCategoryLabel(category) }}
          </button>
        </div>

        <!-- Résultats -->
        <div v-if="filteredFAQ.length > 0" class="mb-8">
          <p class="text-sm text-gray-600 mb-6">
            {{ filteredFAQ.length }} question(s) trouvée(s)
          </p>

          <!-- Accordion FAQ -->
          <div class="space-y-3">
            <div
              v-for="faq in filteredFAQ"
              :key="faq.id"
              class="bg-white border-2 border-gray-200 rounded-lg overflow-hidden transition-all duration-200 hover:border-primary-300"
            >
              <button
                @click="toggleQuestion(faq.id)"
                class="w-full px-4 py-4 flex justify-between items-center hover:bg-gray-50 transition-colors"
              >
                <span class="font-semibold text-left text-gray-900">{{ faq.question }}</span>
                <ChevronDown
                  :class="[
                    'w-5 h-5 text-primary-600 transition-transform duration-300 flex-shrink-0 ml-4',
                    { 'rotate-180': isOpen(faq.id) }
                  ]"
                />
              </button>

              <transition
                enter-active-class="transition-all duration-300 ease-out"
                leave-active-class="transition-all duration-300 ease-in"
                enter-from-class="max-h-0 opacity-0"
                enter-to-class="max-h-96 opacity-100"
                leave-from-class="max-h-96 opacity-100"
                leave-to-class="max-h-0 opacity-0"
              >
                <div
                  v-show="isOpen(faq.id)"
                  class="px-4 pb-4 text-gray-600 border-t border-gray-100"
                >
                  {{ faq.reponse }}
                </div>
              </transition>
            </div>
          </div>
        </div>

        <!-- Aucun résultat -->
        <div v-else class="text-center py-12">
          <HelpCircle class="w-12 h-12 text-gray-300 mx-auto mb-4" />
          <p class="text-lg text-gray-500 mb-2">Aucune question trouvée</p>
          <p class="text-sm text-gray-400">
            Essayez d'autres mots-clés ou filtres
          </p>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-800 py-16">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">
          Vous ne trouvez pas votre réponse ?
        </h2>
        <p class="text-primary-100 mb-8 max-w-xl mx-auto">
          N'hésitez pas à nous contacter directement. Notre équipe est là pour répondre à toutes vos questions.
        </p>
        <Link
          href="/contact"
          class="inline-block px-8 py-3 bg-white text-primary-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors"
        >
          Contactez-nous
        </Link>
      </div>
    </section>
  </AppLayout>
</template>

<style scoped>
/* Animation smooth pour l'accordion */
.space-y-3 > div {
  transition: all 0.3s ease;
}

.space-y-3 > div:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
</style>
