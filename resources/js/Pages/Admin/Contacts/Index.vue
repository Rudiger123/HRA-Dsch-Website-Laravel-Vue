<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import SearchBar from '@/Components/Admin/SearchBar.vue'
import AdvancedPagination from '@/Components/Admin/AdvancedPagination.vue'
import {
  Mail, MailOpen, Eye, Trash2,
  Clock, User, Phone
} from 'lucide-vue-next'

const props = defineProps({
  contacts: Object,
  stats: Object,
  filters: Object,
})

const search = ref(props.filters?.search || '')
const perPage = ref(props.filters?.per_page || 7)

// Recherche
let searchTimeout = null
const handleSearch = (value) => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    router.get(route('admin.contacts.index'),
      { search: value, per_page: perPage.value },
      { preserveState: true, replace: true }
    )
  }, 500)
}

// Filtre lu
const handleLuChange = (value) => {
  router.get(route('admin.contacts.index'), { lu: value, per_page: perPage.value }, { preserveState: true })
}

// Changement du nombre d'éléments par page
const handlePerPageChange = (newPerPage) => {
  perPage.value = newPerPage
  router.get(route('admin.contacts.index'), { per_page: newPerPage }, { preserveState: true })
}

// Format date
const formatDate = (date) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Toggle lu
const toggleLu = (contact) => {
  router.post(route('admin.contacts.toggle-lu', contact.id))
}
</script>

<template>
  <Head title="Messages - Admin" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Messages de contact</h1>
      <p class="text-gray-600">Gérez les messages reçus via le formulaire de contact</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-600">Total</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.total }}</p>
          </div>
          <Mail :size="32" class="text-gray-400" />
        </div>
      </div>
      <div class="bg-blue-50 rounded-lg border border-blue-200 p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-blue-700">Non lus</p>
            <p class="text-2xl font-bold text-blue-900">{{ stats.non_lus }}</p>
          </div>
          <Mail :size="32" class="text-blue-600" />
        </div>
      </div>
      <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-700">Lus</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.lus }}</p>
          </div>
          <MailOpen :size="32" class="text-gray-600" />
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
      <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
          <SearchBar
            v-model="search"
            placeholder="Rechercher par nom, email, message..."
            @update:modelValue="handleSearch"
          />
        </div>
        <select
          @change="handleLuChange($event.target.value)"
          class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
        >
          <option value="">Tous les messages</option>
          <option value="0">Non lus</option>
          <option value="1">Lus</option>
        </select>
      </div>
    </div>

    <!-- Liste messages -->
    <div class="space-y-3">
      <Link
        v-for="contact in contacts.data"
        :key="contact.id"
        :href="route('admin.contacts.show', contact.id)"
        :class="[
          'block bg-white rounded-xl shadow-sm border-2 hover:shadow-md transition',
          contact.lu ? 'border-gray-200' : 'border-primary-300 bg-primary-50'
        ]"
      >
        <div class="p-6">
          <div class="flex items-start gap-4">
            <!-- Avatar -->
            <div :class="[
              'w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0',
              contact.lu ? 'bg-gray-100' : 'bg-primary-100'
            ]">
              <component :is="contact.lu ? MailOpen : Mail" :size="24" :class="contact.lu ? 'text-gray-600' : 'text-primary-600'" />
            </div>

            <!-- Contenu -->
            <div class="flex-1 min-w-0">
              <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                  <h3 :class="['font-bold', contact.lu ? 'text-gray-900' : 'text-primary-900']">
                    {{ contact.nom }}
                  </h3>
                  <span v-if="!contact.lu" class="w-2 h-2 bg-primary-600 rounded-full"></span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                  <Clock :size="14" />
                  {{ formatDate(contact.created_at) }}
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-3 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                  <Mail :size="14" />
                  <span class="truncate">{{ contact.email }}</span>
                </div>
                <div class="flex items-center gap-2">
                  <Phone :size="14" />
                  <span>{{ contact.telephone || 'Non renseigné' }}</span>
                </div>
              </div>

              <p :class="['text-sm line-clamp-2', contact.lu ? 'text-gray-600' : 'text-gray-900 font-medium']">
                {{ contact.message }}
              </p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col gap-2">
              <button
                @click.prevent="toggleLu(contact)"
                class="p-2 hover:bg-gray-100 rounded-lg transition"
                :title="contact.lu ? 'Marquer comme non lu' : 'Marquer comme lu'"
              >
                <component :is="contact.lu ? Mail : MailOpen" :size="20" class="text-gray-600" />
              </button>
            </div>
          </div>
        </div>
      </Link>

      <!-- Empty state -->
      <div v-if="contacts.data.length === 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <Mail :size="48" class="text-gray-300 mx-auto mb-4" />
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun message</h3>
        <p class="text-gray-600">Aucun message ne correspond à vos critères.</p>
      </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <AdvancedPagination :links="contacts.links" :meta="contacts.meta" :current-per-page="perPage" @per-page-change="handlePerPageChange" />
    </div>
  </AdminLayout>
</template>
