<script setup>
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import { Lock, Mail, Eye, EyeOff, CheckCircle } from 'lucide-vue-next'

defineProps({
  token: String,
  email: String,
})

const form = useForm({
  token: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const showPassword = ref(false)
const showPasswordConfirmation = ref(false)
const submitted = ref(false)

const submit = () => {
  form.post('/admin/reset-password', {
    onSuccess: () => {
      submitted.value = true
    }
  })
}

// Récupérer les données des props ou de la route
const initForm = () => {
  const url = new URL(window.location)
  const token = url.searchParams.get('token')
  const email = url.searchParams.get('email')

  if (token) form.token = token
  if (email) form.email = email
}

initForm()
</script>

<template>
  <Head title="Réinitialiser le mot de passe - Admin" />

  <div class="min-h-screen bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 flex items-center justify-center p-4">
    <div class="max-w-md w-full">
      <!-- Logo -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-lg mb-4">
          <Lock :size="40" class="text-primary-600" />
        </div>
        <h1 class="text-3xl font-bold text-white mb-2">HRA Dschang</h1>
        <p class="text-primary-100">Réinitialisation du mot de passe</p>
      </div>

      <!-- Success Message -->
      <div v-if="submitted" class="bg-white rounded-2xl shadow-2xl p-8">
        <div class="text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
            <CheckCircle :size="32" class="text-green-600" />
          </div>
          <h2 class="text-2xl font-bold text-gray-900 mb-2">Succès !</h2>
          <p class="text-gray-600 mb-6">Votre mot de passe a été réinitialisé avec succès.</p>
          <a
            href="/admin/login"
            class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
          >
            Aller à la connexion
          </a>
        </div>
      </div>

      <!-- Reset Form -->
      <div v-else class="bg-white rounded-2xl shadow-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Réinitialiser votre mot de passe</h2>

        <!-- Error Messages -->
        <div v-if="form.errors && Object.keys(form.errors).length > 0" class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
          <p class="text-sm text-red-700 font-semibold mb-2">Erreur de réinitialisation :</p>
          <ul class="list-disc list-inside">
            <li v-for="(error, field) in form.errors" :key="field" class="text-sm text-red-600">
              {{ error }}
            </li>
          </ul>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
          <!-- Email (hidden but included in form) -->
          <input
            v-model="form.email"
            type="hidden"
            :value="email"
          />

          <!-- Token (hidden but included in form) -->
          <input
            v-model="form.token"
            type="hidden"
            :value="token"
          />

          <!-- Email Display -->
          <div>
            <label for="email-display" class="block text-sm font-semibold text-gray-700 mb-2">
              Email
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <Mail :size="20" class="text-gray-400" />
              </div>
              <input
                id="email-display"
                :value="email"
                type="email"
                disabled
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed"
              />
            </div>
          </div>

          <!-- New Password -->
          <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
              Nouveau mot de passe
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
                :disabled="form.processing"
                class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
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
            <p class="mt-1 text-xs text-gray-500">Minimum 8 caractères</p>
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
              Confirmer le mot de passe
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <Lock :size="20" class="text-gray-400" />
              </div>
              <input
                id="password_confirmation"
                v-model="form.password_confirmation"
                :type="showPasswordConfirmation ? 'text' : 'password'"
                required
                :disabled="form.processing"
                class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
                placeholder="••••••••"
              />
              <button
                type="button"
                @click="showPasswordConfirmation = !showPasswordConfirmation"
                class="absolute inset-y-0 right-0 pr-3 flex items-center"
              >
                <EyeOff v-if="showPasswordConfirmation" :size="20" class="text-gray-400" />
                <Eye v-else :size="20" class="text-gray-400" />
              </button>
            </div>
            <p v-if="form.errors.password_confirmation" class="mt-2 text-sm text-red-600">{{ form.errors.password_confirmation }}</p>
          </div>

          <!-- Password Requirements -->
          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm font-semibold text-blue-900 mb-2">Critères du mot de passe :</p>
            <ul class="text-xs text-blue-700 space-y-1">
              <li>✓ Au minimum 8 caractères</li>
              <li>✓ Mélange de majuscules et minuscules recommandé</li>
              <li>✓ Inclure des chiffres et caractères spéciaux recommandé</li>
            </ul>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-primary-600 hover:bg-primary-700 disabled:bg-primary-400 text-white font-semibold py-3 rounded-lg transition duration-200 disabled:cursor-not-allowed"
          >
            {{ form.processing ? 'Réinitialisation en cours...' : 'Réinitialiser le mot de passe' }}
          </button>
        </form>

        <!-- Back to Login Link -->
        <div class="mt-6 text-center">
          <a href="/admin/login" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
            Retour à la connexion
          </a>
        </div>
      </div>

      <!-- Help Text -->
      <div class="mt-8 text-center">
        <p class="text-primary-100 text-sm">
          Besoin d'aide ?<br>
          <a href="mailto:contact@hradschang.com" class="text-white font-semibold hover:underline">Contactez le support</a>
        </p>
      </div>
    </div>
  </div>
</template>
