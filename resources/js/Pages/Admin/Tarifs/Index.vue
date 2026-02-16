<script setup>
import { ref } from 'vue'
import { Head, useForm, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ConfirmModal from '@/Components/Admin/ConfirmModal.vue'
import {
  DollarSign, Plus, Edit, Trash2, Save, X,
  Filter, Hospital
} from 'lucide-vue-next'

const props = defineProps({
  tarifs: Array,
  services: Array,
  filters: Object,
})

const selectedService = ref(props.filters?.service_id || '')
const editingTarif = ref(null)
const showDeleteModal = ref(false)
const tarifToDelete = ref(null)
const showCreateForm = ref(false)

// Form création
const createForm = useForm({
  service_id: '',
  designation: '',
  montant: 0,
  type_patient: 'normal',
  details: '',
})

// Form édition
const editForm = useForm({
  id: null,
  designation: '',
  montant: 0,
  type_patient: 'normal',
  details: '',
})

// Filtrer par service
const filterByService = () => {
  router.get(route('admin.tarifs.index'),
    { service_id: selectedService.value },
    { preserveState: true }
  )
}

// Créer tarif
const createTarif = () => {
  createForm.post(route('admin.tarifs.store'), {
    onSuccess: () => {
      createForm.reset()
      showCreateForm.value = false
    }
  })
}

// Éditer tarif
const startEdit = (tarif) => {
  editingTarif.value = tarif.id
  editForm.id = tarif.id
  editForm.designation = tarif.designation
  editForm.montant = tarif.montant
  editForm.type_patient = tarif.type_patient
  editForm.details = tarif.details || ''
}

const updateTarif = () => {
  editForm.patch(route('admin.tarifs.update', editForm.id), {
    onSuccess: () => {
      editingTarif.value = null
      editForm.reset()
    }
  })
}

const cancelEdit = () => {
  editingTarif.value = null
  editForm.reset()
}

// Supprimer tarif
const confirmDelete = (tarif) => {
  tarifToDelete.value = tarif
  showDeleteModal.value = true
}

const deleteTarif = () => {
  if (tarifToDelete.value) {
    router.delete(route('admin.tarifs.destroy', tarifToDelete.value.id), {
      onSuccess: () => {
        showDeleteModal.value = false
        tarifToDelete.value = null
      }
    })
  }
}

// Format montant
const formatMontant = (montant) => {
  return new Intl.NumberFormat('fr-FR').format(montant)
}

// Couleur type patient
const getTypeColor = (type) => {
  const colors = {
    'normal': 'bg-blue-100 text-blue-800',
    'etudiant': 'bg-green-100 text-green-800',
    'urgence': 'bg-red-100 text-red-800',
  }
  return colors[type] || 'bg-gray-100 text-gray-800'
}

const getTypeLabel = (type) => {
  const labels = {
    'normal': 'Normal',
    'etudiant': 'Étudiant',
    'urgence': 'Urgence',
  }
  return labels[type] || type
}
</script>

<template>
  <Head title="Tarifs - Admin" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestion des tarifs</h1>
          <p class="text-gray-600">Gérez les tarifs par service médical</p>
        </div>
        <button
          @click="showCreateForm = !showCreateForm"
          class="flex items-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition"
        >
          <Plus :size="20" />
          Nouveau tarif
        </button>
      </div>

      <!-- Filtre par service -->
      <div class="flex items-center gap-4">
        <Filter :size="20" class="text-gray-500" />
        <select
          v-model="selectedService"
          @change="filterByService"
          class="flex-1 max-w-md px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
        >
          <option value="">Tous les services</option>
          <option v-for="service in services" :key="service.id" :value="service.id">
            {{ service.nom }}
          </option>
        </select>
      </div>
    </div>

    <!-- Formulaire création -->
    <div v-if="showCreateForm" class="bg-white rounded-xl shadow-sm border-2 border-primary-300 p-6 mb-6">
      <h2 class="text-lg font-bold text-gray-900 mb-4">Nouveau tarif</h2>
      <form @submit.prevent="createTarif" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Service -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Service <span class="text-red-500">*</span>
            </label>
            <select
              v-model="createForm.service_id"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
            >
              <option value="">Sélectionnez un service</option>
              <option v-for="service in services" :key="service.id" :value="service.id">
                {{ service.nom }}
              </option>
            </select>
            <p v-if="createForm.errors.service_id" class="mt-1 text-sm text-red-600">{{ createForm.errors.service_id }}</p>
          </div>

          <!-- Type patient -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Type de patient <span class="text-red-500">*</span>
            </label>
            <select
              v-model="createForm.type_patient"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
            >
              <option value="normal">Normal</option>
              <option value="etudiant">Étudiant</option>
              <option value="urgence">Urgence</option>
            </select>
          </div>

          <!-- Désignation -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Désignation <span class="text-red-500">*</span>
            </label>
            <input
              v-model="createForm.designation"
              type="text"
              required
              placeholder="Ex: Consultation générale"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
            />
            <p v-if="createForm.errors.designation" class="mt-1 text-sm text-red-600">{{ createForm.errors.designation }}</p>
          </div>

          <!-- Montant -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Montant (FCFA) <span class="text-red-500">*</span>
            </label>
            <input
              v-model.number="createForm.montant"
              type="number"
              min="0"
              step="500"
              required
              placeholder="5000"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
            />
            <p v-if="createForm.errors.montant" class="mt-1 text-sm text-red-600">{{ createForm.errors.montant }}</p>
          </div>
        </div>

        <!-- Détails -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Détails (optionnel)
          </label>
          <textarea
            v-model="createForm.details"
            rows="2"
            placeholder="Informations complémentaires..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
          />
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
          <button
            type="button"
            @click="showCreateForm = false"
            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition"
          >
            Annuler
          </button>
          <button
            type="submit"
            :disabled="createForm.processing"
            class="flex items-center gap-2 bg-primary-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-primary-700 transition disabled:opacity-50"
          >
            <Save :size="20" />
            Enregistrer
          </button>
        </div>
      </form>
    </div>

    <!-- Liste tarifs par service -->
    <div v-if="tarifs.length === 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
      <DollarSign :size="48" class="text-gray-300 mx-auto mb-4" />
      <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun tarif</h3>
      <p class="text-gray-600">Commencez par ajouter des tarifs pour vos services.</p>
    </div>

    <div v-else class="space-y-6">
      <!-- Grouper par service -->
      <div
        v-for="(tarifsByService, serviceId) in tarifs.reduce((acc, t) => {
          if (!acc[t.service_id]) acc[t.service_id] = []
          acc[t.service_id].push(t)
          return acc
        }, {})"
        :key="serviceId"
        class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
      >
        <!-- Header service -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
          <div class="flex items-center gap-3">
            <Hospital :size="24" class="text-primary-600" />
            <h2 class="text-lg font-bold text-gray-900">
              {{ tarifsByService[0].service?.nom }}
            </h2>
            <span class="text-sm text-gray-500">
              ({{ tarifsByService.length }} tarif{{ tarifsByService.length > 1 ? 's' : '' }})
            </span>
          </div>
        </div>

        <!-- Table tarifs -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                  Désignation
                </th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                  Type
                </th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                  Montant
                </th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                  Détails
                </th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="tarif in tarifsByService" :key="tarif.id" class="hover:bg-gray-50">
                <template v-if="editingTarif === tarif.id">
                  <!-- Mode édition -->
                  <td class="px-6 py-4">
                    <input
                      v-model="editForm.designation"
                      type="text"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm"
                    />
                  </td>
                  <td class="px-6 py-4">
                    <select
                      v-model="editForm.type_patient"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm"
                    >
                      <option value="normal">Normal</option>
                      <option value="etudiant">Étudiant</option>
                      <option value="urgence">Urgence</option>
                    </select>
                  </td>
                  <td class="px-6 py-4">
                    <input
                      v-model.number="editForm.montant"
                      type="number"
                      min="0"
                      step="500"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm"
                    />
                  </td>
                  <td class="px-6 py-4">
                    <input
                      v-model="editForm.details"
                      type="text"
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm"
                    />
                  </td>
                  <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                      <button
                        @click="updateTarif"
                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                        title="Enregistrer"
                      >
                        <Save :size="18" />
                      </button>
                      <button
                        @click="cancelEdit"
                        class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition"
                        title="Annuler"
                      >
                        <X :size="18" />
                      </button>
                    </div>
                  </td>
                </template>
                <template v-else>
                  <!-- Mode lecture -->
                  <td class="px-6 py-4">
                    <p class="font-semibold text-gray-900">{{ tarif.designation }}</p>
                  </td>
                  <td class="px-6 py-4">
                    <span :class="['text-xs font-medium px-3 py-1 rounded-full', getTypeColor(tarif.type_patient)]">
                      {{ getTypeLabel(tarif.type_patient) }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <p class="font-bold text-primary-600">{{ formatMontant(tarif.montant) }} FCFA</p>
                  </td>
                  <td class="px-6 py-4">
                    <p class="text-sm text-gray-600">{{ tarif.details || '-' }}</p>
                  </td>
                  <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                      <button
                        @click="startEdit(tarif)"
                        class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition"
                        title="Modifier"
                      >
                        <Edit :size="18" />
                      </button>
                      <button
                        @click="confirmDelete(tarif)"
                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                        title="Supprimer"
                      >
                        <Trash2 :size="18" />
                      </button>
                    </div>
                  </td>
                </template>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal suppression -->
    <ConfirmModal
      :show="showDeleteModal"
      title="Supprimer ce tarif ?"
      :message="`Êtes-vous sûr de vouloir supprimer le tarif '${tarifToDelete?.designation}' ?`"
      confirm-text="Supprimer"
      type="danger"
      @confirm="deleteTarif"
      @cancel="showDeleteModal = false"
    />
  </AdminLayout>
</template>
