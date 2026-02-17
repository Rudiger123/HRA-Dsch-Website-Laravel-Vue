<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { Calendar, Clock, Eye, Heart, PlusCircle } from 'lucide-vue-next'

const props = defineProps({
  article: Object,
  couleurCategorie: Function
})

const showVideoPreview = ref(false)
const userIdentifier = ref(localStorage.getItem('user_identifier') || `guest-${Math.random().toString(36).substring(2, 11)}`)

// Sauvegarder l'identifiant
if (!localStorage.getItem('user_identifier')) {
  localStorage.setItem('user_identifier', userIdentifier.value)
}

// Image par défaut si pas d'image
const imageUrl = props.article.image || '/images/actualites/default.jpg'

// URL vidéo
const videoUrl = props.article.video

// Types de réactions
const reactionTypes = [
  { type: 'like', emoji: '👍', label: 'Like' },
  { type: 'love', emoji: '❤️', label: 'Love' },
  { type: 'wow', emoji: '😮', label: 'Wow' },
  { type: 'sad', emoji: '😢', label: 'Sad' },
  { type: 'angry', emoji: '😠', label: 'Angry' }
]

const addReaction = async (reactionType) => {
  try {
    // TODO: Implémenter l'appel API pour ajouter la réaction
    // const response = await fetch(`/api/actualites/${props.article.id}/like`, {
    //   method: 'POST',
    //   headers: { 'Content-Type': 'application/json' },
    //   body: JSON.stringify({
    //     user_identifier: userIdentifier.value,
    //     reaction_type: reactionType
    //   })
    // })
  } catch (error) {
    console.error('Erreur lors de l\'ajout de la réaction:', error)
  }
}
</script>

<template>
  <Link
    :href="`/actualites/${article.slug}`"
    class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group flex flex-col h-full"
  >
    <!-- Média (Image ou Vidéo) -->
    <div class="h-48 bg-gradient-to-br from-primary-400 to-primary-600 overflow-hidden relative">
      <!-- Vidéo -->
      <template v-if="article.video">
        <video
          v-if="article.video_type === 'upload'"
          :src="videoUrl"
          class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
          @mouseover="showVideoPreview = true"
          @mouseout="showVideoPreview = false"
          preload="metadata"
        />
        <!-- Embed YouTube -->
        <iframe
          v-else-if="article.video_type === 'youtube'"
          :src="article.video"
          class="w-full h-full"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
        />
        <!-- Embed Vimeo -->
        <iframe
          v-else-if="article.video_type === 'vimeo'"
          :src="article.video"
          class="w-full h-full"
          allow="autoplay; fullscreen; picture-in-picture"
          allowfullscreen
        />

        <!-- Badge vidéo -->
        <div class="absolute top-2 left-2 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M4.5 2a2 2 0 00-2 2v12a2 2 0 002 2h11a2 2 0 002-2V4a2 2 0 00-2-2h-11zm6.5 6v4l3-2-3-2z" />
          </svg>
          Vidéo
        </div>
      </template>

      <!-- Image -->
      <template v-else-if="article.image">
        <img
          :src="imageUrl"
          :alt="article.titre"
          class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
        />
      </template>

      <!-- Placeholder gris si ni vidéo ni image -->
      <template v-else>
        <div class="w-full h-full flex items-center justify-center">
          <svg class="w-20 h-20 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
          </svg>
        </div>
      </template>
    </div>

    <!-- Contenu -->
    <div class="p-6 flex flex-col flex-grow">
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
      <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-auto">
        <div class="flex items-center gap-4 text-sm text-gray-500">
          <span class="flex items-center gap-1">
            <Clock :size="14" />
            {{ article.temps_lecture }}
          </span>
          <span class="flex items-center gap-1">
            <Eye :size="14" />
            {{ article.vues }}
          </span>
          <span class="flex items-center gap-1">
            <Heart :size="14" />
            {{ article.likes_count }}
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

