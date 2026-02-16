<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import SearchBar from '@/Components/Admin/SearchBar.vue'
import AdvancedPagination from '@/Components/Admin/AdvancedPagination.vue'
import {
  Calendar, Clock, CheckCircle, XCircle, AlertCircle,
  Phone, User, Hospital, Eye
} from 'lucide-vue-next'

const props = defineProps({
  rdvRequests: Object,
  services: Array,
  stats: Object,
  filters: Object,
})

const search = ref(props.filters?.search || '')
const selectedStatus = ref(props.filters?.statut || '')
const selectedService = ref(props.filters?.service_id || '')
const perPage = ref(props.filters?.per_page || 7)

// Recherche
let searchTimeout = null
const handleSearch = (value) => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    router.get(route('admin.rdv-requests.index'),
      { search: value, statut: selectedStatus.value, service_id: selectedService.value, per_page: perPage.value },
      { preserveState: true, replace: true }
    )
  }, 500)
}

// Filtres
const applyFilters = () => {
  router.get(route('admin.rdv-requests.index'), {
    search: search.value,
    statut: selectedStatus.value,
    service_id: selectedService.value,
    per_page: perPage.value,
  }, { preserveState: true })
}

// Changement du nombre d'éléments par page
const handlePerPageChange = (newPerPage) => {
  perPage.value = newPerPage
  router.get(route('admin.rdv-requests.index'), {
    search: search.value,
    statut: selectedStatus.value,
    service_id: selectedService.value,
    per_page: newPerPage,
  }, { preserveState: true })
}

// Format date
const formatDate = (date) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Couleur statut
const getStatusColor = (statut) => {
  const colors = {
    'en_attente': 'bg-yellow-100 text-yellow-800 border-yellow-300',
    'confirme': 'bg-green-100 text-green-800 border-green-300',
    'annule': 'bg-red-100 text-red-800 border-red-300',
  }
  return colors[statut] || 'bg-gray-100 text-gray-800'
}

const getStatusIcon = (statut) => {
  return statut === 'confirme' ? CheckCircle : statut === 'annule' ? XCircle : AlertCircle
}

const getStatusLabel = (statut) => {
  const labels = {
    'en_attente': 'En attente',
    'confirme': 'Confirmé',
    'annule': 'Annulé',
  }
  return labels[statut] || statut
}
</script>

<template>
  <Head title="Rendez-vous - Admin" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestion des rendez-vous</h1>
      <p class="text-gray-600">Consultez et gérez les demandes de rendez-vous</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-600">Total</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.total }}</p>
          </div>
          <Calendar :size="32" class="text-gray-400" />
        </div>
      </div>
      <div class="bg-yellow-50 rounded-lg border border-yellow-200 p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-yellow-700">En attente</p>
            <p class="text-2xl font-bold text-yellow-900">{{ stats.en_attente }}</p>
          </div>
          <AlertCircle :size="32" class="text-yellow-600" />
        </div>
      </div>
      <div class="bg-green-50 rounded-lg border border-green-200 p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-green-700">Confirmés</p>
            <p class="text-2xl font-bold text-green-900">{{ stats.confirmes }}</p>
          </div>
          <CheckCircle :size="32" class="text-green-600" />
        </div>
      </div>
      <div class="bg-red-50 rounded-lg border border-red-200 p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-red-700">Annulés</p>
            <p class="text-2xl font-bold text-red-900">{{ stats.annules }}</p>
          </div>
          <XCircle :size="32" class="text-red-600" />
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
      <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
          <SearchBar
            v-model="search"
            placeholder="Rechercher par nom, téléphone..."
            @update:modelValue="handleSearch"
          />
        </div>
        <select
          v-model="selectedService"
          @change="applyFilters"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
        >
          <option value="">Tous les services</option>
          <option v-for="service in services" :key="service.id" :value="service.id">
            {{ service.nom }}
          </option>
        </select>
        <select
          v-model="selectedStatus"
          @change="applyFilters"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
        >
          <option value="">Tous les statuts</option>
          <option value="en_attente">En attente</option>
          <option value="confirme">Confirmé</option>
          <option value="annule">Annulé</option>
        </select>
      </div>
    </div>

    <!-- Liste RDV -->
    <div class="space-y-4">
      <div
        v-for="rdv in rdvRequests.data"
        :key="rdv.id"
        class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition"
      >
        <div class="p-6">
          <div class="flex items-start justify-between mb-4">
            <div class="flex items-start gap-4 flex-1">
              <!-- Avatar -->
              <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                <User :size="24" class="text-primary-600" />
              </div>

              <!-- Info patient -->
              <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                  <h3 class="text-lg font-bold text-gray-900">{{ rdv.nom_patient }}</h3>
                  <span :class="['inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium border', getStatusColor(rdv.statut)]">
                    <component :is="getStatusIcon(rdv.statut)" :size="14" />
                    {{ getStatusLabel(rdv.statut) }}
                  </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-600">
                  <div class="flex items-center gap-2">
                    <Phone :size="16" />
                    <span>{{ rdv.telephone }}</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <Hospital :size="16" />
                    <span>{{ rdv.service?.nom }}</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <User :size="16" />
                    <span>{{ rdv.age }} ans</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <Clock :size="16" />
                    <span>{{ formatDate(rdv.created_at) }}</span>
                  </div>
                </div>

                <!-- Motif -->
                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                  <p class="text-sm text-gray-700">
                    <span class="font-semibold">Motif :</span> {{ rdv.motif }}
                  </p>
                  <div v-if="rdv.confirmation_whatsapp" class="flex items-center gap-2 mt-2 text-xs text-green-600">
                    <CheckCircle :size="14" />
                    <span>Confirmation WhatsApp demandée</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Actions -->
            <Link
              :href="route('admin.rdv-requests.show', rdv.id)"
              class="flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition"
            >
              <Eye :size="18" />
              <span class="hidden md:inline">Voir détails</span>
            </Link>
          </div>
        </div>
      </div>

      <!-- Empty state -->
      <div v-if="rdvRequests.data.length === 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <Calendar :size="48" class="text-gray-300 mx-auto mb-4" />
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun rendez-vous</h3>
        <p class="text-gray-600">Aucun rendez-vous ne correspond à vos critères de recherche.</p>
      </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <AdvancedPagination :links="rdvRequests.links" :meta="rdvRequests.meta" :current-per-page="perPage" @per-page-change="handlePerPageChange" />
    </div>
  </AdminLayout>
</template>
