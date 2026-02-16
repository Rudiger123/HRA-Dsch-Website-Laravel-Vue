<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import axios from 'axios'
import { Search, Loader, AlertCircle } from 'lucide-vue-next'
import SearchResultItem from './SearchResultItem.vue'

// Refs
const isOpen = ref(false)
const searchQuery = ref('')
const selectedIndex = ref(0)
const loading = ref(false)
const error = ref('')
const searchResults = ref({
  services: [],
  medecins: [],
  actualites: [],
  rdv: [],
  users: []
})
const recentSearches = ref([])

// Computed
const allResults = computed(() => {
  const results = []
  Object.entries(searchResults.value).forEach(([category, items]) => {
    results.push(...items.map(item => ({ ...item, category })))
  })
  return results
})

const hasResults = computed(() => allResults.value.length > 0)
const page = usePage()

/**
 * Initialiser les recherches récentes depuis le localStorage
 */
const loadRecentSearches = () => {
  const stored = localStorage.getItem('admin_recent_searches')
  if (stored) {
    recentSearches.value = JSON.parse(stored)
  }
}

/**
 * Sauvegarder une recherche dans l'historique
 */
const saveRecentSearch = (query) => {
  const filtered = recentSearches.value.filter(s => s !== query)
  const updated = [query, ...filtered].slice(0, 5)
  recentSearches.value = updated
  localStorage.setItem('admin_recent_searches', JSON.stringify(updated))
}

/**
 * Effectuer la recherche globale
 */
const performSearch = async () => {
  if (searchQuery.value.trim().length < 2) {
    searchResults.value = {
      services: [],
      medecins: [],
      actualites: [],
      rdv: [],
      users: []
    }
    return
  }

  loading.value = true
  error.value = ''
  selectedIndex.value = 0

  try {
    // Appeler l'API de recherche globale
    const response = await axios.post('/api/search/global', {
      query: searchQuery.value
    })

    searchResults.value = response.data || {
      services: [],
      medecins: [],
      actualites: [],
      rdv: [],
      users: []
    }
  } catch (err) {
    error.value = 'Erreur lors de la recherche. Veuillez réessayer.'
    console.error('Search error:', err)
  } finally {
    loading.value = false
  }
}

/**
 * Debounce de la recherche
 */
let searchTimeout = null
const handleSearch = () => {
  clearTimeout(searchTimeout)
  selectedIndex.value = 0

  if (searchQuery.value.trim().length === 0) {
    searchResults.value = {
      services: [],
      medecins: [],
      actualites: [],
      rdv: [],
      users: []
    }
    return
  }

  searchTimeout = setTimeout(() => {
    performSearch()
  }, 300)
}

/**
 * Naviguer avec les flèches clavier
 */
const handleKeyDown = (event) => {
  // Si on est dans le modal
  if (!isOpen.value) return

  switch (event.key) {
    case 'ArrowDown':
      event.preventDefault()
      selectedIndex.value = Math.min(selectedIndex.value + 1, allResults.value.length - 1)
      break
    case 'ArrowUp':
      event.preventDefault()
      selectedIndex.value = Math.max(selectedIndex.value - 1, 0)
      break
    case 'Enter':
      event.preventDefault()
      if (allResults.value[selectedIndex.value]) {
        selectResult(allResults.value[selectedIndex.value])
      }
      break
    case 'Escape':
      event.preventDefault()
      close()
      break
  }
}

/**
 * Ouvrir la modal de recherche
 */
const open = () => {
  isOpen.value = true
  document.body.classList.add('overflow-hidden')
  // Utiliser nextTick pour garantir que le focus se fera sur l'input
  setTimeout(() => {
    const input = document.querySelector('[data-search-input]')
    if (input) input.focus()
  }, 0)
}

/**
 * Fermer la modal de recherche
 */
const close = () => {
  isOpen.value = false
  document.body.classList.remove('overflow-hidden')
  searchQuery.value = ''
  searchResults.value = {
    services: [],
    medecins: [],
    actualites: [],
    rdv: [],
    users: []
  }
}

/**
 * Sélectionner un résultat et naviguer
 */
