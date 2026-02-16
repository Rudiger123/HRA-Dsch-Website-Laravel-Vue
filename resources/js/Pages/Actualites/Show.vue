<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import ActualiteCard from '@/Components/ActualiteCard.vue'
import { Calendar, Clock, Eye, User, ArrowLeft, Share2, Facebook, Twitter } from 'lucide-vue-next'

const props = defineProps({
  actualite: Object,
  similaires: Array
})

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
        <header class="bg-white rounded-xl shadow-sm p-8 mb-8 animate-fade-in-down">
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
          </div>

          <!-- Boutons partage -->
          <div class="flex items-center gap-3 pt-6 border-t border-gray-200">
            <span class="text-sm text-gray-600 font-medium flex items-center gap-2">
              <Share2 :size="18" />
              Partager :
            </span>
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
        </header>

        <!-- Image de couverture -->
        <div v-if="actualite.image" class="mb-8 rounded-xl overflow-hidden shadow-lg animate-fade-in">
          <img
            :src="actualite.image"
            :alt="actualite.titre"
            class="w-full h-auto"
          />
        </div>

        <!-- Contenu -->
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8 animate-fade-in-up">
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
