<script setup>
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import { Shield, Mail, Lock, Eye, EyeOff } from 'lucide-vue-next'

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const showPassword = ref(false)

const submit = () => {
  form.post('/admin/login', {
    onFinish: () => {
      form.password = ''
    }
  })
}
</script>

<template>
  <Head title="Connexion - Admin" />

  <div class="min-h-screen bg-linear-to-br from-primary-600 via-primary-700 to-primary-800 flex items-center justify-center p-4">
    <div class="max-w-md w-full">
      <!-- Logo -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-lg mb-4">
          <Shield :size="40" class="text-primary-600" />
        </div>
        <h1 class="text-3xl font-bold text-white mb-2">HRA Dschang</h1>
        <p class="text-primary-100">Administration</p>
      </div>

      <!-- Card -->
      <div class="bg-white rounded-2xl shadow-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Connexion</h2>

        <!-- Display general errors -->
        <div v-if="form.errors && Object.keys(form.errors).length > 0" class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
          <p class="text-sm text-red-700 font-semibold mb-2">Erreur de connexion :</p>
          <ul class="list-disc list-inside">
            <li v-for="(error, field) in form.errors" :key="field" class="text-sm text-red-600">
              {{ error }}
            </li>
          </ul>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
              Email
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <Mail :size="20" class="text-gray-400" />
              </div>
              <input
                id="email"
                v-model="form.email"
                type="email"
                required
                autofocus
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                placeholder="votre.email@exemple.com"
              />
            </div>
            <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
              Mot de passe
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <Lock :size="20" class="text-gray-400" />
              </div>
              <input
                id="password"
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                required
                class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                placeholder="••••••••"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-0 pr-3 flex items-center"
              >
                <EyeOff v-if="showPassword" :size="20" class="text-gray-400" />
                <Eye v-else :size="20" class="text-gray-400" />
              </button>
            </div>
            <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
          </div>

          <!-- Remember Me -->
          <div class="flex items-center justify-between">
            <label class="flex items-center">
              <input
                v-model="form.remember"
                type="checkbox"
                class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
              />
              <span class="ml-2 text-sm text-gray-700">Se souvenir de moi</span>
            </label>

            <a href="/admin/forgot-password" class="text-sm text-primary-600 hover:text-primary-700">
              Mot de passe oublié ?
            </a>
          </div>

          <!-- Submit -->
          <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-primary-600 text-white py-3 rounded-lg font-semibold hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 transition disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="form.processing">Connexion...</span>
            <span v-else>Se connecter</span>
          </button>
        </form>
      </div>

      <!-- Footer -->
      <p class="text-center text-primary-100 text-sm mt-6">
        © 2026 HRA Dschang. Tous droits réservés.
      </p>
    </div>
  </div>
</template>
