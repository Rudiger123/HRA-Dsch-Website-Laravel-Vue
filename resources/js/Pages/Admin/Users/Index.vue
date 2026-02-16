<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import SearchBar from '@/Components/Admin/SearchBar.vue'
import Pagination from '@/Components/Admin/Pagination.vue'
import ConfirmModal from '@/Components/Admin/ConfirmModal.vue'
import {
  Plus, Edit, Trash2, Eye, CheckCircle, XCircle,
  Users as UsersIcon, Shield, RefreshCw, Key
} from 'lucide-vue-next'

const props = defineProps({
  users: Object,
  roles: Array,
  filters: Object,
})

const search = ref(props.filters?.search || '')
const showDeleteModal = ref(false)
const showResetPasswordModal = ref(false)
const userToDelete = ref(null)
const userToResetPassword = ref(null)

// Recherche
let searchTimeout = null
const handleSearch = (value) => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    router.get(route('admin.users.index'),
      { search: value },
      { preserveState: true, replace: true }
    )
  }, 500)
}

// Suppression
const confirmDelete = (user) => {
  userToDelete.value = user
  showDeleteModal.value = true
}

const deleteUser = () => {
  if (userToDelete.value) {
    router.delete(route('admin.users.destroy', userToDelete.value.id), {
      onSuccess: () => {
        showDeleteModal.value = false
        userToDelete.value = null
      }
    })
  }
}

// Reset password
const confirmResetPassword = (user) => {
  userToResetPassword.value = user
  showResetPasswordModal.value = true
}

const resetPassword = () => {
  if (userToResetPassword.value) {
    router.post(route('admin.users.reset-password', userToResetPassword.value.id), {}, {
      onSuccess: () => {
        showResetPasswordModal.value = false
        userToResetPassword.value = null
      }
    })
  }
}

// Toggle actif
const toggleActive = (user) => {
  router.post(route('admin.users.toggle-active', user.id))
}

// Badge rôle couleurs
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
</script>

<template>
  <Head title="Utilisateurs - Admin" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Utilisateurs</h1>
          <p class="text-gray-600">Gérez les utilisateurs et leurs rôles</p>
        </div>
        <Link
          :href="route('admin.users.create')"
          class="flex items-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition"
        >
          <Plus :size="20" />
          Nouvel utilisateur
        </Link>
      </div>

      <!-- Filters -->
      <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
          <SearchBar
            v-model="search"
            placeholder="Rechercher un utilisateur..."
            @update:modelValue="handleSearch"
          />
        </div>
        <select
          @change="router.get(route('admin.users.index'), { role: $event.target.value })"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
        >
          <option value="">Tous les rôles</option>
          <option v-for="role in roles" :key="role.id" :value="role.name">
            {{ getRoleLabel(role.name) }}
          </option>
        </select>
        <select
          @change="router.get(route('admin.users.index'), { is_active: $event.target.value })"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
        >
          <option value="">Tous les statuts</option>
          <option value="1">Actifs</option>
          <option value="0">Inactifs</option>
        </select>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                Utilisateur
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                Email
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                Téléphone
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                Rôle
              </th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">
                Statut
              </th>
              <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <img
                    v-if="user.photo_url"
                    :src="user.photo_url"
                    :alt="user.name"
                    class="w-10 h-10 rounded-full mr-3 object-cover"
                  />
                  <div v-else class="w-10 h-10 rounded-full mr-3 bg-gray-300 flex items-center justify-center">
                    <span class="text-xs font-bold text-gray-600">{{ user.name.charAt(0).toUpperCase() }}</span>
                  </div>
                  <div>
                    <p class="font-semibold text-gray-900">{{ user.name }}</p>
                    <p class="text-xs text-gray-500">ID: {{ user.id }}</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                {{ user.email }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                {{ user.phone || '-' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span
                  :class="[
                    'inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium',
                    getRoleBadgeColor(user.roles?.[0]?.name)
                  ]"
                >
                  <Shield :size="12" />
                  {{ getRoleLabel(user.roles?.[0]?.name) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <button
                  @click="toggleActive(user)"
                  :class="[
                    'inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium transition',
                    user.is_active
                      ? 'bg-green-100 text-green-800 hover:bg-green-200'
                      : 'bg-red-100 text-red-800 hover:bg-red-200'
                  ]"
                >
                  <CheckCircle v-if="user.is_active" :size="14" />
                  <XCircle v-else :size="14" />
                  {{ user.is_active ? 'Actif' : 'Inactif' }}
                </button>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right">
                <div class="flex items-center justify-end gap-2">
                  <Link
                    :href="route('admin.users.show', user.id)"
                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                    title="Voir"
                  >
                    <Eye :size="18" />
                  </Link>
                  <Link
                    :href="route('admin.users.edit', user.id)"
                    class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition"
                    title="Modifier"
                  >
                    <Edit :size="18" />
                  </Link>
                  <button
                    @click="confirmResetPassword(user)"
                    class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                    title="Réinitialiser mot de passe"
                  >
                    <Key :size="18" />
                  </button>
                  <button
                    @click="confirmDelete(user)"
                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                    title="Supprimer"
                  >
                    <Trash2 :size="18" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <Pagination :links="users.links" :meta="users.meta" />
      </div>
    </div>

    <!-- Modal suppression -->
    <ConfirmModal
      :show="showDeleteModal"
      title="Supprimer cet utilisateur ?"
      :message="`Êtes-vous sûr de vouloir supprimer ${userToDelete?.name} ? Cette action est irréversible.`"
      confirm-text="Supprimer"
      type="danger"
      @confirm="deleteUser"
      @cancel="showDeleteModal = false"
    />

    <!-- Modal reset password -->
    <ConfirmModal
      :show="showResetPasswordModal"
      title="Réinitialiser le mot de passe ?"
      :message="`Un nouveau mot de passe sera généré et envoyé par email à ${userToResetPassword?.email}.`"
      confirm-text="Réinitialiser"
      type="warning"
      @confirm="resetPassword"
      @cancel="showResetPasswordModal = false"
    />
  </AdminLayout>
</template>
