<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ArrowLeft, Save } from 'lucide-vue-next'

const form = useForm({
  nom: '',
  description: '',
  icon: 'Heart',
  tarif_consultation: 5000,
  actif: true,
  ordre: 1,
})

const submit = () => {
  form.post(route('admin.services.store'))
}

const iconsDisponibles = [
  'Heart', 'Activity', 'Stethoscope', 'Syringe',
  'Pill', 'Baby', 'FlaskConical', 'ScanLine',
  'CircleDot', 'Hospital', 'Ambulance', 'HeartPulse'
]
</script>

<template>
  <Head title="Nouveau service - Admin" />

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
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Nouveau service médical</h1>
      <p class="text-gray-600">Créez un nouveau service médical</p>
    </div>

    <!-- Form -->
    <div class="max-w-3xl">
      <form @submit.prevent="submit" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="space-y-6">
          <!-- Nom -->
          <div>
            <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2">
              Nom du service <span class="text-red-500">*</span>
            </label>
            <input
              id="nom"
              v-model="form.nom"
              type="text"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Ex: Pédiatrie"
            />
            <p v-if="form.errors.nom" class="mt-2 text-sm text-red-600">{{ form.errors.nom }}</p>
          </div>

          <!-- Description -->
          <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
              Description <span class="text-red-500">*</span>
            </label>
            <textarea
              id="description"
              v-model="form.description"
              rows="5"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Description détaillée du service..."
            />
            <p v-if="form.errors.description" class="mt-2 text-sm text-red-600">{{ form.errors.description }}</p>
          </div>

          <!-- Icon -->
          <div>
            <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">
              Icône <span class="text-red-500">*</span>
            </label>
            <select
              id="icon"
              v-model="form.icon"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
              <option v-for="icon in iconsDisponibles" :key="icon" :value="icon">
                {{ icon }}
              </option>
            </select>
            <p class="mt-2 text-sm text-gray-500">Icône affichée sur le site public</p>
            <p v-if="form.errors.icon" class="mt-2 text-sm text-red-600">{{ form.errors.icon }}</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Tarif consultation -->
            <div>
              <label for="tarif_consultation" class="block text-sm font-semibold text-gray-700 mb-2">
                Tarif consultation (FCFA) <span class="text-red-500">*</span>
              </label>
              <input
                id="tarif_consultation"
                v-model.number="form.tarif_consultation"
                type="number"
                min="0"
                step="500"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
              <p v-if="form.errors.tarif_consultation" class="mt-2 text-sm text-red-600">{{ form.errors.tarif_consultation }}</p>
            </div>

            <!-- Ordre -->
            <div>
              <label for="ordre" class="block text-sm font-semibold text-gray-700 mb-2">
                Ordre d'affichage
              </label>
              <input
                id="ordre"
                v-model.number="form.ordre"
                type="number"
                min="1"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
              <p class="mt-2 text-sm text-gray-500">Position dans la liste des services</p>
              <p v-if="form.errors.ordre" class="mt-2 text-sm text-red-600">{{ form.errors.ordre }}</p>
            </div>
          </div>

          <!-- Actif -->
          <div class="flex items-center">
            <input
              id="actif"
              v-model="form.actif"
              type="checkbox"
              class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
            />
            <label for="actif" class="ml-2 text-sm text-gray-700">
              Service actif (visible sur le site public)
            </label>
          </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
          <Link
            :href="route('admin.services.index')"
            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition"
          >
            Annuler
          </Link>
          <button
            type="submit"
            :disabled="form.processing"
            class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition disabled:opacity-50"
          >
            <Save :size="20" />
            <span v-if="form.processing">Enregistrement...</span>
            <span v-else>Enregistrer</span>
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
