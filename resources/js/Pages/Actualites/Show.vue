<script setup>
import { ref, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import ActualiteCard from '@/Components/ActualiteCard.vue'
import { Calendar, Clock, Eye, User, ArrowLeft, Share2, Facebook, Twitter, Heart } from 'lucide-vue-next'

const props = defineProps({
  actualite: Object,
  similaires: Array,
  likeStats: Object
})

const userIdentifier = ref(localStorage.getItem('user_identifier') || `guest-${Math.random().toString(36).substring(2, 11)}`)
const userReaction = ref(null)
const showReactionPicker = ref(false)

// Sauvegarder l'identifiant
if (!localStorage.getItem('user_identifier')) {
  localStorage.setItem('user_identifier', userIdentifier.value)
}

// Couleur badge catégorie
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

const reactionTypes = [
  { type: 'like', emoji: '👍', label: 'Like' },
  { type: 'love', emoji: '❤️', label: 'Love' },
  { type: 'wow', emoji: '😮', label: 'Wow' },
  { type: 'sad', emoji: '😢', label: 'Sad' },
  { type: 'angry', emoji: '😠', label: 'Angry' }
]

// Partager sur réseaux sociaux
const partagerFacebook = () => {
  const url = encodeURIComponent(window.location.href)
  window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400')
}

const partagerTwitter = () => {
  const url = encodeURIComponent(window.location.href)
  const text = encodeURIComponent(props.actualite.titre)
  window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400')
}

// Ajouter réaction
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

      if (props.actualite && data.likes_count !== undefined) {
        props.actualite.likes_count = data.likes_count
      }

      fetchLikeStats()
    }
    showReactionPicker.value = false
  } catch (error) {
    console.error('Erreur lors de l\'ajout de la réaction:', error)
  }
}

// Charger les stats de likes
const fetchLikeStats = async () => {
  try {
    const response = await fetch(`/api/actualites/${props.actualite.id}/like/stats`)
    const data = await response.json()
    Object.assign(props.likeStats, data)
  } catch (error) {
    console.error('Erreur lors de la récupération des stats:', error)
  }
}

