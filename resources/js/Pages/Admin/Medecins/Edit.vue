<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ImageUpload from '@/Components/Admin/ImageUpload.vue'
import { ArrowLeft, Save } from 'lucide-vue-next'

const props = defineProps({
  medecin: Object,
  services: Array,
  medecinServices: Array,
})

const form = useForm({
  nom: props.medecin.nom,
  specialite: props.medecin.specialite,
  diplomes: props.medecin.diplomes,
  bio: props.medecin.bio || '',
  langues: props.medecin.langues,
  photo: null,
  actif: props.medecin.actif,
  services: props.medecinServices || [],
})

const submit = () => {
  form.put(route('admin.medecins.update', props.medecin.id), {
    forceFormData: true,
  })
}

const specialitesDisponibles = [
  'Pédiatrie',
  'Gynécologie-Obstétrique',
  'Cardiologie',
  'Chirurgie Générale',
  'Médecine d\'Urgence',
  'Médecine Générale',
  'Biologie Médicale',
  'Radiologie',
  'Anesthésie-Réanimation',
  'Autre'
]
</script>

<template>
  <Head :title="`Modifier Dr. ${medecin.nom} - Admin`" />

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
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier Dr. {{ medecin.nom }}</h1>
      <p class="text-gray-600">Modifiez les informations du médecin</p>
    </div>

    <!-- Form -->
    <form @submit.prevent="submit" class="max-w-4xl">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne gauche : Photo -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
            <ImageUpload
              v-model="form.photo"
              :current-image="medecin.photo"
              label="Photo du médecin"
              :error="form.errors.photo"
            />
          </div>
        </div>

        <!-- Colonne droite : Informations -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Informations générales -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Informations générales</h2>

            <div class="space-y-6">
              <!-- Nom -->
              <div>
                <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2">
                  Nom complet <span class="text-red-500">*</span>
                </label>
                <input
                  id="nom"
                  v-model="form.nom"
                  type="text"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                />
                <p v-if="form.errors.nom" class="mt-2 text-sm text-red-600">{{ form.errors.nom }}</p>
              </div>

              <!-- Spécialité -->
              <div>
                <label for="specialite" class="block text-sm font-semibold text-gray-700 mb-2">
                  Spécialité <span class="text-red-500">*</span>
                </label>
                <select
                  id="specialite"
                  v-model="form.specialite"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                >
                  <option value="">Sélectionnez une spécialité</option>
                  <option v-for="spec in specialitesDisponibles" :key="spec" :value="spec">
                    {{ spec }}
                  </option>
                </select>
                <p v-if="form.errors.specialite" class="mt-2 text-sm text-red-600">{{ form.errors.specialite }}</p>
              </div>

              <!-- Diplômes -->
              <div>
                <label for="diplomes" class="block text-sm font-semibold text-gray-700 mb-2">
                  Diplômes et formations <span class="text-red-500">*</span>
                </label>
                <textarea
                  id="diplomes"
                  v-model="form.diplomes"
                  rows="3"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                />
                <p v-if="form.errors.diplomes" class="mt-2 text-sm text-red-600">{{ form.errors.diplomes }}</p>
              </div>

              <!-- Langues -->
              <div>
                <label for="langues" class="block text-sm font-semibold text-gray-700 mb-2">
                  Langues parlées <span class="text-red-500">*</span>
                </label>
                <input
                  id="langues"
                  v-model="form.langues"
                  type="text"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                />
                <p v-if="form.errors.langues" class="mt-2 text-sm text-red-600">{{ form.errors.langues }}</p>
              </div>

              <!-- Bio -->
              <div>
                <label for="bio" class="block text-sm font-semibold text-gray-700 mb-2">
                  Biographie (optionnel)
                </label>
                <textarea
                  id="bio"
                  v-model="form.bio"
                  rows="5"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                />
                <p v-if="form.errors.bio" class="mt-2 text-sm text-red-600">{{ form.errors.bio }}</p>
              </div>
            </div>
          </div>

          <!-- Services assignés -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Services assignés</h2>

            <div class="space-y-3">
              <div
                v-for="service in services"
                :key="service.id"
                class="flex items-center"
              >
                <input
                  :id="`service-${service.id}`"
                  v-model="form.services"
                  :value="service.id"
                  type="checkbox"
                  class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                />
                <label :for="`service-${service.id}`" class="ml-3 text-sm text-gray-700">
                  {{ service.nom }}
                </label>
              </div>
            </div>
            <p v-if="form.errors.services" class="mt-2 text-sm text-red-600">{{ form.errors.services }}</p>
          </div>

          <!-- Options -->
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
              <input
                id="actif"
                v-model="form.actif"
                type="checkbox"
                class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
              />
              <label for="actif" class="ml-3 text-sm text-gray-700">
                Médecin actif (visible sur le site public)
              </label>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex items-center justify-end gap-4 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <Link
              :href="route('admin.medecins.index')"
              class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition"
            >
              Annuler
            </Link>
            <button
              type="submit"
              :disabled="form.processing"
              class="flex items-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition disabled:opacity-50"
            >
              <Save :size="20" />
              <span v-if="form.processing">Enregistrement...</span>
              <span v-else>Enregistrer les modifications</span>
            </button>
          </div>
        </div>
      </div>
    </form>
  </AdminLayout>
</template>
