<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import {
  ArrowLeft, Activity, User, Calendar, Database,
  FileText, Code
} from 'lucide-vue-next'

const props = defineProps({
  activity: Object,
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  })
}
</script>

<template>
  <Head title="Détails activité - Admin" />

  <AdminLayout>
    <!-- Header -->
    <div class="mb-8">
      <Link
        :href="route('admin.activity-log.index')"
        class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-4"
      >
        <ArrowLeft :size="20" />
        Retour au journal
      </Link>
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Détails de l'activité #{{ activity.id }}</h1>
      <p class="text-gray-600">{{ formatDate(activity.created_at) }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Informations principales -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Description -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center gap-3 mb-4">
            <Activity :size="24" class="text-primary-600" />
            <h2 class="text-lg font-bold text-gray-900">Description de l'action</h2>
          </div>
          <div class="bg-primary-50 border-l-4 border-primary-600 p-4 rounded-r-lg">
            <p class="text-lg text-primary-900 font-semibold">{{ activity.description }}</p>
          </div>
        </div>

        <!-- Propriétés -->
        <div v-if="activity.properties && Object.keys(activity.properties).length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center gap-3 mb-4">
            <Code :size="24" class="text-primary-600" />
            <h2 class="text-lg font-bold text-gray-900">Propriétés</h2>
          </div>
          <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
            <pre class="text-sm text-green-400 font-mono">{{ JSON.stringify(activity.properties, null, 2) }}</pre>
          </div>
        </div>

        <!-- Entité affectée -->
        <div v-if="activity.subject" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
          <div class="flex items-center gap-3 mb-4">
            <Database :size="24" class="text-primary-600" />
            <h2 class="text-lg font-bold text-gray-900">Entité affectée</h2>
          </div>
          <div class="space-y-3">
            <div>
              <p class="text-sm text-gray-500 mb-1">Type</p>
              <p class="font-semibold text-gray-900">{{ activity.subject_type }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-500 mb-1">ID</p>
              <p class="font-semibold text-gray-900">{{ activity.subject_id }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="lg:col-span-1 space-y-6">
        <!-- Utilisateur -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
          <div class="flex items-center gap-3 mb-6">
            <User :size="24" class="text-primary-600" />
            <h2 class="text-lg font-bold text-gray-900">Utilisateur</h2>
          </div>

          <div v-if="activity.causer" class="flex items-center gap-3 mb-4">
            <img
              :src="activity.causer.photo_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(activity.causer.name)}`"
              :alt="activity.causer.name"
              class="w-12 h-12 rounded-full"
            />
            <div>
              <p class="font-semibold text-gray-900">{{ activity.causer.name }}</p>
              <p class="text-sm text-gray-600">{{ activity.causer.email }}</p>
            </div>
          </div>
          <div v-else class="text-gray-500">
            <p>Action système</p>
          </div>

          <!-- Métadonnées -->
          <div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
            <div>
              <p class="text-sm text-gray-500 mb-1">Date</p>
              <div class="flex items-center gap-2 text-sm text-gray-900">
                <Calendar :size="16" />
                {{ formatDate(activity.created_at) }}
              </div>
            </div>
            <div>
              <p class="text-sm text-gray-500 mb-1">Type de log</p>
              <p class="text-sm font-semibold text-gray-900">{{ activity.log_name || 'default' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
