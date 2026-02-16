<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ImageUpload from '@/Components/Admin/ImageUpload.vue'
import TiptapEditor from '@/Components/Admin/TiptapEditor.vue'
import { ArrowLeft, Save } from 'lucide-vue-next'

const props = defineProps({
  categories: Array,
})

const form = useForm({
  titre: '',
  extrait: '',
  contenu: '',
  categorie: '',
  auteur: 'Équipe HRA',
  image: null,
  publie: false,
  date_publication: new Date().toISOString().split('T')[0],
})

const submit = () => {
  form.post(route('admin.actualites.store'), {
    forceFormData: true,
  })
}
</script>

<template>
  <Head title="Nouvel article - Admin" />

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
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Nouvel article</h1>
      <p class="text-gray-600">Créez un nouvel article pour le blog santé</p>
    </div>

    <!-- Form -->
    <form @submit.prevent="submit" class="max-w-5xl">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne principale (2/3) -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Titre -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <label for="titre" class="block text-sm font-semibold text-gray-700 mb-2">
              Titre de l'article <span class="text-red-500">*</span>
            </label>
            <input
              id="titre"
              v-model="form.titre"
              type="text"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-lg font-semibold"
              placeholder="Ex: 10 Aliments pour Renforcer votre Système Immunitaire"
            />
            <p v-if="form.errors.titre" class="mt-2 text-sm text-red-600">{{ form.errors.titre }}</p>
          </div>

          <!-- Extrait -->
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
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
              placeholder="Résumé de l'article (max 500 caractères)"
            />
            <div class="flex justify-between items-center mt-2">
              <p v-if="form.errors.extrait" class="text-sm text-red-600">{{ form.errors.extrait }}</p>
              <p class="text-xs text-gray-500">{{ form.extrait.length }}/500 caractères</p>
            </div>
          </div>

          <!-- Contenu -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Contenu de l'article <span class="text-red-500">*</span>
            </label>
            <TiptapEditor v-model="form.contenu" />
            <p v-if="form.errors.contenu" class="mt-2 text-sm text-red-600">{{ form.errors.contenu }}</p>
          </div>
        </div>

        <!-- Sidebar (1/3) -->
        <div class="lg:col-span-1 space-y-6">
          <!-- Publication -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Publication</h2>

            <div class="space-y-4">
              <!-- Statut -->
              <div class="flex items-center">
                <input
                  id="publie"
                  v-model="form.publie"
                  type="checkbox"
                  class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                />
                <label for="publie" class="ml-2 text-sm text-gray-700">
                  Publier immédiatement
                </label>
              </div>

              <!-- Date publication -->
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

              <!-- Catégorie -->
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
                  <option value="">Sélectionnez...</option>
                  <option v-for="categorie in categories" :key="categorie" :value="categorie">
                    {{ categorie }}
                  </option>
                </select>
                <p v-if="form.errors.categorie" class="mt-2 text-sm text-red-600">{{ form.errors.categorie }}</p>
              </div>

              <!-- Auteur -->
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

          <!-- Image couverture -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <ImageUpload
              v-model="form.image"
              label="Image de couverture"
              :error="form.errors.image"
            />
          </div>

          <!-- Actions -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col gap-3">
              <button
                type="submit"
                :disabled="form.processing"
                class="flex items-center justify-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition disabled:opacity-50"
              >
                <Save :size="20" />
                <span v-if="form.processing">Enregistrement...</span>
                <span v-else>{{ form.publie ? 'Publier' : 'Enregistrer brouillon' }}</span>
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
