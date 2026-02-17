<script setup>
import { ref, onMounted } from 'vue'
import { Heart, MessageCircle, Share2, Bookmark } from 'lucide-vue-next'

const props = defineProps({
  actualite: Object,
  likeStats: Object
})

const userIdentifier = ref(localStorage.getItem('user_identifier') || `guest-${Math.random().toString(36).substring(2, 11)}`)
const userReaction = ref(null)
const showReactionPicker = ref(false)
const isVideoExpanded = ref(false)

// Sauvegarder l'identifiant
if (!localStorage.getItem('user_identifier')) {
  localStorage.setItem('user_identifier', userIdentifier.value)
}

const reactionTypes = [
  { type: 'like', emoji: '👍', label: 'Like', color: 'text-blue-500' },
  { type: 'love', emoji: '❤️', label: 'Love', color: 'text-red-500' },
  { type: 'wow', emoji: '😮', label: 'Wow', color: 'text-yellow-500' },
  { type: 'sad', emoji: '😢', label: 'Sad', color: 'text-blue-400' },
  { type: 'angry', emoji: '😠', label: 'Angry', color: 'text-red-600' }
]

const addReaction = async (reactionType) => {
  try {
    const response = await fetch(`/api/actualites/${props.actualite.id}/like`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content
      },
      body: JSON.stringify({
        user_identifier: userIdentifier.value,
        reaction_type: reactionType
      })
    })

    if (response.ok) {
      const data = await response.json()
      userReaction.value = data.reaction_type

      // Mettre à jour le compteur de likes
      if (props.actualite && data.likes_count !== undefined) {
        props.actualite.likes_count = data.likes_count
      }
    }
    showReactionPicker.value = false
  } catch (error) {
    console.error('Erreur lors de l\'ajout de la réaction:', error)
  }
}

const getUserReactionEmoji = () => {
  const reaction = reactionTypes.find(r => r.type === userReaction.value)
  return reaction ? reaction.emoji : '👍'
}

onMounted(async () => {
  // Charger la réaction de l'utilisateur
  try {
    const response = await fetch(`/api/actualites/${props.actualite.id}/like/user-reaction?user_identifier=${userIdentifier.value}`)
    const data = await response.json()
    userReaction.value = data.reaction_type
  } catch (error) {
    console.error('Erreur lors de la récupération de la réaction:', error)
  }
})

