<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import {
  ArrowLeft, Mail, Phone, User, Clock,
  Send, Trash2, MailOpen
} from 'lucide-vue-next'

const props = defineProps({
  contact: Object,
})

const replyForm = useForm({
  reponse: '',
})

const sendReply = () => {
  replyForm.post(route('admin.contacts.reply', props.contact.id), {
    onSuccess: () => {
      replyForm.reset()
    }
  })
}

const deleteMessage = () => {
  if (confirm('Êtes-vous sûr de vouloir supprimer ce message ?')) {
    replyForm.delete(route('admin.contacts.destroy', props.contact.id))
  }
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
</script>

<template>
  <Head :title="`Message de ${contact.nom} - Admin`" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <Link
        :href="route('admin.contacts.index')"
        class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-4"
      >
        <ArrowLeft :size="20" />
        Retour aux messages
      </Link>
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Message #{{ contact.id }}</h1>
          <p class="text-gray-600">Reçu le {{ formatDate(contact.created_at) }}</p>
        </div>
        <span :class="[
          'inline-flex items-center gap-2 px-4 py-2 rounded-full font-medium',
          contact.lu ? 'bg-gray-100 text-gray-800' : 'bg-primary-100 text-primary-800'
        ]">
          <component :is="contact.lu ? MailOpen : Mail" :size="20" />
          {{ contact.lu ? 'Lu' : 'Non lu' }}
        </span>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Message -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
          <!-- Expéditeur -->
          <div class="mb-6 pb-6 border-b border-gray-200">
            <div class="flex items-start gap-4">
              <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                <User :size="32" class="text-primary-600" />
              </div>
              <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900 mb-2">{{ contact.nom }}</h2>
                <div class="space-y-2">
                  <a :href="`mailto:${contact.email}`" class="flex items-center gap-2 text-sm text-primary-600 hover:text-primary-700">
                    <Mail :size="16" />
                    {{ contact.email }}
                  </a>
                  <a v-if="contact.telephone" :href="`tel:${contact.telephone}`" class="flex items-center gap-2 text-sm text-primary-600 hover:text-primary-700">
                    <Phone :size="16" />
                    {{ contact.telephone }}
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Message -->
          <div>
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Message :</h3>
            <div class="bg-gray-50 rounded-lg p-6">
              <p class="text-gray-900 whitespace-pre-wrap leading-relaxed">{{ contact.message }}</p>
            </div>
          </div>
        </div>

        <!-- Répondre -->
        <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h3 class="text-lg font-bold text-gray-900 mb-4">Répondre par email</h3>
          <form @submit.prevent="sendReply">
            <textarea
              v-model="replyForm.reponse"
              rows="6"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
              placeholder="Rédigez votre réponse..."
            />
            <p v-if="replyForm.errors.reponse" class="mt-2 text-sm text-red-600">{{ replyForm.errors.reponse }}</p>
            <div class="flex items-center justify-end gap-3 mt-4">
              <button
                type="submit"
                :disabled="replyForm.processing"
                class="flex items-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition disabled:opacity-50"
              >
                <Send :size="20" />
                <span v-if="replyForm.processing">Envoi...</span>
                <span v-else>Envoyer la réponse</span>
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Sidebar Actions -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24 space-y-4">
          <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>

          <a
            :href="`mailto:${contact.email}`"
            class="w-full flex items-center justify-center gap-2 bg-primary-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-primary-700 transition"
          >
            <Mail :size="20" />
            Envoyer un email
          </a>

          <a
            v-if="contact.telephone"
            :href="`tel:${contact.telephone}`"
            class="w-full flex items-center justify-center gap-2 border-2 border-primary-600 text-primary-600 px-4 py-3 rounded-lg font-semibold hover:bg-primary-50 transition"
          >
            <Phone :size="20" />
            Appeler
          </a>

          <button
            @click="deleteMessage"
            class="w-full flex items-center justify-center gap-2 bg-red-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-red-700 transition"
          >
            <Trash2 :size="20" />
            Supprimer
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
