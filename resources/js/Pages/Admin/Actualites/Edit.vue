<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ImageUpload from '@/Components/Admin/ImageUpload.vue'
import TiptapEditor from '@/Components/Admin/TiptapEditor.vue'
import { ArrowLeft, Save } from 'lucide-vue-next'

const props = defineProps({
  actualite: Object,
  categories: Array,
})

const form = useForm({
  titre: props.actualite.titre,
  extrait: props.actualite.extrait,
  contenu: props.actualite.contenu,
  categorie: props.actualite.categorie,
  auteur: props.actualite.auteur,
  image: null,
  video: null,
  video_type: props.actualite.video_type || 'upload',
  publie: props.actualite.publie,
  date_publication: props.actualite.date_publication.split('T')[0],
})

const submit = () => {
  form.put(route('admin.actualites.update', props.actualite.id), {
    forceFormData: true,
  })
}
</script>

<template>
  <Head :title="`Modifier ${actualite.titre} - Admin`" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <Link
        :href="route('admin.actualites.index')"
        class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-4"
      >
        <ArrowLeft :size="20" />
        Retour à la liste
      </Link>
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier l'article</h1>
      <p class="text-gray-600">{{ actualite.titre }}</p>
    </div>

    <!-- Form -->
    <form @submit.prevent="submit" class="max-w-5xl">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-6">
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <label for="titre" class="block text-sm font-semibold text-gray-700 mb-2">
              Titre de l'article <span class="text-red-500">*</span>
            </label>
            <input
              id="titre"
              v-model="form.titre"
              type="text"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-lg font-semibold"
            />
            <p v-if="form.errors.titre" class="mt-2 text-sm text-red-600">{{ form.errors.titre }}</p>
          </div>

          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <label for="extrait" class="block text-sm font-semibold text-gray-700 mb-2">
              Extrait <span class="text-red-500">*</span>
            </label>
            <textarea
              id="extrait"
              v-model="form.extrait"
              rows="3"
              required
              maxlength="500"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
            />
            <p class="text-xs text-gray-500 mt-2">{{ form.extrait.length }}/500 caractères</p>
            <p v-if="form.errors.extrait" class="mt-2 text-sm text-red-600">{{ form.errors.extrait }}</p>
          </div>

          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Contenu de l'article <span class="text-red-500">*</span>
            </label>
            <TiptapEditor v-model="form.contenu" />
            <p v-if="form.errors.contenu" class="mt-2 text-sm text-red-600">{{ form.errors.contenu }}</p>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Publication</h2>

            <div class="space-y-4">
              <div class="flex items-center">
                <input
                  id="publie"
                  v-model="form.publie"
                  type="checkbox"
                  class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                />
                <label for="publie" class="ml-2 text-sm text-gray-700">
                  Article publié
                </label>
              </div>

              <div>
                <label for="date_publication" class="block text-sm font-semibold text-gray-700 mb-2">
                  Date de publication
                </label>
                <input
                  id="date_publication"
                  v-model="form.date_publication"
                  type="date"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                />
              </div>

              <div>
                <label for="categorie" class="block text-sm font-semibold text-gray-700 mb-2">
                  Catégorie <span class="text-red-500">*</span>
                </label>
                <select
                  id="categorie"
                  v-model="form.categorie"
                  required
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                >
                  <option v-for="categorie in categories" :key="categorie" :value="categorie">
                    {{ categorie }}
                  </option>
                </select>
                <p v-if="form.errors.categorie" class="mt-2 text-sm text-red-600">{{ form.errors.categorie }}</p>
              </div>

              <div>
                <label for="auteur" class="block text-sm font-semibold text-gray-700 mb-2">
                  Auteur <span class="text-red-500">*</span>
                </label>
                <input
                  id="auteur"
                  v-model="form.auteur"
                  type="text"
                  required
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                />
                <p v-if="form.errors.auteur" class="mt-2 text-sm text-red-600">{{ form.errors.auteur }}</p>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <ImageUpload
              v-model="form.image"
              :current-image="actualite.image"
              label="Image de couverture"
              :error="form.errors.image"
            />
          </div>

          <!-- Vidéo -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Vidéo (optionnel)
            </label>

            <!-- Vidéo actuelle -->
            <div v-if="actualite.video" class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
              <p class="text-sm text-blue-800">
                <span class="font-semibold">Vidéo actuelle:</span> {{ actualite.video.split('/').pop() }}
              </p>
              <button
                type="button"
                @click="() => { form.video = 'delete'; actualite.video = null }"
                class="text-sm text-red-600 hover:text-red-700 font-medium mt-2"
              >
                Supprimer la vidéo actuelle
              </button>
            </div>

            <p class="text-xs text-gray-600 mb-4">
              Formats acceptés: MP4, WebM, MOV, AVI, FLV (Max 50MB)
            </p>

            <!-- Input vidéo -->
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-primary-400 transition">
              <input
                type="file"
                accept="video/mp4,video/webm,video/quicktime,video/x-msvideo,.flv"
                @change="(e) => form.video = e.target.files[0]"
                class="hidden"
                id="video-input-edit"
              />
              <label for="video-input-edit" class="cursor-pointer">
                <svg v-if="!form.video" class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p v-if="!form.video" class="text-gray-600">
                  Cliquez pour sélectionner une nouvelle vidéo
                </p>
                <p v-else class="text-green-600 font-semibold">
                  ✓ {{ form.video.name || form.video }}
                </p>
              </label>
            </div>
            <p v-if="form.errors.video" class="mt-2 text-sm text-red-600">{{ form.errors.video }}</p>

            <!-- Bouton pour effacer -->
            <button
              v-if="form.video && form.video !== 'delete'"
              type="button"
              @click="form.video = null"
              class="mt-3 text-sm text-red-600 hover:text-red-700 font-medium"
            >
              Annuler le changement de vidéo
            </button>
          </div>

          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col gap-3">
              <button
                type="submit"
                :disabled="form.processing"
                class="flex items-center justify-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition disabled:opacity-50"
              >
                <Save :size="20" />
                <span v-if="form.processing">Enregistrement...</span>
                <span v-else>Enregistrer les modifications</span>
              </button>
              <Link
                :href="route('admin.actualites.index')"
                class="text-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition"
              >
                Annuler
              </Link>
            </div>
          </div>
        </div>
      </div>
    </form>
  </AdminLayout>
</template>
