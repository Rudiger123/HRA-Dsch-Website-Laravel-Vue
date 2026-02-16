<script setup>
import { ref } from 'vue'
import { Head, useForm, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ConfirmModal from '@/Components/Admin/ConfirmModal.vue'
import {
  Clock, Plus, Edit, Trash2, Save, X,
  Filter, Hospital, Calendar
} from 'lucide-vue-next'

const props = defineProps({
  horaires: Array,
  services: Array,
  filters: Object,
})

const selectedService = ref(props.filters?.service_id || '')
const editingHoraire = ref(null)
const showDeleteModal = ref(false)
const horaireToDelete = ref(null)
const showCreateForm = ref(false)

const joursDisponibles = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']

// Form création
const createForm = useForm({
  service_id: '',
  jour_semaine: '',
  ouverture: '08:00',
  fermeture: '17:00',
  note: '',
})

// Form édition
const editForm = useForm({
  id: null,
  ouverture: '',
  fermeture: '',
  note: '',
})

// Filtrer par service
const filterByService = () => {
  router.get(route('admin.horaires.index'),
    { service_id: selectedService.value },
    { preserveState: true }
  )
}

// Créer horaire
const createHoraire = () => {
  createForm.post(route('admin.horaires.store'), {
    onSuccess: () => {
      createForm.reset()
      showCreateForm.value = false
    }
  })
}

// Éditer horaire
const startEdit = (horaire) => {
  editingHoraire.value = horaire.id
  editForm.id = horaire.id
  editForm.ouverture = horaire.ouverture
  editForm.fermeture = horaire.fermeture
  editForm.note = horaire.note || ''
}

const updateHoraire = () => {
  editForm.patch(route('admin.horaires.update', editForm.id), {
    onSuccess: () => {
      editingHoraire.value = null
      editForm.reset()
    }
  })
}

const cancelEdit = () => {
  editingHoraire.value = null
  editForm.reset()
}

// Supprimer horaire
const confirmDelete = (horaire) => {
  horaireToDelete.value = horaire
  showDeleteModal.value = true
}

const deleteHoraire = () => {
  if (horaireToDelete.value) {
    router.delete(route('admin.horaires.destroy', horaireToDelete.value.id), {
      onSuccess: () => {
        showDeleteModal.value = false
        horaireToDelete.value = null
      }
    })
  }
}

// Couleur jour
const getJourColor = (jour) => {
  const colors = {
    'Lundi': 'bg-blue-100 text-blue-800',
    'Mardi': 'bg-green-100 text-green-800',
    'Mercredi': 'bg-yellow-100 text-yellow-800',
    'Jeudi': 'bg-purple-100 text-purple-800',
    'Vendredi': 'bg-pink-100 text-pink-800',
    'Samedi': 'bg-orange-100 text-orange-800',
    'Dimanche': 'bg-red-100 text-red-800',
  }
  return colors[jour] || 'bg-gray-100 text-gray-800'
}
</script>

<template>
  <Head title="Horaires - Admin" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestion des horaires</h1>
          <p class="text-gray-600">Gérez les horaires d'ouverture par service</p>
        </div>
        <button
          @click="showCreateForm = !showCreateForm"
          class="flex items-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition"
        >
          <Plus :size="20" />
          Nouvel horaire
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
      <h2 class="text-lg font-bold text-gray-900 mb-4">Nouvel horaire</h2>
      <form @submit.prevent="createHoraire" class="space-y-4">
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

          <!-- Jour -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Jour de la semaine <span class="text-red-500">*</span>
            </label>
            <select
              v-model="createForm.jour_semaine"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
            >
              <option value="">Sélectionnez un jour</option>
              <option v-for="jour in joursDisponibles" :key="jour" :value="jour">
                {{ jour }}
              </option>
            </select>
            <p v-if="createForm.errors.jour_semaine" class="mt-1 text-sm text-red-600">{{ createForm.errors.jour_semaine }}</p>
          </div>

          <!-- Ouverture -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Heure d'ouverture <span class="text-red-500">*</span>
            </label>
            <input
              v-model="createForm.ouverture"
              type="time"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
            />
            <p v-if="createForm.errors.ouverture" class="mt-1 text-sm text-red-600">{{ createForm.errors.ouverture }}</p>
          </div>

          <!-- Fermeture -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              Heure de fermeture <span class="text-red-500">*</span>
            </label>
            <input
              v-model="createForm.fermeture"
              type="time"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
            />
            <p v-if="createForm.errors.fermeture" class="mt-1 text-sm text-red-600">{{ createForm.errors.fermeture }}</p>
          </div>
        </div>

        <!-- Note -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Note (optionnel)
          </label>
          <input
            v-model="createForm.note"
            type="text"
            placeholder="Ex: Fermé pour déjeuner de 12h à 14h"
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

    <!-- Liste horaires -->
    <div v-if="horaires.length === 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
      <Clock :size="48" class="text-gray-300 mx-auto mb-4" />
      <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun horaire</h3>
      <p class="text-gray-600">Commencez par ajouter des horaires pour vos services.</p>
    </div>

    <div v-else class="space-y-6">
      <!-- Grouper par service -->
      <div
        v-for="(horairesByService, serviceId) in horaires.reduce((acc, h) => {
          if (!acc[h.service_id]) acc[h.service_id] = []
          acc[h.service_id].push(h)
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
              {{ horairesByService[0].service?.nom }}
            </h2>
          </div>
        </div>

        <!-- Table horaires -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                  Jour
                </th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                  Ouverture
                </th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                  Fermeture
                </th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                  Note
                </th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="horaire in horairesByService" :key="horaire.id" class="hover:bg-gray-50">
                <template v-if="editingHoraire === horaire.id">
                  <!-- Mode édition -->
                  <td class="px-6 py-4">
                    <span :class="['text-xs font-medium px-3 py-1 rounded-full', getJourColor(horaire.jour_semaine)]">
                      {{ horaire.jour_semaine }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <input
                      v-model="editForm.ouverture"
                      type="time"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm"
                    />
                  </td>
                  <td class="px-6 py-4">
                    <input
                      v-model="editForm.fermeture"
                      type="time"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm"
                    />
                  </td>
                  <td class="px-6 py-4">
                    <input
                      v-model="editForm.note"
                      type="text"
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm"
                    />
                  </td>
                  <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                      <button
                        @click="updateHoraire"
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
                    <span :class="['text-xs font-medium px-3 py-1 rounded-full', getJourColor(horaire.jour_semaine)]">
                      {{ horaire.jour_semaine }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <p class="font-semibold text-gray-900">{{ horaire.ouverture }}</p>
                  </td>
                  <td class="px-6 py-4">
                    <p class="font-semibold text-gray-900">{{ horaire.fermeture }}</p>
                  </td>
                  <td class="px-6 py-4">
                    <p class="text-sm text-gray-600">{{ horaire.note || '-' }}</p>
                  </td>
                  <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                      <button
                        @click="startEdit(horaire)"
                        class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition"
                        title="Modifier"
                      >
                        <Edit :size="18" />
                      </button>
                      <button
                        @click="confirmDelete(horaire)"
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
      title="Supprimer cet horaire ?"
      :message="`Êtes-vous sûr de vouloir supprimer l'horaire du ${horaireToDelete?.jour_semaine} ?`"
      confirm-text="Supprimer"
      type="danger"
      @confirm="deleteHoraire"
      @cancel="showDeleteModal = false"
    />
  </AdminLayout>
</template>
