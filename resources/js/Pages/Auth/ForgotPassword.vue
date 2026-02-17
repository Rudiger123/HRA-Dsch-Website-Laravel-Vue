<script setup>
import { ref } from 'vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import { Mail, ArrowLeft, CheckCircle } from 'lucide-vue-next'

const form = useForm({
  email: '',
})

const page = usePage()
const status = ref(page.props.status || null)

const submit = () => {
  form.post('/admin/forgot-password', {
    onSuccess: () => {
      status.value = form.data().email
    }
  })
}
</script>

<template>
  <Head title="Mot de passe oublié - Admin" />

  <div class="min-h-screen bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 flex items-center justify-center p-4">
    <div class="max-w-md w-full">
      <!-- Logo -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-lg mb-4">
          <Mail :size="40" class="text-primary-600" />
        </div>
        <h1 class="text-3xl font-bold text-white mb-2">HRA Dschang</h1>
        <p class="text-primary-100">Réinitialisation du mot de passe</p>
      </div>

      <!-- Card -->
      <div class="bg-white rounded-2xl shadow-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Mot de passe oublié ?</h2>
        <p class="text-gray-600 text-sm mb-6">Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>

        <!-- Success Message -->
        <div v-if="status" class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
          <CheckCircle :size="24" class="text-green-600 flex-shrink-0 mt-0.5" />
          <div>
            <p class="text-sm font-semibold text-green-900">Email envoyé avec succès !</p>
            <p class="text-sm text-green-700 mt-1">Un lien de réinitialisation a été envoyé à <strong>{{ status }}</strong></p>
            <p class="text-sm text-green-700 mt-2">Vérifiez votre dossier spam si vous ne recevez rien.</p>
          </div>
        </div>

        <!-- Error Messages -->
        <div v-if="form.errors && Object.keys(form.errors).length > 0" class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
          <p class="text-sm text-red-700 font-semibold mb-2">Erreur :</p>
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
              Adresse email
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
                :disabled="form.processing"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
                placeholder="votre.email@exemple.com"
              />
            </div>
            <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="form.processing"
            class="w-full bg-primary-600 hover:bg-primary-700 disabled:bg-primary-400 text-white font-semibold py-3 rounded-lg transition duration-200 disabled:cursor-not-allowed"
          >
            {{ form.processing ? 'Envoi en cours...' : 'Envoyer le lien de réinitialisation' }}
          </button>
        </form>

        <!-- Back to Login Link -->
        <div class="mt-6 text-center">
          <a href="/admin/login" class="inline-flex items-center gap-2 text-sm text-primary-600 hover:text-primary-700 font-medium">
            <ArrowLeft :size="16" />
            Retour à la connexion
          </a>
        </div>
      </div>

      <!-- Help Text -->
      <div class="mt-8 text-center">
        <p class="text-primary-100 text-sm">
          Vous n'avez pas reçu d'email ?<br>
          <a href="mailto:contact@hradschang.com" class="text-white font-semibold hover:underline">Contactez-nous</a>
        </p>
      </div>
    </div>
  </div>
</template>