const selectResult = (result) => {
  saveRecentSearch(searchQuery.value)
  close()

  // Router.visit vers le détail du résultat
  if (result.url) {
    router.visit(result.url)
  }
}

/**
 * Raccourci clavier Cmd+K / Ctrl+K
 */
const handleGlobalKeyDown = (event) => {
  // Cmd+K ou Ctrl+K
  if ((event.metaKey || event.ctrlKey) && event.key === 'k') {
    event.preventDefault()
    if (isOpen.value) {
      close()
    } else {
      open()
    }
  }

  // Fermer avec Échap
  if (event.key === 'Escape' && isOpen.value) {
    close()
  }
}

/**
 * Fermer le modal au clic extérieur
 */
const handleBackdropClick = (event) => {
  if (event.target === event.currentTarget) {
    close()
  }
}

// Lifecycle
onMounted(() => {
  loadRecentSearches()
  document.addEventListener('keydown', handleGlobalKeyDown)
  document.addEventListener('keydown', handleKeyDown)
})

onUnmounted(() => {
  document.removeEventListener('keydown', handleGlobalKeyDown)
  document.removeEventListener('keydown', handleKeyDown)
  document.body.classList.remove('overflow-hidden')
})

// Watcher pour fermer le modal si l'utilisateur navigue
watch(() => page.url, () => {
  close()
})

/**
 * Helper function pour calculer l'index global d'un résultat
 */
const calculateIndex = (category, itemIndex) => {
  let index = 0
  const categories = ['services', 'medecins', 'actualites', 'rdv', 'users']

  for (const cat of categories) {
    if (cat === category) {
      return index + itemIndex
    }
    index += searchResults.value[cat].length
  }

  return index
}
</script>

