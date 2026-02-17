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
    <!-- Grid Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
  <div
    v-for="medecin in medecins.data"
    :key="medecin.id"
    class="group bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-xl hover:border-primary-300 transition-all duration-300"
  >
    <!-- Header avec photo circulaire flottante -->
    <div class="relative px-6 pt-8 pb-4 bg-gradient-to-br from-primary-50 to-white">
      <!-- Actions rapides - TOUJOURS VISIBLES sur mobile, hover sur desktop -->
      <div class="absolute top-4 right-4 flex gap-1 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-200">
        <Link
          :href="route('admin.medecins.edit', medecin.id)"
          class="p-2 bg-white rounded-lg shadow-sm text-primary-600 hover:bg-primary-600 hover:text-white transition"
        >
          <Edit :size="14" />
        </Link>
        <button
          @click="confirmDelete(medecin)"
          class="p-2 bg-white rounded-lg shadow-sm text-red-600 hover:bg-red-600 hover:text-white transition"
        >
          <Trash2 :size="14" />
        </button>
      </div>

      <!-- Photo et statut -->
      <div class="flex flex-col items-center">
        <div class="relative">
          <div class="w-20 h-20 rounded-full overflow-hidden ring-4 ring-white shadow-lg bg-primary-100">
            <img
              v-if="medecin.photo"
              :src="medecin.photo"
              :alt="medecin.nom"
              class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full flex items-center justify-center">
              <Stethoscope :size="32" class="text-primary-400" />
            </div>
          </div>
          <!-- Indicateur statut -->
          <div
            :class="[
              'absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 border-white flex items-center justify-center',
              medecin.actif ? 'bg-green-500' : 'bg-red-500'
            ]"
          >
            <CheckCircle v-if="medecin.actif" :size="10" class="text-white" />
            <XCircle v-else :size="10" class="text-white" />
          </div>
        </div>
      </div>
    </div>

    <!-- Corps -->
    <div class="px-6 pb-6">
      <!-- Identité -->
      <div class="text-center mb-4">
        <h3 class="text-lg font-bold text-gray-900 mb-1">Dr. {{ medecin.nom }}</h3>
        <div class="inline-flex items-center gap-1.5 text-primary-700 text-sm font-medium">
          <Briefcase :size="14" />
          <span>{{ medecin.specialite }}</span>
        </div>
      </div>

      <!-- Métadonnées -->
      <div class="space-y-3 mb-4">
        <!-- Diplômes -->
        <div v-if="medecin.diplomes" class="flex items-start gap-3 p-3 rounded-xl bg-gray-50/50 border border-gray-100">
          <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center shrink-0">
            <GraduationCap :size="16" class="text-primary-600" />
          </div>
          <div class="min-w-0">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-medium mb-0.5">Diplômes</p>
            <p class="text-sm text-gray-700 line-clamp-2 leading-relaxed">{{ medecin.diplomes }}</p>
          </div>
        </div>

        <!-- Langues -->
        <div v-if="medecin.langues" class="flex items-start gap-3 p-3 rounded-xl bg-gray-50/50 border border-gray-100">
          <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
            <Languages :size="16" class="text-blue-600" />
          </div>
          <div class="min-w-0">
            <p class="text-xs text-gray-500 uppercase tracking-wider font-medium mb-0.5">Langues</p>
            <p class="text-sm text-gray-700">{{ medecin.langues }}</p>
          </div>
        </div>
      </div>

      <!-- Services -->
      <div v-if="medecin.services && medecin.services.length" class="mb-5">
        <p class="text-xs text-gray-400 uppercase tracking-wider font-medium mb-2">Services associés</p>
        <div class="flex flex-wrap gap-1.5">
          <span
            v-for="(service, idx) in medecin.services.slice(0, 4)"
            :key="service.id"
            :class="[
              'text-xs px-2.5 py-1 rounded-md font-medium',
              idx === 0 ? 'bg-primary-100 text-primary-700' :
              idx === 1 ? 'bg-blue-50 text-blue-700' :
              idx === 2 ? 'bg-purple-50 text-purple-700' :
              'bg-gray-100 text-gray-700'
            ]"
          >
            {{ service.nom }}
          </span>
          <span
            v-if="medecin.services.length > 4"
            class="text-xs px-2.5 py-1 rounded-md bg-gray-100 text-gray-500 font-medium"
          >
            +{{ medecin.services.length - 4 }}
          </span>
        </div>
      </div>

      <!-- Actions mobile (visible uniquement sur petit écran) -->
      <div class="flex gap-2 md:hidden mb-4">
        <Link
          :href="route('admin.medecins.edit', medecin.id)"
          class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-primary-50 text-primary-700 rounded-xl font-medium"
        >
          <Edit :size="16" />
          <span class="text-sm">Modifier</span>
        </Link>
        <button
          @click="confirmDelete(medecin)"
          class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-red-50 text-red-700 rounded-xl font-medium"
        >
          <Trash2 :size="16" />
          <span class="text-sm">Supprimer</span>
        </button>
      </div>

      <!-- Action principale -->
      <Link
        :href="route('admin.medecins.show', medecin.id)"
        class="flex items-center justify-center gap-2 w-full py-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition shadow-sm hover:shadow-md"
      >
        <Eye :size="16" />
        <span class="text-sm font-medium">Voir le profil</span>
      </Link>
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
