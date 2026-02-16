<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import SearchBar from '@/Components/Admin/SearchBar.vue'
import AdvancedPagination from '@/Components/Admin/AdvancedPagination.vue'
import ConfirmModal from '@/Components/Admin/ConfirmModal.vue'
import {
  Plus, Edit, Trash2, Eye, CheckCircle, XCircle,
  Stethoscope, Languages, GraduationCap, Briefcase
} from 'lucide-vue-next'

const props = defineProps({
  medecins: Object,
  specialites: Array,
  filters: Object,
})

const search = ref(props.filters?.search || '')
const showDeleteModal = ref(false)
const medecinToDelete = ref(null)
const perPage = ref(props.filters?.per_page || 7)

// Recherche avec debounce
let searchTimeout = null
const handleSearch = (value) => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    router.get(route('admin.medecins.index'),
      { search: value, per_page: perPage.value },
      { preserveState: true, replace: true }
    )
  }, 500)
}

// Confirmation suppression
const confirmDelete = (medecin) => {
  medecinToDelete.value = medecin
  showDeleteModal.value = true
}

const deleteMedecin = () => {
  if (medecinToDelete.value) {
    router.delete(route('admin.medecins.destroy', medecinToDelete.value.id), {
      onSuccess: () => {
        showDeleteModal.value = false
        medecinToDelete.value = null
      }
    })
  }
}

// Filtre par spécialité
const filterBySpecialite = (specialite) => {
  router.get(route('admin.medecins.index'),
    { specialite, per_page: perPage.value },
    { preserveState: true }
  )
}

// Filtre par statut
const handleActifChange = (value) => {
  router.get(route('admin.medecins.index'),
    { actif: value, per_page: perPage.value },
    { preserveState: true }
  )
}

// Changement du nombre d'éléments par page
const handlePerPageChange = (newPerPage) => {
  perPage.value = newPerPage
  router.get(route('admin.medecins.index'), { per_page: newPerPage }, { preserveState: true })
}
</script>

<template>
  <Head title="Médecins - Admin" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Équipe médicale</h1>
          <p class="text-gray-600">Gérez les médecins et leurs informations</p>
        </div>
        <Link
          :href="route('admin.medecins.create')"
          class="flex items-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition"
        >
          <Plus :size="20" />
          Nouveau médecin
        </Link>
      </div>

      <!-- Filters -->
      <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
          <SearchBar
            v-model="search"
            placeholder="Rechercher un médecin..."
            @update:modelValue="handleSearch"
          />
        </div>
        <select
          @change="filterBySpecialite($event.target.value)"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
        >
          <option value="">Toutes les spécialités</option>
          <option v-for="specialite in specialites" :key="specialite" :value="specialite">
            {{ specialite }}
          </option>
        </select>
        <select
          @change="handleActifChange($event.target.value)"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
        >
          <option value="">Tous les statuts</option>
          <option value="1">Actifs</option>
          <option value="0">Inactifs</option>
        </select>
      </div>
    </div>

    <!-- Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
      <div
        v-for="medecin in medecins.data"
        :key="medecin.id"
        class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition"
      >
        <!-- Photo -->
        <div class="h-48 bg-gradient-to-br from-primary-400 to-primary-600 relative overflow-hidden">
          <img
            v-if="medecin.photo"
            :src="medecin.photo"
            :alt="medecin.nom"
            class="w-full h-full object-cover"
          />
          <div v-else class="w-full h-full flex items-center justify-center">
            <Stethoscope :size="64" class="text-white opacity-30" />
          </div>

          <!-- Badge statut -->
          <div class="absolute top-3 right-3">
            <span
              :class="[
                'inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium',
                medecin.actif
                  ? 'bg-green-500 text-white'
                  : 'bg-red-500 text-white'
              ]"
            >
              <CheckCircle v-if="medecin.actif" :size="12" />
              <XCircle v-else :size="12" />
              {{ medecin.actif ? 'Actif' : 'Inactif' }}
            </span>
          </div>
        </div>

        <!-- Info -->
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-1">Dr. {{ medecin.nom }}</h3>
          <div class="flex items-center gap-2 text-primary-600 mb-4">
            <Briefcase :size="16" />
            <p class="text-sm font-semibold">{{ medecin.specialite }}</p>
          </div>

          <div class="space-y-2 mb-4">
            <div v-if="medecin.diplomes" class="flex items-center gap-2 text-sm text-gray-600">
              <GraduationCap :size="16" />
              <p class="line-clamp-1">{{ medecin.diplomes }}</p>
            </div>
            <div v-if="medecin.langues" class="flex items-center gap-2 text-sm text-gray-600">
              <Languages :size="16" />
              <p>{{ medecin.langues }}</p>
            </div>
          </div>

          <!-- Services -->
          <div v-if="medecin.services" class="mb-4">
            <p class="text-xs text-gray-500 mb-2">Services :</p>
            <div class="flex flex-wrap gap-2">
              <span
                v-for="service in medecin.services.slice(0, 2)"
                :key="service.id"
                class="text-xs bg-primary-50 text-primary-700 px-2 py-1 rounded-full"
              >
                {{ service.nom }}
              </span>
              <span
                v-if="medecin.services.length > 2"
                class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full"
              >
                +{{ medecin.services.length - 2 }}
              </span>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex items-center gap-2 pt-4 border-t border-gray-200">
            <Link
              :href="route('admin.medecins.show', medecin.id)"
              class="flex-1 flex items-center justify-center gap-2 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
            >
              <Eye :size="18" />
              <span class="text-sm font-medium">Voir</span>
            </Link>
            <Link
              :href="route('admin.medecins.edit', medecin.id)"
              class="flex-1 flex items-center justify-center gap-2 py-2 text-primary-600 hover:bg-primary-50 rounded-lg transition"
            >
              <Edit :size="18" />
              <span class="text-sm font-medium">Modifier</span>
            </Link>
            <button
              @click="confirmDelete(medecin)"
              class="flex-1 flex items-center justify-center gap-2 py-2 text-red-600 hover:bg-red-50 rounded-lg transition"
            >
              <Trash2 :size="18" />
              <span class="text-sm font-medium">Supprimer</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <AdvancedPagination :links="medecins.links" :meta="medecins.meta" :current-per-page="perPage" @per-page-change="handlePerPageChange" />
    </div>

    <!-- Modal confirmation suppression -->
    <ConfirmModal
      :show="showDeleteModal"
      title="Supprimer ce médecin ?"
      :message="`Êtes-vous sûr de vouloir supprimer Dr. ${medecinToDelete?.nom} ? Cette action est irréversible.`"
      confirm-text="Supprimer"
      type="danger"
      @confirm="deleteMedecin"
      @cancel="showDeleteModal = false"
    />
  </AdminLayout>
</template>
