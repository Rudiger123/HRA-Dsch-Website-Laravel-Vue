<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import SearchBar from '@/Components/Admin/SearchBar.vue'
import Pagination from '@/Components/Admin/Pagination.vue'
import ConfirmModal from '@/Components/Admin/ConfirmModal.vue'
import {
  Plus, Edit, Trash2, Eye, CheckCircle, XCircle,
  Newspaper, Calendar, User, EyeIcon
} from 'lucide-vue-next'

const props = defineProps({
  actualites: Object,
  categories: Array,
  filters: Object,
})

const search = ref(props.filters?.search || '')
const showDeleteModal = ref(false)
const actualiteToDelete = ref(null)

// Recherche
let searchTimeout = null
const handleSearch = (value) => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    router.get(route('admin.actualites.index'),
      { search: value },
      { preserveState: true, replace: true }
    )
  }, 500)
}

// Suppression
const confirmDelete = (actualite) => {
  actualiteToDelete.value = actualite
  showDeleteModal.value = true
}

const deleteActualite = () => {
  if (actualiteToDelete.value) {
    router.delete(route('admin.actualites.destroy', actualiteToDelete.value.id), {
      onSuccess: () => {
        showDeleteModal.value = false
        actualiteToDelete.value = null
      }
    })
  }
}

// Toggle publié
const togglePublish = (actualite) => {
  router.post(route('admin.actualites.toggle-publish', actualite.id))
}

// Format date
const formatDate = (date) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
}

// Couleur catégorie
const getCategoryColor = (categorie) => {
  const colors = {
    'Événements': 'bg-red-100 text-red-800',
    'Nutrition': 'bg-green-100 text-green-800',
    'Prévention': 'bg-purple-100 text-purple-800',
    'Sport & Santé': 'bg-orange-100 text-orange-800',
    'Maternité': 'bg-pink-100 text-pink-800',
    'Santé Mentale': 'bg-indigo-100 text-indigo-800',
  }
  return colors[categorie] || 'bg-gray-100 text-gray-800'
}
</script>

<template>
  <Head title="Actualités - Admin" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Actualités & Blog</h1>
          <p class="text-gray-600">Gérez les articles du blog santé</p>
        </div>
        <Link
          :href="route('admin.actualites.create')"
          class="flex items-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition"
        >
          <Plus :size="20" />
          Nouvel article
        </Link>
      </div>

      <!-- Filters -->
      <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
          <SearchBar
            v-model="search"
            placeholder="Rechercher un article..."
            @update:modelValue="handleSearch"
          />
        </div>
        <select
          @change="router.get(route('admin.actualites.index'), { categorie: $event.target.value })"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
        >
          <option value="">Toutes les catégories</option>
          <option v-for="categorie in categories" :key="categorie" :value="categorie">
            {{ categorie }}
          </option>
        </select>
        <select
          @change="router.get(route('admin.actualites.index'), { publie: $event.target.value })"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
        >
          <option value="">Tous les statuts</option>
          <option value="1">Publiés</option>
          <option value="0">Brouillons</option>
        </select>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                Article
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                Catégorie
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                Auteur
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                Vues
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                Statut
              </th>
              <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="actualite in actualites.data" :key="actualite.id" class="hover:bg-gray-50">
              <td class="px-6 py-4">
                <div class="flex items-start gap-3">
                  <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                    <img
                      v-if="actualite.image"
                      :src="actualite.image"
                      :alt="actualite.titre"
                      class="w-full h-full object-cover"
                    />
                    <div v-else class="w-full h-full flex items-center justify-center">
                      <Newspaper :size="24" class="text-gray-400" />
                    </div>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900 line-clamp-1">{{ actualite.titre }}</p>
                    <p class="text-sm text-gray-500 line-clamp-1 mt-1">{{ actualite.extrait }}</p>
                    <div class="flex items-center gap-2 mt-1 text-xs text-gray-500">
                      <Calendar :size="14" />
                      {{ formatDate(actualite.date_publication) }}
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="['text-xs font-medium px-3 py-1 rounded-full', getCategoryColor(actualite.categorie)]">
                  {{ actualite.categorie }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                  <User :size="16" />
                  {{ actualite.auteur }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                  <EyeIcon :size="16" />
                  {{ actualite.vues }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <button
                  @click="togglePublish(actualite)"
                  :class="[
                    'inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium transition',
                    actualite.publie
                      ? 'bg-green-100 text-green-800 hover:bg-green-200'
                      : 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200'
                  ]"
                >
                  <CheckCircle v-if="actualite.publie" :size="14" />
                  <XCircle v-else :size="14" />
                  {{ actualite.publie ? 'Publié' : 'Brouillon' }}
                </button>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right">
                <div class="flex items-center justify-end gap-2">
                  <a
                    :href="`/actualites/${actualite.slug}`"
                    target="_blank"
                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                    title="Voir sur le site"
                  >
                    <Eye :size="18" />
                  </a>
                  <Link
                    :href="route('admin.actualites.edit', actualite.id)"
                    class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition"
                    title="Modifier"
                  >
                    <Edit :size="18" />
                  </Link>
                  <button
                    @click="confirmDelete(actualite)"
                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                    title="Supprimer"
                  >
                    <Trash2 :size="18" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <Pagination :links="actualites.links" :meta="actualites.meta" />
      </div>
    </div>

    <!-- Modal suppression -->
    <ConfirmModal
      :show="showDeleteModal"
      title="Supprimer cet article ?"
      :message="`Êtes-vous sûr de vouloir supprimer '${actualiteToDelete?.titre}' ? Cette action est irréversible.`"
      confirm-text="Supprimer"
      type="danger"
      @confirm="deleteActualite"
      @cancel="showDeleteModal = false"
    />
  </AdminLayout>
</template>
