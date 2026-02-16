<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { route } from 'ziggy-js'
import { ArrowLeft, Edit, Trash2, Hospital, Users as UsersIcon, Clock, DollarSign } from 'lucide-vue-next'

const props = defineProps({
  service: Object,
})

const formatNumber = (num) => {
  return new Intl.NumberFormat('fr-FR').format(num)
}
</script>

<template>
  <Head :title="`${service.nom} - Admin`" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <Link
        :href="route('admin.services.index')"
        class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-4"
      >
        <ArrowLeft :size="20" />
        Retour à la liste
      </Link>
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ service.nom }}</h1>
          <p class="text-gray-600">Détails du service médical</p>
        </div>
        <Link
          :href="route('admin.services.edit', service.id)"
          class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition"
        >
          <Edit :size="20" />
          Modifier
        </Link>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Contenu principal -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Information générale -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Informations générales</h2>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
              <p class="text-gray-700 whitespace-pre-wrap">{{ service.description }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tarif consultation</label>
                <p class="text-lg font-bold text-blue-600">{{ formatNumber(service.tarif_consultation) }} FCFA</p>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Ordre d'affichage</label>
                <p class="text-lg font-bold text-gray-900">{{ service.ordre }}</p>
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">Statut</label>
              <div class="flex items-center gap-2">
                <span :class="[
                  'inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold',
                  service.actif
                    ? 'bg-green-100 text-green-800'
                    : 'bg-red-100 text-red-800'
                ]">
                  {{ service.actif ? 'Actif' : 'Inactif' }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Médecins -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center gap-2 mb-4">
            <UsersIcon :size="24" class="text-blue-600" />
            <h2 class="text-xl font-bold text-gray-900">Médecins ({{ service.medecins?.length || 0 }})</h2>
          </div>

          <div v-if="service.medecins?.length">
            <div class="space-y-2">
              <div v-for="medecin in service.medecins" :key="medecin.id" class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                <p class="font-semibold text-gray-900">{{ medecin.nom }}</p>
                <p class="text-sm text-gray-600">{{ medecin.specialite }}</p>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-6 text-gray-500">
            <p>Aucun médecin assigné à ce service</p>
          </div>
        </div>

        <!-- Horaires -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center gap-2 mb-4">
            <Clock :size="24" class="text-blue-600" />
            <h2 class="text-xl font-bold text-gray-900">Horaires ({{ service.horaires?.length || 0 }})</h2>
          </div>

          <div v-if="service.horaires?.length">
            <div class="space-y-2">
              <div v-for="horaire in service.horaires" :key="horaire.id" class="p-3 bg-gray-50 rounded-lg border border-gray-200 flex justify-between items-center">
                <div>
                  <p class="font-semibold text-gray-900">{{ horaire.jour_semaine }}</p>
                  <p class="text-sm text-gray-600">{{ horaire.ouverture }} - {{ horaire.fermeture }}</p>
                  <p v-if="horaire.note" class="text-xs text-gray-500 italic">{{ horaire.note }}</p>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-6 text-gray-500">
            <p>Aucun horaire défini</p>
          </div>
        </div>

        <!-- Tarifs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center gap-2 mb-4">
            <DollarSign :size="24" class="text-blue-600" />
            <h2 class="text-xl font-bold text-gray-900">Tarifs ({{ service.tarifs?.length || 0 }})</h2>
          </div>

          <div v-if="service.tarifs?.length">
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Désignation</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Montant</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Type patient</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="tarif in service.tarifs" :key="tarif.id">
                    <td class="px-4 py-2 text-sm text-gray-900">{{ tarif.designation }}</td>
                    <td class="px-4 py-2 text-sm font-semibold text-gray-900">{{ formatNumber(tarif.montant) }} FCFA</td>
                    <td class="px-4 py-2 text-sm text-gray-600">{{ tarif.type_patient }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div v-else class="text-center py-6 text-gray-500">
            <p>Aucun tarif défini</p>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
          <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>

          <div class="space-y-3">
            <Link
              :href="route('admin.services.edit', service.id)"
              class="w-full flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-blue-700 transition"
            >
              <Edit :size="18" />
              Modifier
            </Link>

            <button
              type="button"
              class="w-full flex items-center justify-center gap-2 bg-red-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-red-700 transition"
              @click="() => {
                if(confirm('Êtes-vous sûr de vouloir supprimer ce service ?')) {
                  $inertia.delete(route('admin.services.destroy', service.id))
                }
              }"
            >
              <Trash2 :size="18" />
              Supprimer
            </button>
          </div>

          <!-- Métadonnées -->
          <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="text-sm text-gray-600 space-y-2">
              <div>
                <label class="font-semibold text-gray-700">Créé le</label>
                <p>{{ new Date(service.created_at).toLocaleDateString('fr-FR') }}</p>
              </div>
              <div>
                <label class="font-semibold text-gray-700">Modifié le</label>
                <p>{{ new Date(service.updated_at).toLocaleDateString('fr-FR') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
