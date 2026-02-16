<script setup>
import { Link } from '@inertiajs/vue3'
import { Calendar, Clock, Eye } from 'lucide-vue-next'

const props = defineProps({
  article: Object,
  couleurCategorie: Function
})

// Image par défaut si pas d'image
const imageUrl = props.article.image || '/images/actualites/default.jpg'
</script>

<template>
  <Link
    :href="`/actualites/${article.slug}`"
    class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group"
  >
    <!-- Image -->
    <div class="h-48 bg-gradient-to-br from-primary-400 to-primary-600 overflow-hidden">
      <img
        v-if="article.image"
        :src="imageUrl"
        :alt="article.titre"
        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
      />
      <div v-else class="w-full h-full flex items-center justify-center">
        <svg class="w-20 h-20 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
          <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
        </svg>
      </div>
    </div>

    <!-- Contenu -->
    <div class="p-6">
      <!-- Catégorie & Date -->
      <div class="flex items-center gap-2 mb-3 flex-wrap">
        <span
          :class="['text-xs font-semibold px-3 py-1 rounded-full', couleurCategorie(article.categorie)]"
        >
          {{ article.categorie }}
        </span>
        <span class="text-sm text-gray-500 flex items-center gap-1">
          <Calendar :size="14" />
          {{ article.date_formattee }}
        </span>
      </div>

      <!-- Titre -->
      <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition line-clamp-2">
        {{ article.titre }}
      </h3>

      <!-- Extrait -->
      <p class="text-gray-600 text-sm mb-4 line-clamp-3">
        {{ article.extrait }}
      </p>

      <!-- Footer -->
      <div class="flex items-center justify-between pt-4 border-t border-gray-100">
        <div class="flex items-center gap-4 text-sm text-gray-500">
          <span class="flex items-center gap-1">
            <Clock :size="14" />
            {{ article.temps_lecture }}
          </span>
          <span class="flex items-center gap-1">
            <Eye :size="14" />
            {{ article.vues }}
          </span>
        </div>
        <span class="text-primary-600 text-sm font-semibold group-hover:gap-2 flex items-center gap-1 transition-all">
          Lire
          <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </span>
      </div>
    </div>
  </Link>
</template>
