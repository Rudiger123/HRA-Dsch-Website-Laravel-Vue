<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ArrowLeft, Edit, Trash2, Shield, Mail, Phone, Calendar } from 'lucide-vue-next'

const props = defineProps({
  user: Object,
})

const getRoleLabel = (role) => {
  const labels = {
    'super_admin': 'Super Admin',
    'admin': 'Administrateur',
    'editeur': 'Éditeur',
    'receptionniste': 'Réceptionniste',
    'medecin': 'Médecin',
  }
  return labels[role] || role
}

const getRoleBadgeColor = (role) => {
  const colors = {
    'super_admin': 'bg-red-100 text-red-800',
    'admin': 'bg-purple-100 text-purple-800',
    'editeur': 'bg-blue-100 text-blue-800',
    'receptionniste': 'bg-green-100 text-green-800',
    'medecin': 'bg-yellow-100 text-yellow-800',
  }
  return colors[role] || 'bg-gray-100 text-gray-800'
}
</script>

<template>
  <Head :title="`${user.name} - Admin`" />

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
    </div>

    <!-- Contenu -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Colonne gauche : Avatar et infos basiques -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-24">
          <!-- Avatar -->
          <div class="h-48 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
            <img
              v-if="user.photo_url"
              :src="user.photo_url"
              :alt="user.name"
              class="w-full h-full object-cover"
            />
            <div v-else class="w-20 h-20 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
              <span class="text-3xl font-bold text-white">{{ user.name.charAt(0).toUpperCase() }}</span>
            </div>
          </div>

          <!-- Infos -->
          <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ user.name }}</h1>

            <div class="mb-4">
              <span
                :class="[
                  'inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium',
                  getRoleBadgeColor(user.roles?.[0]?.name)
                ]"
              >
                <Shield :size="12" />
                {{ getRoleLabel(user.roles?.[0]?.name) }}
              </span>
            </div>

            <div class="mb-4">
              <span
                :class="[
                  'inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium',
                  user.is_active
                    ? 'bg-green-100 text-green-800'
                    : 'bg-red-100 text-red-800'
                ]"
              >
                {{ user.is_active ? '✓ Actif' : '✗ Inactif' }}
              </span>
            </div>

            <!-- Actions -->
            <div class="flex flex-col gap-2 pt-4 border-t border-gray-200">
              <Link
                :href="route('admin.users.edit', user.id)"
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
        <!-- Informations de contact -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Informations de contact</h2>

          <div class="space-y-4">
            <!-- Email -->
            <div class="flex items-start gap-3">
              <Mail :size="20" class="text-primary-600 mt-0.5 flex-shrink-0" />
              <div>
                <p class="text-sm text-gray-600">Adresse e-mail</p>
                <a
                  :href="`mailto:${user.email}`"
                  class="text-base font-semibold text-primary-600 hover:underline"
                >
                  {{ user.email }}
                </a>
              </div>
            </div>

            <!-- Téléphone -->
            <div v-if="user.phone" class="flex items-start gap-3">
              <Phone :size="20" class="text-primary-600 mt-0.5 flex-shrink-0" />
              <div>
                <p class="text-sm text-gray-600">Numéro de téléphone</p>
                <a
                  :href="`tel:${user.phone}`"
                  class="text-base font-semibold text-primary-600 hover:underline"
                >
                  {{ user.phone }}
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Rôles et permissions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Rôles et permissions</h2>

          <div class="space-y-2">
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
              <Shield :size="20" class="text-primary-600" />
              <div>
                <p class="text-sm text-gray-600">Rôle principal</p>
                <p class="font-semibold text-gray-900">{{ getRoleLabel(user.roles?.[0]?.name) }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- État du compte -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">État du compte</h2>

          <div class="space-y-3 text-sm">
            <div class="flex justify-between">
              <span class="text-gray-600">Statut</span>
              <span
                :class="[
                  'font-medium px-3 py-1 rounded-full text-xs',
                  user.is_active
                    ? 'bg-green-100 text-green-800'
                    : 'bg-red-100 text-red-800'
                ]"
              >
                {{ user.is_active ? 'Actif' : 'Inactif' }}
              </span>
            </div>
          </div>
        </div>

        <!-- Métadonnées -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <h2 class="text-lg font-bold text-gray-900 mb-6">Informations système</h2>

          <div class="space-y-3 text-sm">
            <div class="flex justify-between">
              <span class="text-gray-600">Date de création</span>
              <span class="font-medium text-gray-900">{{ new Date(user.created_at).toLocaleString('fr-FR') }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Dernière modification</span>
              <span class="font-medium text-gray-900">{{ new Date(user.updated_at).toLocaleString('fr-FR') }}</span>
            </div>
            <div v-if="user.email_verified_at" class="flex justify-between">
              <span class="text-gray-600">Email vérifié</span>
              <span class="font-medium text-green-600">{{ new Date(user.email_verified_at).toLocaleString('fr-FR') }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
