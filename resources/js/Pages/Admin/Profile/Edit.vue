<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ImageUpload from '@/Components/Admin/ImageUpload.vue'
import { User, Mail, Phone, Lock, Save, Shield } from 'lucide-vue-next'

const props = defineProps({
  user: Object,
})

// Form infos
const infoForm = useForm({
  name: props.user.name,
  email: props.user.email,
  phone: props.user.phone || '',
})

const updateInfo = () => {
  infoForm.patch(route('admin.profile.update'))
}

// Form photo
const photoForm = useForm({
  photo: null,
})

const updatePhoto = () => {
  photoForm.post(route('admin.profile.update-photo'), {
    forceFormData: true,
    onSuccess: () => {
      photoForm.reset()
    }
  })
}

const deletePhoto = () => {
  if (confirm('Supprimer votre photo de profil ?')) {
    photoForm.delete(route('admin.profile.delete-photo'))
  }
}

// Form password
const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

const updatePassword = () => {
  passwordForm.patch(route('admin.profile.update-password'), {
    onSuccess: () => {
      passwordForm.reset()
    }
  })
}
</script>

<template>
  <Head title="Mon Profil - Admin" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Mon profil</h1>
      <p class="text-gray-600">Gérez vos informations personnelles</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Photo -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Photo de profil</h2>

          <ImageUpload
            v-model="photoForm.photo"
            :current-image="user.photo_url"
            :error="photoForm.errors.photo"
          />

          <div class="flex flex-col gap-3 mt-6">
            <button
              v-if="photoForm.photo"
              @click="updatePhoto"
              :disabled="photoForm.processing"
              class="flex items-center justify-center gap-2 bg-primary-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-primary-700 transition disabled:opacity-50"
            >
              <Save :size="20" />
              Enregistrer la photo
            </button>
            <button
              v-if="user.photo"
              @click="deletePhoto"
              class="flex items-center justify-center gap-2 border-2 border-red-600 text-red-600 px-4 py-3 rounded-lg font-semibold hover:bg-red-50 transition"
            >
              Supprimer la photo
            </button>
          </div>

          <!-- Rôle -->
          <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-500 mb-2">Votre rôle</p>
            <div class="flex items-center gap-2 text-primary-600">
              <Shield :size="20" />
              <span class="font-semibold">{{ user.roles && user.roles[0] ? user.roles[0].name : 'Administrateur' }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Informations -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Informations personnelles -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Informations personnelles</h2>

          <form @submit.prevent="updateInfo" class="space-y-6">
            <!-- Nom -->
            <div>
              <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                Nom complet <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <User :size="20" class="text-gray-400" />
                </div>
                <input
                  id="name"
                  v-model="infoForm.name"
                  type="text"
                  required
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                />
              </div>
              <p v-if="infoForm.errors.name" class="mt-2 text-sm text-red-600">{{ infoForm.errors.name }}</p>
            </div>

            <!-- Email -->
            <div>
              <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                Email <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <Mail :size="20" class="text-gray-400" />
                </div>
                <input
                  id="email"
                  v-model="infoForm.email"
                  type="email"
                  required
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                />
              </div>
              <p v-if="infoForm.errors.email" class="mt-2 text-sm text-red-600">{{ infoForm.errors.email }}</p>
            </div>

            <!-- Téléphone -->
            <div>
              <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                Téléphone
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <Phone :size="20" class="text-gray-400" />
                </div>
                <input
                  id="phone"
                  v-model="infoForm.phone"
                  type="tel"
                  placeholder="+237677123456"
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                />
              </div>
              <p v-if="infoForm.errors.phone" class="mt-2 text-sm text-red-600">{{ infoForm.errors.phone }}</p>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end pt-4 border-t border-gray-200">
              <button
                type="submit"
                :disabled="infoForm.processing"
                class="flex items-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition disabled:opacity-50"
              >
                <Save :size="20" />
                <span v-if="infoForm.processing">Enregistrement...</span>
                <span v-else>Enregistrer</span>
              </button>
            </div>
          </form>
        </div>

        <!-- Changer mot de passe -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Changer le mot de passe</h2>

          <form @submit.prevent="updatePassword" class="space-y-6">
            <!-- Mot de passe actuel -->
            <div>
              <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                Mot de passe actuel <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <Lock :size="20" class="text-gray-400" />
                </div>
                <input
                  id="current_password"
                  v-model="passwordForm.current_password"
                  type="password"
                  required
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                />
              </div>
              <p v-if="passwordForm.errors.current_password" class="mt-2 text-sm text-red-600">{{ passwordForm.errors.current_password }}</p>
            </div>

            <!-- Nouveau mot de passe -->
            <div>
              <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                Nouveau mot de passe <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <Lock :size="20" class="text-gray-400" />
                </div>
                <input
                  id="password"
                  v-model="passwordForm.password"
                  type="password"
                  required
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                />
              </div>
              <p class="mt-2 text-sm text-gray-500">Minimum 8 caractères</p>
              <p v-if="passwordForm.errors.password" class="mt-2 text-sm text-red-600">{{ passwordForm.errors.password }}</p>
            </div>

            <!-- Confirmation -->
            <div>
              <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                Confirmer le mot de passe <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <Lock :size="20" class="text-gray-400" />
                </div>
                <input
                  id="password_confirmation"
                  v-model="passwordForm.password_confirmation"
                  type="password"
                  required
                  class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                />
              </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end pt-4 border-t border-gray-200">
              <button
                type="submit"
                :disabled="passwordForm.processing"
                class="flex items-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition disabled:opacity-50"
              >
                <Lock :size="20" />
                <span v-if="passwordForm.processing">Changement...</span>
                <span v-else>Changer le mot de passe</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
