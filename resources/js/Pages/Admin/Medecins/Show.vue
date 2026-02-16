<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ArrowLeft, Edit, Trash2, Download, Stethoscope } from 'lucide-vue-next'

const props = defineProps({
  medecin: Object,
})
</script>

<template>
  <Head :title="`Dr. ${medecin.nom} - Admin`" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <Link
        :href="route('admin.medecins.index')"
        class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-4"
      >
        <ArrowLeft :size="20" />
        Retour à la liste
      </Link>
    </div>

    <!-- Contenu -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Colonne gauche : Photo et infos basiques -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-24">
          <!-- Photo -->
          <div v-if="medecin.photo" class="h-64 bg-gradient-to-br from-primary-400 to-primary-600">
            <img
              :src="medecin.photo"
              :alt="medecin.nom"
              class="w-full h-full object-cover"
            />
          </div>
          <div v-else class="h-64 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
            <Stethoscope :size="80" class="text-white opacity-30" />
          </div>

          <!-- Infos -->
          <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Dr. {{ medecin.nom }}</h1>

            <div class="mb-4">
              <span
                :class="[
                  'inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium',
                  medecin.actif
                    ? 'bg-green-100 text-green-800'
                    : 'bg-red-100 text-red-800'
                ]"
              >
                {{ medecin.actif ? '✓ Actif' : '✗ Inactif' }}
              </span>
            </div>

            <!-- Actions -->
            <div class="flex flex-col gap-2 pt-4 border-t border-gray-200">
              <Link
                :href="route('admin.medecins.edit', medecin.id)"
                class="w-full flex items-center justify-center gap-2 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-medium"
              >
                <Edit :size="18" />
                Modifier
              </Link>
              <button
                class="w-full flex items-center justify-center gap-2 py-2 text-red-600 hover:bg-red-50 rounded-lg transition font-medium"
              >
                <Trash2 :size="18" />
                Supprimer
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Colonne droite : Détails -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Informations générales -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Informations générales</h2>

          <div class="space-y-4">
            <div>
              <p class="text-sm text-gray-600">Spécialité</p>
              <p class="text-base font-semibold text-gray-900">{{ medecin.specialite }}</p>
            </div>

            <div>
              <p class="text-sm text-gray-600">Langues parlées</p>
              <p class="text-base font-semibold text-gray-900">{{ medecin.langues }}</p>
            </div>

            <div>
              <p class="text-sm text-gray-600">Diplômes et formations</p>
              <p class="text-base text-gray-900 whitespace-pre-line">{{ medecin.diplomes }}</p>
            </div>
          </div>
        </div>

        <!-- Biographie -->
        <div v-if="medecin.bio" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Biographie</h2>
          <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ medecin.bio }}</p>
        </div>

        <!-- Services -->
        <div v-if="medecin.services && medecin.services.length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Services assignés</h2>

          <div class="space-y-2">
            <div
              v-for="service in medecin.services"
              :key="service.id"
              class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg"
            >
              <div class="w-2 h-2 rounded-full bg-primary-600"></div>
              <span class="font-medium text-gray-900">{{ service.nom }}</span>
            </div>
          </div>
        </div>

        <!-- Métadonnées -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Informations système</h2>

          <div class="space-y-3 text-sm">
            <div class="flex justify-between">
              <span class="text-gray-600">Date de création</span>
              <span class="font-medium text-gray-900">{{ new Date(medecin.created_at).toLocaleString('fr-FR') }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Dernière modification</span>
              <span class="font-medium text-gray-900">{{ new Date(medecin.updated_at).toLocaleString('fr-FR') }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