// Extraire ID YouTube si URL YouTube
const getYouTubeEmbedUrl = (url) => {
  if (!url) return null

  const youtubeRegex = /(?:youtube\.com\/watch\?v=|youtu\.be/)([^&\n?#]+)/
  const match = url.match(youtubeRegex)

  if (match && match[1]) {
    return `https://www.youtube.com/embed/${match[1]}`
  }
  return url
}

// Extraire ID Vimeo si URL Vimeo
const getVimeoEmbedUrl = (url) => {
  if (!url) return null

  const vimeoRegex = /vimeo\.com\/(\d+)/
  const match = url.match(vimeoRegex)

  if (match && match[1]) {
    return `https://player.vimeo.com/video/${match[1]}`
  }
  return url
}
</script>

<template>
  <article class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Média -->
    <div v-if="actualite.video || actualite.image" class="relative bg-black">
      <!-- Vidéo -->
      <template v-if="actualite.video">
        <!-- Upload vidéo -->
        <video
          v-if="actualite.video_type === 'upload'"
          :src="actualite.video"
          controls
          class="w-full h-auto max-h-96"
        />
        <!-- YouTube -->
        <iframe
          v-else-if="actualite.video_type === 'youtube'"
          :src="getYouTubeEmbedUrl(actualite.video)"
          class="w-full aspect-video"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
        />
        <!-- Vimeo -->
        <iframe
          v-else-if="actualite.video_type === 'vimeo'"
          :src="getVimeoEmbedUrl(actualite.video)"
          class="w-full aspect-video"
          allow="autoplay; fullscreen; picture-in-picture"
          allowfullscreen
        />
      </template>

      <!-- Image -->
      <img
        v-else-if="actualite.image"
        :src="actualite.image"
        :alt="actualite.titre"
        class="w-full h-auto"
      />
    </div>

    <!-- Contenu -->
    <div class="p-8">
      <!-- En-tête -->
      <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
          <span
            class="inline-block px-4 py-2 bg-primary-100 text-primary-800 rounded-full text-sm font-semibold"
          >
            {{ actualite.categorie }}
          </span>
          <span class="text-gray-500 text-sm">{{ actualite.date_formattee }}</span>
        </div>

        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          {{ actualite.titre }}
        </h1>

        <div class="flex items-center gap-6 text-gray-600 border-b border-gray-200 pb-4">
          <span class="text-sm">Par <strong>{{ actualite.auteur }}</strong></span>
          <span class="text-sm">{{ actualite.temps_lecture }}</span>
        </div>
      </div>

      <!-- Contenu -->
      <div class="prose prose-lg max-w-none mb-8" v-html="actualite.contenu" />

      <!-- Actions de réactions -->
      <div class="flex items-center gap-4 py-6 border-t border-b border-gray-200">
        <!-- Bouton Like/Réactions -->
        <div class="relative">
          <button
            @click="showReactionPicker = !showReactionPicker"
            :class="[
              'flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition-all',
              userReaction
                ? 'bg-red-100 text-red-600 hover:bg-red-200'
                : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
            ]"
          >
            <Heart :size="20" :fill="userReaction ? 'currentColor' : 'none'" />
            <span>{{ actualite.likes_count }}</span>
          </button>

          <!-- Sélecteur de réactions -->
          <div
            v-if="showReactionPicker"
            class="absolute bottom-full left-0 mb-2 bg-white border border-gray-200 rounded-lg shadow-lg p-2 flex gap-2 z-10"
          >
            <button
              v-for="reaction in reactionTypes"
              :key="reaction.type"
              @click="addReaction(reaction.type)"
              :title="reaction.label"
              class="text-2xl hover:scale-125 transition-transform"
            >
              {{ reaction.emoji }}
            </button>
          </div>
        </div>

        <!-- Autres actions -->
        <button class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
          <MessageCircle :size="20" />
          <span class="font-medium">Commenter</span>
        </button>

        <button class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
          <Share2 :size="20" />
          <span class="font-medium">Partager</span>
        </button>

        <button class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition ml-auto">
          <Bookmark :size="20" />
          <span class="font-medium">Enregistrer</span>
        </button>
      </div>

      <!-- Statistiques de likes -->
      <div v-if="likeStats" class="grid grid-cols-5 gap-4 py-6">
        <div class="text-center">
          <div class="text-2xl">👍</div>
          <p class="text-sm text-gray-600">{{ likeStats.by_type.like }}</p>
        </div>
        <div class="text-center">
          <div class="text-2xl">❤️</div>
          <p class="text-sm text-gray-600">{{ likeStats.by_type.love }}</p>
        </div>
        <div class="text-center">
          <div class="text-2xl">😮</div>
          <p class="text-sm text-gray-600">{{ likeStats.by_type.wow }}</p>
        </div>
        <div class="text-center">
          <div class="text-2xl">😢</div>
          <p class="text-sm text-gray-600">{{ likeStats.by_type.sad }}</p>
        </div>
        <div class="text-center">
          <div class="text-2xl">😠</div>
          <p class="text-sm text-gray-600">{{ likeStats.by_type.angry }}</p>
        </div>
      </div>
    </div>
  </article>
</template>

<style scoped>
.prose {
  @apply text-gray-700;
}

.prose h2 {
  @apply text-2xl font-bold text-gray-900 mt-6 mb-4;
}

.prose h3 {
  @apply text-xl font-bold text-gray-900 mt-4 mb-3;
}

.prose p {
  @apply mb-4 leading-relaxed;
}

.prose ul,
.prose ol {
  @apply ml-6 mb-4;
}

.prose li {
  @apply mb-2;
}

.prose a {
  @apply text-primary-600 hover:text-primary-700 underline;
}

.prose img {
  @apply max-w-full h-auto rounded-lg my-4;
}

.prose blockquote {
  @apply border-l-4 border-primary-400 pl-4 italic text-gray-600 my-4;
}
</style>
