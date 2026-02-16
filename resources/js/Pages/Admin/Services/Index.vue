<script setup>
import { ref, computed } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import SearchBar from '@/Components/Admin/SearchBar.vue'
import AdvancedPagination from '@/Components/Admin/AdvancedPagination.vue'
import ConfirmModal from '@/Components/Admin/ConfirmModal.vue'
import {
  Plus, Edit, Trash2, Eye, CheckCircle, XCircle,
  Hospital, Users as UsersIcon, Clock, DollarSign
} from 'lucide-vue-next'

const props = defineProps({
  services: {
    type: Object,
    default: () => ({
      data: [],
      meta: { total: 0 },
      links: []
    })
  },
  filters: {
    type: Object,
    default: () => ({})
  },
})

const search = ref(props.filters?.search || '')
const perPage = ref(props.filters?.per_page || 7)
const showDeleteModal = ref(false)
const serviceToDelete = ref(null)

/**
 * Gérer le changement du nombre d'éléments par page
 */
const handlePerPageChange = (newPerPage) => {
  perPage.value = newPerPage
  router.get(route('admin.services.index'),
    { search: search.value, per_page: newPerPage },
    { preserveState: true, replace: true }
  )
}

// Recherche avec debounce
let searchTimeout = null
const handleSearch = (value) => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    router.get(route('admin.services.index'),
      { search: value, per_page: perPage.value },
      { preserveState: true, replace: true }
    )
  }, 500)
}

// Confirmation suppression
const confirmDelete = (service) => {
  serviceToDelete.value = service
  showDeleteModal.value = true
}

const deleteService = () => {
  if (serviceToDelete.value) {
    router.delete(route('admin.services.destroy', serviceToDelete.value.id), {
      onSuccess: () => {
        showDeleteModal.value = false
        serviceToDelete.value = null
      }
    })
  }
}

// Toggle actif
const toggleActive = (service) => {
  router.post(route('admin.services.toggle-active', service.id))
}

// Format nombre
const formatNumber = (num) => {
  return new Intl.NumberFormat('fr-FR').format(num)
}
</script>

<template>
  <Head title="Services - Admin" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Services médicaux</h1>
          <p class="text-gray-600">Gérez les services médicaux de l'hôpital</p>
        </div>
        <Link
          :href="route('admin.services.create')"
          class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition"
        >
          <Plus :size="20" />
          Nouveau service
        </Link>
      </div>

      <!-- Filters -->
      <div class="flex items-center gap-4">
        <div class="flex-1">
          <SearchBar
            v-model="search"
            placeholder="Rechercher un service..."
            @update:modelValue="handleSearch"
          />
        </div>
        <select
          @change="router.get(route('admin.services.index'), { actif: $event.target.value })"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
        >
          <option value="">Tous les statuts</option>
          <option value="1">Actifs</option>
          <option value="0">Inactifs</option>
        </select>
      </div>
    </div>

    <!-- Stats rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-600">Total</p>
            <p class="text-2xl font-bold text-gray-900">{{ services?.meta?.total || 0 }}</p>
          </div>
          <Hospital :size="32" class="text-blue-600" />
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                Service
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                Médecins
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                Tarif consultation
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                RDV
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                Statut
              </th>
              <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="service in services?.data || []" :key="service.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <Hospital :size="20" class="text-blue-600" />
                  </div>
                  <div>
                    <p class="font-semibold text-gray-900">{{ service.nom }}</p>
                    <p class="text-sm text-gray-500">{{ service.slug }}</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                  <UsersIcon :size="16" />
                  {{ service.medecins_count || 0 }} médecin(s)
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-2 text-sm">
                  <DollarSign :size="16" class="text-gray-400" />
                  <span class="font-semibold text-gray-900">{{ formatNumber(service.tarif_consultation) }} FCFA</span>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-sm font-semibold text-gray-900">{{ service.rdv_requests_count || 0 }}</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <button
                  @click="toggleActive(service)"
                  :class="[
                    'inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium transition',
                    service.actif
                      ? 'bg-green-100 text-green-800 hover:bg-green-200'
                      : 'bg-red-100 text-red-800 hover:bg-red-200'
                  ]"
                >
                  <CheckCircle v-if="service.actif" :size="14" />
                  <XCircle v-else :size="14" />
                  {{ service.actif ? 'Actif' : 'Inactif' }}
                </button>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex items-center justify-end gap-2">
                  <Link
                    :href="route('admin.services.show', service.id)"
                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                    title="Voir"
                  >
                    <Eye :size="18" />
                  </Link>
                  <Link
                    :href="route('admin.services.edit', service.id)"
                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                    title="Modifier"
                  >
                    <Edit :size="18" />
                  </Link>
                  <button
                    @click="confirmDelete(service)"
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
        <AdvancedPagination
          :links="services?.links"
          :meta="services?.meta"
          :current-per-page="perPage"
          @per-page-change="handlePerPageChange"
        />
      </div>
    </div>

    <!-- Modal confirmation suppression -->
    <ConfirmModal
      :show="showDeleteModal"
      :title="`Supprimer ce service ?`"
      :message="`Êtes-vous sûr de vouloir supprimer le service '${serviceToDelete?.nom}' ? Cette action est irréversible.`"
      confirm-text="Supprimer"
      type="danger"
      @confirm="deleteService"
      @cancel="showDeleteModal = false"
    />
  </AdminLayout>
</template>
