<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import ActualiteCard from '@/Components/ActualiteCard.vue'
import { ref, computed, watch } from 'vue'
import { Search, Filter, Newspaper, ChevronLeft, ChevronRight } from 'lucide-vue-next'

const props = defineProps({
  actualites: Object,  // Pagination Laravel
  categories: Array,
  filtreCategorie: String,
  searchQuery: String
})

const categorieActive = ref(props.filtreCategorie || 'Toutes')
const recherche = ref(props.searchQuery || '')

// Recherche en temps réel
watch(recherche, () => {
  effectuerRecherche()
}, { debounce: 300 })

// Filtrer par catégorie
const filtrerCategorie = (categorie) => {
  categorieActive.value = categorie

  const params = {}
  if (categorie !== 'Toutes') {
    params.categorie = categorie
  }
  if (recherche.value) {
    params.search = recherche.value
  }

  router.get('/actualites', params, {
    preserveState: true,
    preserveScroll: true
  })
}

// Rechercher
const effectuerRecherche = () => {
  const params = {}
  if (recherche.value) {
    params.search = recherche.value
  }
  if (categorieActive.value !== 'Toutes') {
    params.categorie = categorieActive.value
  }

  router.get('/actualites', params, {
    preserveState: true,
    preserveScroll: true
  })
}

// Couleurs de badge par catégorie
const couleurCategorie = (categorie) => {
  const couleurs = {
    'Nutrition': 'bg-green-100 text-green-700',
    'Prévention': 'bg-purple-100 text-purple-700',
    'Sport & Santé': 'bg-orange-100 text-orange-700',
    'Maternité': 'bg-pink-100 text-pink-700',
    'Santé Mentale': 'bg-indigo-100 text-indigo-700',
    'Événements': 'bg-danger-100 text-danger-700'
  }
  return couleurs[categorie] || 'bg-gray-100 text-gray-700'
}
</script>

<template>
  <Head title="Actualités Santé - HRA Dschang" />

  <AppLayout>
    <!-- Hero Section -->
    <section class="gradient-hrad py-16 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center animate-fade-in-down">
          <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6">
            <Newspaper :size="40" />
          </div>
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Actualités & Blog Santé</h1>
          <p class="text-xl text-primary-100 max-w-3xl mx-auto mb-8">
            Restez informés sur les dernières avancées médicales, conseils de santé et actualités de l'HRA Dschang
          </p>

          <!-- Barre de recherche -->
          <div class="max-w-2xl mx-auto">
            <div class="relative">
              <input
                v-model="recherche"
                type="text"
                placeholder="Rechercher un article..."
                class="w-full px-6 py-4 pr-12 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-secondary-500 transition"
              />
              <div class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400">
                <Search :size="20" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Filtres par catégorie -->
    <section class="bg-white border-b border-gray-200 sticky top-0 z-40">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center gap-2 overflow-x-auto">
          <Filter :size="20" class="text-gray-500 flex-shrink-0" />
          <button
            @click="filtrerCategorie('Toutes')"
            :class="[
              'px-4 py-2 rounded-full font-medium whitespace-nowrap transition',
              categorieActive === 'Toutes'
                ? 'bg-primary-600 text-white'
                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
            ]"
          >
            Tous les articles
          </button>
          <button
            v-for="categorie in categories"
            :key="categorie"
            @click="filtrerCategorie(categorie)"
            :class="[
              'px-4 py-2 rounded-full font-medium whitespace-nowrap transition',
              categorieActive === categorie
                ? 'bg-primary-600 text-white'
                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
            ]"
          >
            {{ categorie }}
          </button>
        </div>
      </div>
    </section>

    <!-- Articles -->
    <section class="py-12 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Résultats -->
        <div class="mb-8">
          <p class="text-gray-600">
            <span class="font-semibold">{{ actualites.total }}</span>
            {{ actualites.total > 1 ? 'articles trouvés' : 'article trouvé' }}
          </p>
        </div>

        <!-- Grille d'articles -->
        <div v-if="actualites.data.length > 0" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
          <ActualiteCard
            v-for="article in actualites.data"
            :key="article.id"
            :article="article"
            :couleurCategorie="couleurCategorie"
            class="animate-fade-in-up"
          />
        </div>

        <!-- Aucun résultat -->
        <div v-else class="text-center py-16">
          <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-200 rounded-full mb-6">
            <Search :size="40" class="text-gray-400" />
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun article trouvé</h3>
          <p class="text-gray-600 mb-6">Essayez avec d'autres mots-clés ou catégories</p>
          <button
            @click="() => { recherche = ''; categorieActive = 'Toutes'; filtrerCategorie('Toutes') }"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition"
          >
            Réinitialiser les filtres
          </button>
        </div>

        <!-- Pagination -->
        <div v-if="actualites.last_page > 1" class="flex justify-center items-center gap-2">
          <Link
            v-if="actualites.prev_page_url"
            :href="actualites.prev_page_url"
            preserve-state
            class="p-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition"
          >
            <ChevronLeft :size="20" class="text-gray-600" />
          </Link>

          <template v-for="page in actualites.last_page" :key="page">
            <Link
              :href="`/actualites?page=${page}`"
              preserve-state
              :class="[
                'px-4 py-2 rounded-lg font-semibold transition',
                actualites.current_page === page
                  ? 'bg-primary-600 text-white'
                  : 'border border-gray-300 hover:bg-gray-100'
              ]"
            >
              {{ page }}
            </Link>
          </template>

          <Link
            v-if="actualites.next_page_url"
            :href="actualites.next_page_url"
            preserve-state
            class="p-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition"
          >
            <ChevronRight :size="20" class="text-gray-600" />
          </Link>
        </div>
      </div>
    </section>

    <!-- Newsletter CTA -->
    <section class="py-16 gradient-hrad text-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="mb-6">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full">
            <Newspaper :size="32" />
          </div>
        </div>
        <h2 class="text-4xl md:text-5xl font-bold mb-4 text-white drop-shadow-lg">Restez Informé avec Notre Newsletter</h2>
        <p class="text-xl text-white mb-8">
          Recevez nos conseils santé et actualités médicales directement dans votre boîte mail
        </p>
        <div class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
          <input
            type="email"
            placeholder="Votre adresse email"
            class="flex-1 px-6 py-3 rounded-lg bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-secondary-500"
          />
          <button class="bg-primary-800 text-primary-50 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 hover:text-primary-600 hover:shadow-xl transform hover:scale-105 transition-all duration-200 active:scale-95">
            S'abonner
          </button>
        </div>
        <p class="text-sm text-white mt-4">
          🔒 Vos données sont protégées et ne seront jamais partagées
        </p>
      </div>
    </section>
  </AppLayout>
</template>
