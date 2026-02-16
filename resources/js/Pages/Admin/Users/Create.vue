<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ArrowLeft, Save } from 'lucide-vue-next'

const props = defineProps({
  roles: Array,
})

const form = useForm({
  name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: '',
  role: '',
  is_active: true,
})

const submit = () => {
  form.post(route('admin.users.store'))
}
</script>

<template>
  <Head title="Nouvel utilisateur - Admin" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <Link
        :href="route('admin.users.index')"
        class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-4"
      >
        <ArrowLeft :size="20" />
        Retour à la liste
      </Link>
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Nouvel utilisateur</h1>
      <p class="text-gray-600">Créez un nouveau compte utilisateur</p>
    </div>

    <!-- Form -->
    <form @submit.prevent="submit" class="max-w-2xl">
      <div class="space-y-6">
        <!-- Informations personnelles -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Informations personnelles</h2>

          <div class="space-y-6">
            <!-- Nom -->
            <div>
              <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                Nom complet <span class="text-red-500">*</span>
              </label>
              <input
                id="name"
                v-model="form.name"
                type="text"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                placeholder="Ex: Jean Paul Foka"
              />
              <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</p>
            </div>

            <!-- Email -->
            <div>
              <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                Adresse e-mail <span class="text-red-500">*</span>
              </label>
              <input
                id="email"
                v-model="form.email"
                type="email"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                placeholder="utilisateur@example.com"
              />
              <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
            </div>

            <!-- Téléphone -->
            <div>
              <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                Numéro de téléphone
              </label>
              <input
                id="phone"
                v-model="form.phone"
                type="tel"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                placeholder="Ex: +237 6XX XXX XXX"
              />
              <p v-if="form.errors.phone" class="mt-2 text-sm text-red-600">{{ form.errors.phone }}</p>
            </div>
          </div>
        </div>

        <!-- Connexion -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Accès</h2>

          <div class="space-y-6">
            <!-- Mot de passe -->
            <div>
              <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                Mot de passe <span class="text-red-500">*</span>
              </label>
              <input
                id="password"
                v-model="form.password"
                type="password"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                placeholder="Minimum 8 caractères"
              />
              <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
            </div>

            <!-- Confirmation mot de passe -->
            <div>
              <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                Confirmez le mot de passe <span class="text-red-500">*</span>
              </label>
              <input
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
              />
              <p v-if="form.errors.password_confirmation" class="mt-2 text-sm text-red-600">
                {{ form.errors.password_confirmation }}
              </p>
            </div>
          </div>
        </div>

        <!-- Rôles et permissions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Rôles et permissions</h2>

          <div>
            <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
              Rôle <span class="text-red-500">*</span>
            </label>
            <select
              id="role"
              v-model="form.role"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
            >
              <option value="">Sélectionnez un rôle</option>
              <option v-for="role in roles" :key="role.id" :value="role.name">
                {{ role.name }}
              </option>
            </select>
            <p v-if="form.errors.role" class="mt-2 text-sm text-red-600">{{ form.errors.role }}</p>
          </div>
        </div>

        <!-- Options -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center">
            <input
              id="is_active"
              v-model="form.is_active"
              type="checkbox"
              class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
            />
            <label for="is_active" class="ml-3 text-sm text-gray-700">
              Utilisateur actif
            </label>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-4 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <Link
            :href="route('admin.users.index')"
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
            <span v-if="form.processing">Création...</span>
            <span v-else>Créer l'utilisateur</span>
          </button>
        </div>
      </div>
    </form>
  </AdminLayout>
</template>