// Extraire ID YouTube
const getYouTubeEmbedUrl = (url) => {
  if (!url) return null
  const youtubeRegex = /(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/
  const match = url.match(youtubeRegex)
  if (match && match[1]) {
    return `https://www.youtube.com/embed/${match[1]}`
  }
  return url
}

// Extraire ID Vimeo
const getVimeoEmbedUrl = (url) => {
  if (!url) return null
  const vimeoRegex = /vimeo\.com\/(\d+)/
  const match = url.match(vimeoRegex)
  if (match && match[1]) {
    return `https://player.vimeo.com/video/${match[1]}`
  }
  return url
}

onMounted(async () => {
  try {
    const response = await fetch(`/api/actualites/${props.actualite.id}/like/user-reaction?user_identifier=${userIdentifier.value}`)
    const data = await response.json()
    userReaction.value = data.reaction_type
  } catch (error) {
    console.error('Erreur:', error)
  }
})
</script>

<template>
  <Head :title="`${actualite.titre} - HRA Dschang`" />

  <AppLayout>
    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-200">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <Link
          href="/actualites"
          class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium"
        >
          <ArrowLeft :size="20" />
          Retour aux actualités
        </Link>
      </div>
    </div>

    <!-- Article -->
    <article class="py-12 bg-gray-50">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <header class="bg-white rounded-xl shadow-sm p-8 mb-8">
          <!-- Catégorie -->
          <span
            :class="['inline-block text-sm font-semibold px-4 py-2 rounded-full mb-4', couleurCategorie(actualite.categorie)]"
          >
            {{ actualite.categorie }}
          </span>

          <!-- Titre -->
          <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            {{ actualite.titre }}
          </h1>

          <!-- Meta informations -->
          <div class="flex flex-wrap items-center gap-6 text-gray-600 mb-6">
            <div class="flex items-center gap-2">
              <User :size="18" />
              <span class="font-medium">{{ actualite.auteur }}</span>
            </div>
            <div class="flex items-center gap-2">
              <Calendar :size="18" />
              <span>{{ actualite.date_formattee }}</span>
            </div>
            <div class="flex items-center gap-2">
              <Clock :size="18" />
              <span>{{ actualite.temps_lecture }}</span>
            </div>
            <div class="flex items-center gap-2">
              <Eye :size="18" />
              <span>{{ actualite.vues }} vues</span>
            </div>
            <div class="flex items-center gap-2">
              <Heart :size="18" />
              <span>{{ actualite.likes_count }} réactions</span>
            </div>
          </div>

          <!-- Actions Header -->
          <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <div class="flex items-center gap-2">
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
                  class="absolute bottom-full left-0 mb-2 bg-white border border-gray-200 rounded-lg shadow-lg p-2 flex gap-1 z-10"
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

              <!-- Autres boutons -->
              <button class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition text-sm font-medium">
                Commenter
              </button>
            </div>

            <!-- Partage réseaux sociaux -->
            <div class="flex items-center gap-2">
              <span class="text-sm text-gray-600 font-medium">Partager :</span>
              <button
                @click="partagerFacebook"
                class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium"
              >
                <Facebook :size="16" />
                Facebook
              </button>
              <button
                @click="partagerTwitter"
                class="flex items-center gap-2 bg-sky-500 text-white px-4 py-2 rounded-lg hover:bg-sky-600 transition text-sm font-medium"
              >
                <Twitter :size="16" />
                Twitter
              </button>
            </div>
          </div>

          <!-- Statistiques de réactions -->
          <div v-if="likeStats && likeStats.total > 0" class="grid grid-cols-5 gap-2 pt-6 border-t border-gray-200 mt-6">
            <div class="text-center">
              <div class="text-lg">👍</div>
              <p class="text-xs text-gray-600">{{ likeStats.by_type.like }}</p>
            </div>
            <div class="text-center">
              <div class="text-lg">❤️</div>
              <p class="text-xs text-gray-600">{{ likeStats.by_type.love }}</p>
            </div>
            <div class="text-center">
              <div class="text-lg">😮</div>
              <p class="text-xs text-gray-600">{{ likeStats.by_type.wow }}</p>
            </div>
            <div class="text-center">
              <div class="text-lg">😢</div>
              <p class="text-xs text-gray-600">{{ likeStats.by_type.sad }}</p>
            </div>
            <div class="text-center">
              <div class="text-lg">😠</div>
              <p class="text-xs text-gray-600">{{ likeStats.by_type.angry }}</p>
            </div>
          </div>
        </header>

        <!-- Média (Vidéo ou Image) -->
        <div v-if="actualite.video || actualite.image" class="mb-8 rounded-xl overflow-hidden shadow-lg bg-black">
          <!-- Vidéo Upload -->
          <video
            v-if="actualite.video && actualite.video_type === 'upload'"
            :src="actualite.video"
            controls
            class="w-full h-auto"
          />
          <!-- YouTube -->
          <iframe
            v-else-if="actualite.video && actualite.video_type === 'youtube'"
            :src="getYouTubeEmbedUrl(actualite.video)"
            class="w-full aspect-video"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
          />
          <!-- Vimeo -->
          <iframe
            v-else-if="actualite.video && actualite.video_type === 'vimeo'"
            :src="getVimeoEmbedUrl(actualite.video)"
            class="w-full aspect-video"
            allow="autoplay; fullscreen; picture-in-picture"
            allowfullscreen
          />
          <!-- Image -->
          <img
            v-else-if="actualite.image"
            :src="actualite.image"
            :alt="actualite.titre"
            class="w-full h-auto"
          />
        </div>

        <!-- Placeholder si pas de media -->
        <div v-else class="mb-8 rounded-xl bg-gradient-to-br from-primary-100 to-primary-50 h-64 flex items-center justify-center">
          <div class="text-center">
            <svg class="w-24 h-24 text-primary-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="text-primary-600 text-lg font-medium">Aucune image ou vidéo</p>
          </div>
        </div>

        <!-- Contenu -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
          <div
            class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-p:text-gray-700 prose-a:text-primary-600 prose-strong:text-gray-900 prose-ul:text-gray-700"
            v-html="actualite.contenu"
          />
        </div>

        <!-- CTA Contact -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl p-8 text-white text-center mb-12">
          <h3 class="text-2xl font-bold mb-4">Une question sur cet article ?</h3>
          <p class="text-white mb-6">
            Notre équipe médicale est à votre disposition pour répondre à vos questions
          </p>
          <Link
            href="/contact"
            class="inline-block bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-primary-50 transition"
          >
            Nous contacter
          </Link>
        </div>

        <!-- Articles similaires -->
        <section v-if="similaires.length > 0" class="mb-8">
          <h2 class="text-3xl font-bold text-gray-900 mb-8">Articles similaires</h2>
          <div class="grid md:grid-cols-3 gap-8">
            <ActualiteCard
              v-for="article in similaires"
              :key="article.id"
              :article="article"
              :couleurCategorie="couleurCategorie"
            />
          </div>
        </section>
      </div>
    </article>
  </AppLayout>
</template>