<template>
  <!-- Bouton d'ouverture (optionnel, pour les devices sans raccourci clavier) -->
  <button
    @click="open"
    class="hidden md:flex items-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 rounded-xl text-slate-600 transition-all duration-200 group"
  >
    <Search :size="18" class="text-slate-400 group-hover:text-slate-600" />
    <span class="text-sm font-medium">Rechercher...</span>
    <kbd class="hidden lg:inline-flex items-center px-2 py-0.5 bg-white rounded text-xs font-mono text-slate-400 border border-slate-200 shadow-sm">
      ⌘K
    </kbd>
  </button>

  <!-- Portal pour afficher le modal en dehors du DOM hierarchy -->
  <Teleport to="body">
    <!-- Modal Backdrop -->
    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="isOpen"
        @click="handleBackdropClick"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40"
      />
    </Transition>

    <!-- Modal Content -->
    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 scale-95 transform translate-y-4"
      enter-to-class="opacity-100 scale-100 transform translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 scale-100 transform translate-y-0"
      leave-to-class="opacity-0 scale-95 transform translate-y-4"
    >
      <div
        v-if="isOpen"
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50 w-full mx-4 max-w-2xl p-4 pointer-events-auto"
      >
      <div class="bg-white rounded-2xl shadow-2xl shadow-slate-900/20 border border-slate-200 overflow-hidden">
        <!-- Search Input -->
        <div class="p-4 border-b border-slate-100 bg-white">
          <div class="flex items-center gap-3">
            <Search :size="20" class="text-slate-400 shrink-0" />
            <input
              v-model="searchQuery"
              @input="handleSearch"
              @keydown="handleKeyDown"
              type="text"
              data-search-input
              placeholder="Rechercher services, médecins, actualités, rendez-vous..."
              autofocus
              class="w-full text-lg font-medium bg-transparent border-0 outline-none text-slate-900 placeholder-slate-400"
            />
            <button
              @click="close"
              class="text-slate-400 hover:text-slate-500 transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Results -->
        <div class="max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
          <!-- Loading state -->
          <div v-if="loading" class="p-8 flex items-center justify-center gap-3">
            <Loader :size="20" class="text-primary-600 animate-spin" />
            <span class="text-slate-600">Recherche en cours...</span>
          </div>

          <!-- Error state -->
          <div v-else-if="error" class="p-8">
            <div class="flex items-start gap-3 text-rose-600">
              <AlertCircle :size="20" class="shrink-0 mt-0.5" />
              <div>
                <p class="font-semibold">{{ error }}</p>
              </div>
            </div>
          </div>

          <!-- Results by category -->
          <div v-else-if="hasResults" class="p-2">
            <!-- Services -->
            <div v-if="searchResults.services.length > 0" class="mb-4">
              <p class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Services</p>
              <SearchResultItem
                v-for="(item, index) in searchResults.services"
                :key="`service-${item.id}`"
                :item="item"
                :is-selected="selectedIndex === calculateIndex('services', index)"
                @select="selectResult"
              />
            </div>

            <!-- Médecins -->
            <div v-if="searchResults.medecins.length > 0" class="mb-4">
              <p class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Médecins</p>
              <SearchResultItem
                v-for="(item, index) in searchResults.medecins"
                :key="`medecin-${item.id}`"
                :item="item"
                :is-selected="selectedIndex === calculateIndex('medecins', index)"
                @select="selectResult"
              />
            </div>

            <!-- Actualités -->
            <div v-if="searchResults.actualites.length > 0" class="mb-4">
              <p class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Actualités</p>
              <SearchResultItem
                v-for="(item, index) in searchResults.actualites"
                :key="`actualite-${item.id}`"
                :item="item"
                :is-selected="selectedIndex === calculateIndex('actualites', index)"
                @select="selectResult"
              />
            </div>

            <!-- Rendez-vous -->
            <div v-if="searchResults.rdv.length > 0" class="mb-4">
              <p class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Rendez-vous</p>
              <SearchResultItem
                v-for="(item, index) in searchResults.rdv"
                :key="`rdv-${item.id}`"
                :item="item"
                :is-selected="selectedIndex === calculateIndex('rdv', index)"
                @select="selectResult"
              />
            </div>

            <!-- Utilisateurs -->
            <div v-if="searchResults.users.length > 0" class="mb-4">
              <p class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Utilisateurs</p>
              <SearchResultItem
                v-for="(item, index) in searchResults.users"
                :key="`user-${item.id}`"
                :item="item"
                :is-selected="selectedIndex === calculateIndex('users', index)"
                @select="selectResult"
              />
            </div>
          </div>

          <!-- Empty state avec recherches récentes -->
          <div v-else-if="searchQuery.trim().length === 0" class="p-8">
            <!-- Recherches récentes -->
            <div v-if="recentSearches.length > 0" class="mb-6">
              <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Recherches récentes</p>
              <div class="space-y-1">
                <button
                  v-for="search in recentSearches"
                  :key="search"
                  @click="searchQuery = search; performSearch()"
                  class="w-full flex items-center gap-2 px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-lg transition-colors group"
                >
                  <Search :size="14" class="text-slate-400 group-hover:text-slate-600" />
                  {{ search }}
                </button>
              </div>
            </div>

            <!-- Tips -->
            <div class="text-center py-2">
              <p class="text-xs text-slate-500">Tapez pour commencer la recherche</p>
              <div class="flex items-center justify-center gap-2 mt-3 text-xs text-slate-400">
                <kbd class="px-2 py-1 bg-slate-100 rounded border border-slate-200">↑↓</kbd>
                <span>Naviguer</span>
                <kbd class="px-2 py-1 bg-slate-100 rounded border border-slate-200">Entrée</kbd>
                <span>Sélectionner</span>
                <kbd class="px-2 py-1 bg-slate-100 rounded border border-slate-200">Échap</kbd>
                <span>Fermer</span>
              </div>
            </div>
          </div>

          <!-- No results state -->
          <div v-else class="p-8 text-center">
            <Search :size="32" class="text-slate-300 mx-auto mb-3" />
            <p class="text-slate-600 font-medium">Aucun résultat trouvé</p>
            <p class="text-sm text-slate-500 mt-1">pour "<span class="font-semibold">{{ searchQuery }}</span>"</p>
          </div>
        </div>

        <!-- Footer -->
        <div v-if="hasResults" class="px-4 py-3 border-t border-slate-100 bg-slate-50/50 text-xs text-slate-500 text-center">
          <span class="font-semibold">{{ allResults.length }}</span> résultat{{ allResults.length > 1 ? 's' : '' }} trouvé{{ allResults.length > 1 ? 's' : '' }}
        </div>
      </div>
      </div>
    </Transition>
  </Teleport>
</template>
