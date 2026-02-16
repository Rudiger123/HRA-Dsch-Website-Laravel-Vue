<script setup>
import { computed } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'
import {
  Users, Stethoscope, Newspaper, Calendar,
  Mail, TrendingUp, Clock, CheckCircle,
  AlertCircle, XCircle, ArrowUpRight
} from 'lucide-vue-next'

const props = defineProps({
  stats: Object,
  rdvAujourdhui: Array,
  derniers_messages: Array,
  rdvParMois: Object,
  servicesPopulaires: Array,
  activiteRecente: Array,
})

// Formater les nombres
const formatNumber = (num) => {
  return new Intl.NumberFormat('fr-FR').format(num)
}

// Formater les dates
const formatDate = (date) => {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Couleur du statut RDV
const getStatusColor = (statut) => {
  const colors = {
    'en_attente': 'bg-yellow-100 text-yellow-800',
    'confirme': 'bg-green-100 text-green-800',
    'annule': 'bg-red-100 text-red-800'
  }
  return colors[statut] || 'bg-gray-100 text-gray-800'
}

const getStatusLabel = (statut) => {
  const labels = {
    'en_attente': 'En attente',
    'confirme': 'Confirmé',
    'annule': 'Annulé'
  }
  return labels[statut] || statut
}
</script>

<template>
  <Head title="Dashboard - Admin" />
  
  <AdminLayout>
    <!-- Page Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
      <p class="text-gray-600">Bienvenue sur votre tableau de bord administratif</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <!-- Total Services -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
          <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
            <Stethoscope :size="24" class="text-primary-600" />
          </div>
          <TrendingUp :size="20" class="text-green-500" />
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ formatNumber(stats.total_services) }}</h3>
        <p class="text-sm text-gray-600">Services actifs</p>
      </div>

      <!-- Total Médecins -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
            <Users :size="24" class="text-blue-600" />
          </div>
          <TrendingUp :size="20" class="text-green-500" />
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ formatNumber(stats.total_medecins) }}</h3>
        <p class="text-sm text-gray-600">Médecins actifs</p>
      </div>

      <!-- Total Articles -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
          <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
            <Newspaper :size="24" class="text-purple-600" />
          </div>
          <TrendingUp :size="20" class="text-green-500" />
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ formatNumber(stats.total_articles) }}</h3>
        <p class="text-sm text-gray-600">Articles publiés</p>
      </div>

      <!-- RDV en attente (si permission) -->
      <div v-if="stats.rdv_en_attente !== undefined" class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
          <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
            <Clock :size="24" class="text-yellow-600" />
          </div>
          <AlertCircle :size="20" class="text-yellow-500" />
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ formatNumber(stats.rdv_en_attente) }}</h3>
        <p class="text-sm text-gray-600">RDV en attente</p>
      </div>
    </div>

    <!-- Stats RDV (si permission) -->
    <div v-if="stats.total_rdv !== undefined" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <CheckCircle :size="24" class="text-green-600" />
          </div>
          <div>
            <p class="text-2xl font-bold text-gray-900">{{ formatNumber(stats.rdv_confirmes) }}</p>
            <p class="text-sm text-gray-600">RDV confirmés</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
            <XCircle :size="24" class="text-red-600" />
          </div>
          <div>
            <p class="text-2xl font-bold text-gray-900">{{ formatNumber(stats.rdv_annules) }}</p>
            <p class="text-sm text-gray-600">RDV annulés</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
            <Calendar :size="24" class="text-blue-600" />
          </div>
          <div>
            <p class="text-2xl font-bold text-gray-900">{{ formatNumber(stats.total_rdv) }}</p>
            <p class="text-sm text-gray-600">Total RDV</p>
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- RDV du jour -->
      <div v-if="rdvAujourdhui && rdvAujourdhui.length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900">Rendez-vous du jour</h2>
            <a href="/" class="text-sm text-primary-600 hover:text-primary-700 flex items-center gap-1">
              Voir tout
              <ArrowUpRight :size="16" />
            </a>
          </div>
        </div>
        <div class="divide-y divide-gray-200">
          <div v-for="rdv in rdvAujourdhui.slice(0, 5)" :key="rdv.id" class="p-4 hover:bg-gray-50 transition">
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <p class="font-semibold text-gray-900">{{ rdv.nom_patient }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ rdv.service?.nom }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ rdv.telephone }}</p>
              </div>
              <span :class="['text-xs font-medium px-3 py-1 rounded-full', getStatusColor(rdv.statut)]">
                {{ getStatusLabel(rdv.statut) }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Derniers messages -->
      <div v-if="derniers_messages && derniers_messages.length > 0" class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900">Messages récents</h2>
            <a href="/" class="text-sm text-primary-600 hover:text-primary-700 flex items-center gap-1">
              Voir tout
              <ArrowUpRight :size="16" />
            </a>
          </div>
        </div>
        <div class="divide-y divide-gray-200">
          <a
            v-for="message in derniers_messages"
            :key="message.id"
            href="/"
            class="block p-4 hover:bg-gray-50 transition"
          >
            <div class="flex items-start gap-3">
              <div class="shrink-0">
                <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                  <Mail :size="20" class="text-primary-600" />
                </div>
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between mb-1">
                  <p class="font-semibold text-gray-900 truncate">{{ message.nom }}</p>
                  <span v-if="!message.lu" class="w-2 h-2 bg-primary-600 rounded-full"></span>
                </div>
                <p class="text-sm text-gray-600 line-clamp-2">{{ message.message }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ formatDate(message.created_at) }}</p>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>

    <!-- Services populaires (si permission) -->
    <div v-if="servicesPopulaires && servicesPopulaires.length > 0" class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
      <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-bold text-gray-900">Services les plus demandés</h2>
      </div>
      <div class="p-6">
        <div class="space-y-4">
          <div v-for="(item, index) in servicesPopulaires" :key="item.service_id" class="flex items-center gap-4">
            <div class="shrink-0 w-8 text-center">
              <span class="text-lg font-bold text-gray-400">#{{ index + 1 }}</span>
            </div>
            <div class="flex-1">
              <p class="font-semibold text-gray-900">{{ item.service?.nom }}</p>
              <div class="mt-2 bg-gray-200 rounded-full h-2 overflow-hidden">
                <div
                  class="bg-primary-600 h-full rounded-full transition-all duration-500"
                  :style="{ width: ((item.total / servicesPopulaires[0].total) * 100) + '%' }"
                />
              </div>
            </div>
            <div class="shrink-0">
              <span class="text-lg font-bold text-primary-600">{{ item.total }}</span>
              <span class="text-sm text-gray-500 ml-1">RDV</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Activité récente (si permission) -->
    <div v-if="activiteRecente && activiteRecente.length > 0" class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
      <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <h2 class="text-lg font-bold text-gray-900">Activité récente</h2>
          <a href="/" class="text-sm text-primary-600 hover:text-primary-700 flex items-center gap-1">
            Voir tout
            <ArrowUpRight :size="16" />
          </a>
        </div>
      </div>
      <div class="divide-y divide-gray-200">
        <div v-for="activity in activiteRecente.slice(0, 10)" :key="activity.id" class="p-4 hover:bg-gray-50 transition">
          <div class="flex items-start gap-3">
            <div class="shrink-0 mt-1">
              <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                <div class="w-2 h-2 bg-primary-600 rounded-full"></div>
              </div>
            </div>
            <div class="flex-1">
              <p class="text-sm text-gray-900">
                <span class="font-semibold">{{ activity.causer?.name || 'Système' }}</span>
                {{ activity.description }}
              </p>
              <p class="text-xs text-gray-500 mt-1">{{ formatDate(activity.created_at) }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
