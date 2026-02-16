<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import SearchBar from '@/Components/Admin/SearchBar.vue'
import AdvancedPagination from '@/Components/Admin/AdvancedPagination.vue'
import {
  Activity, User, Calendar, Search, Filter,
  Eye
} from 'lucide-vue-next'

const props = defineProps({
  activities: Object,
  users: Array,
  filters: Object,
})

const search = ref(props.filters?.search || '')
const selectedUser = ref(props.filters?.causer_id || '')
const dateDebut = ref(props.filters?.date_debut || '')
const dateFin = ref(props.filters?.date_fin || '')
const perPage = ref(props.filters?.per_page || 7)

// Recherche
let searchTimeout = null
const handleSearch = (value) => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    applyFilters()
  }, 500)
}

/**
 * Gérer le changement du nombre d'éléments par page
 */
const handlePerPageChange = (newPerPage) => {
  perPage.value = newPerPage
  router.get(route('admin.activity-log.index'), {
    search: search.value,
    causer_id: selectedUser.value,
    date_debut: dateDebut.value,
    date_fin: dateFin.value,
    per_page: newPerPage,
  }, { preserveState: true })
}

// Appliquer filtres
const applyFilters = () => {
  router.get(route('admin.activity-log.index'), {
    search: search.value,
    causer_id: selectedUser.value,
    date_debut: dateDebut.value,
    date_fin: dateFin.value,
    per_page: perPage.value,
  }, { preserveState: true })
}

// Format date
const formatDate = (date) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  })
}

// Couleur action
const getActionColor = (description) => {
  if (description.includes('créé')) return 'bg-green-100 text-green-800'
  if (description.includes('modifié')) return 'bg-blue-100 text-blue-800'
  if (description.includes('supprimé')) return 'bg-red-100 text-red-800'
  if (description.includes('Connexion')) return 'bg-purple-100 text-purple-800'
  if (description.includes('Déconnexion')) return 'bg-gray-100 text-gray-800'
  return 'bg-yellow-100 text-yellow-800'
}
</script>

<template>
  <Head title="Journal d'activité - Admin" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Journal d'activité</h1>
      <p class="text-gray-600">Consultez l'historique des actions effectuées sur le système</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Recherche -->
        <div class="lg:col-span-2">
          <SearchBar
            v-model="search"
            placeholder="Rechercher une action..."
            @update:modelValue="handleSearch"
          />
        </div>

        <!-- Utilisateur -->
        <div>
          <select
            v-model="selectedUser"
            @change="applyFilters"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
          >
            <option value="">Tous les utilisateurs</option>
            <option v-for="user in users" :key="user.id" :value="user.id">
              {{ user.name }}
            </option>
          </select>
        </div>

        <!-- Période -->
        <div class="flex gap-2">
          <input
            v-model="dateDebut"
            @change="applyFilters"
            type="date"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm"
            placeholder="Du"
          />
          <input
            v-model="dateFin"
            @change="applyFilters"
            type="date"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm"
            placeholder="Au"
          />
        </div>
      </div>
    </div>

    <!-- Timeline -->
    <div class="space-y-4">
      <div
        v-for="activity in activities.data"
        :key="activity.id"
        class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition"
      >
        <div class="p-6">
          <div class="flex items-start gap-4">
            <!-- Icon & Line -->
            <div class="flex flex-col items-center">
              <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center shrink-0">
                <Activity :size="24" class="text-primary-600" />
              </div>
              <div v-if="activity !== activities.data[activities.data.length - 1]" class="w-0.5 h-full bg-gray-200 mt-4"></div>
            </div>

            <!-- Contenu -->
            <div class="flex-1 min-w-0">
              <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3 flex-wrap">
                  <!-- Utilisateur -->
                  <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                      <User :size="16" class="text-gray-600" />
                    </div>
                    <span class="font-semibold text-gray-900">
                      {{ activity.causer?.name || 'Système' }}
                    </span>
                  </div>

                  <!-- Badge action -->
                  <span :class="['text-xs font-medium px-3 py-1 rounded-full', getActionColor(activity.description)]">
                    {{ activity.description }}
                  </span>
                </div>

                <!-- Date -->
                <div class="flex items-center gap-2 text-sm text-gray-500">
                  <Calendar :size="14" />
                  {{ formatDate(activity.created_at) }}
                </div>
              </div>

              <!-- Propriétés (si existent) -->
              <div v-if="activity.properties && Object.keys(activity.properties).length > 0" class="mt-3 p-3 bg-gray-50 rounded-lg">
                <p class="text-xs font-semibold text-gray-700 mb-2">Détails :</p>
                <pre class="text-xs text-gray-600 overflow-x-auto">{{ JSON.stringify(activity.properties, null, 2) }}</pre>
              </div>

              <!-- Voir détails -->
              <Link
                :href="route('admin.activity-log.show', activity.id)"
                class="inline-flex items-center gap-2 mt-3 text-sm text-primary-600 hover:text-primary-700 font-medium"
              >
                <Eye :size="16" />
                Voir détails complets
              </Link>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty state -->
      <div v-if="activities.data.length === 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <Activity :size="48" class="text-gray-300 mx-auto mb-4" />
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune activité</h3>
        <p class="text-gray-600">Aucune activité ne correspond à vos critères.</p>
      </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <AdvancedPagination
        :links="activities.links"
        :meta="activities.meta"
        :current-per-page="perPage"
        @per-page-change="handlePerPageChange"
      />
    </div>
  </AdminLayout>
</template>
