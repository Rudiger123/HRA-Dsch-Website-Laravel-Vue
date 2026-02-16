<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import {
  ArrowLeft, User, Phone, Calendar, Hospital,
  CheckCircle, XCircle, AlertCircle, Clock, MessageSquare
} from 'lucide-vue-next'

const props = defineProps({
  rdvRequest: Object,
  historique: Array,
})

const form = useForm({
  statut: props.rdvRequest.statut,
  note: '',
})

const updateStatus = (newStatus) => {
  form.statut = newStatus
  form.patch(route('admin.rdv-requests.update-status', props.rdvRequest.id))
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const getStatusColor = (statut) => {
  const colors = {
    'en_attente': 'bg-yellow-100 text-yellow-800 border-yellow-300',
    'confirme': 'bg-green-100 text-green-800 border-green-300',
    'annule': 'bg-red-100 text-red-800 border-red-300',
  }
  return colors[statut] || 'bg-gray-100 text-gray-800'
}
</script>

<template>
  <Head :title="`RDV ${rdvRequest.nom_patient} - Admin`" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <Link
        :href="route('admin.rdv-requests.index')"
        class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-4"
      >
        <ArrowLeft :size="20" />
        Retour à la liste
      </Link>
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Rendez-vous #{{ rdvRequest.id }}</h1>
          <p class="text-gray-600">Demande reçue le {{ formatDate(rdvRequest.created_at) }}</p>
        </div>
        <span :class="['inline-flex items-center gap-2 px-4 py-2 rounded-full font-medium border', getStatusColor(rdvRequest.statut)]">
          <component :is="rdvRequest.statut === 'confirme' ? CheckCircle : rdvRequest.statut === 'annule' ? XCircle : AlertCircle" :size="20" />
          {{ rdvRequest.statut === 'confirme' ? 'Confirmé' : rdvRequest.statut === 'annule' ? 'Annulé' : 'En attente' }}
        </span>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Colonne principale -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Informations patient -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
            <User :size="24" class="text-primary-600" />
            Informations du patient
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <p class="text-sm text-gray-500 mb-1">Nom complet</p>
              <p class="text-lg font-semibold text-gray-900">{{ rdvRequest.nom_patient }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500 mb-1">Âge</p>
              <p class="text-lg font-semibold text-gray-900">{{ rdvRequest.age }} ans</p>
            </div>
            <div>
              <p class="text-sm text-gray-500 mb-1">Téléphone</p>
              <a :href="`tel:${rdvRequest.telephone}`" class="text-lg font-semibold text-primary-600 hover:text-primary-700 flex items-center gap-2">
                <Phone :size="18" />
                {{ rdvRequest.telephone }}
              </a>
            </div>
            <div>
              <p class="text-sm text-gray-500 mb-1">Service demandé</p>
              <p class="text-lg font-semibold text-gray-900">{{ rdvRequest.service?.nom }}</p>
            </div>
          </div>

          <!-- Motif -->
          <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-500 mb-2">Motif de consultation</p>
            <div class="bg-gray-50 rounded-lg p-4">
              <p class="text-gray-900">{{ rdvRequest.motif }}</p>
            </div>
          </div>

          <!-- WhatsApp -->
          <div v-if="rdvRequest.confirmation_whatsapp" class="mt-4 flex items-center gap-2 text-sm text-green-600">
            <CheckCircle :size="16" />
            <span>Le patient souhaite une confirmation par WhatsApp</span>
          </div>
        </div>

        <!-- Historique patient -->
        <div v-if="historique.length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
            <Clock :size="24" class="text-primary-600" />
            Historique des rendez-vous
          </h2>

          <div class="space-y-4">
            <div
              v-for="rdv in historique"
              :key="rdv.id"
              class="border-l-4 pl-4 py-2"
              :class="rdv.statut === 'confirme' ? 'border-green-500' : rdv.statut === 'annule' ? 'border-red-500' : 'border-yellow-500'"
            >
              <div class="flex items-center justify-between mb-1">
                <p class="font-semibold text-gray-900">{{ rdv.service?.nom }}</p>
                <span :class="['text-xs px-2 py-1 rounded-full', getStatusColor(rdv.statut)]">
                  {{ rdv.statut }}
                </span>
              </div>
              <p class="text-sm text-gray-600">{{ formatDate(rdv.created_at) }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar Actions -->
      <div class="lg:col-span-1 space-y-6">
        <!-- Actions rapides -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
          <h2 class="text-lg font-bold text-gray-900 mb-4">Actions</h2>

          <div class="space-y-3">
            <button
              v-if="rdvRequest.statut !== 'confirme'"
              @click="updateStatus('confirme')"
              :disabled="form.processing"
              class="w-full flex items-center justify-center gap-2 bg-green-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-green-700 transition disabled:opacity-50"
            >
              <CheckCircle :size="20" />
              Confirmer le RDV
            </button>

            <button
              v-if="rdvRequest.statut !== 'annule'"
              @click="updateStatus('annule')"
              :disabled="form.processing"
              class="w-full flex items-center justify-center gap-2 bg-red-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-red-700 transition disabled:opacity-50"
            >
              <XCircle :size="20" />
              Annuler le RDV
            </button>

            <a
              :href="`https://wa.me/${rdvRequest.telephone.replace('+', '')}`"
              target="_blank"
              class="w-full flex items-center justify-center gap-2 bg-green-500 text-white px-4 py-3 rounded-lg font-semibold hover:bg-green-600 transition"
            >
              <MessageSquare :size="20" />
              Contacter par WhatsApp
            </a>

            <a
              :href="`tel:${rdvRequest.telephone}`"
              class="w-full flex items-center justify-center gap-2 border-2 border-primary-600 text-primary-600 px-4 py-3 rounded-lg font-semibold hover:bg-primary-50 transition"
            >
              <Phone :size="20" />
              Appeler le patient
            </a>
          </div>

          <!-- Note -->
          <div class="mt-6 pt-6 border-t border-gray-200">
            <label for="note" class="block text-sm font-semibold text-gray-700 mb-2">
              Ajouter une note
            </label>
            <textarea
              id="note"
              v-model="form.note"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 text-sm"
              placeholder="Note interne..."
            />
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
