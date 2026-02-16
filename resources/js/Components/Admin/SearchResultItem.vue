<script setup>
import { computed } from 'vue'
import { Hospital, Stethoscope, Newspaper, Calendar, User, Tag } from 'lucide-vue-next'

const props = defineProps({
  item: {
    type: Object,
    required: true
  },
  isSelected: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['select'])

/**
 * Déterminer l'icône selon le type de résultat
 */
const getIcon = computed(() => {
  const iconMap = {
    service: Hospital,
    medecin: Stethoscope,
    actualite: Newspaper,
    rdv: Calendar,
    user: User,
    default: Tag
  }
  return iconMap[props.item.type] || iconMap.default
})

/**
 * Déterminer la couleur de l'icône selon le type
 */
const getIconColor = computed(() => {
  const colorMap = {
    service: 'text-blue-600',
    medecin: 'text-emerald-600',
    actualite: 'text-purple-600',
    rdv: 'text-amber-600',
    user: 'text-indigo-600'
  }
  return colorMap[props.item.type] || 'text-slate-600'
})

/**
 * Déterminer la couleur de background selon le type
 */
const getBackgroundColor = computed(() => {
  const colorMap = {
    service: 'bg-blue-50 group-hover:bg-blue-100',
    medecin: 'bg-emerald-50 group-hover:bg-emerald-100',
    actualite: 'bg-purple-50 group-hover:bg-purple-100',
    rdv: 'bg-amber-50 group-hover:bg-amber-100',
    user: 'bg-indigo-50 group-hover:bg-indigo-100'
  }
  return colorMap[props.item.type] || 'bg-slate-50 group-hover:bg-slate-100'
})

/**
 * Déterminer le label du type
 */
const getTypeLabel = computed(() => {
  const labelMap = {
    service: 'Service',
    medecin: 'Médecin',
    actualite: 'Actualité',
    rdv: 'Rendez-vous',
    user: 'Utilisateur'
  }
  return labelMap[props.item.type] || 'Résultat'
})
</script>

<template>
  <button
    @click="$emit('select', item)"
    :class="[
      'group w-full flex items-start gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 text-left',
      isSelected
        ? 'bg-primary-100 border border-primary-200'
        : 'hover:bg-slate-50 border border-transparent'
    ]"
  >
    <!-- Icon -->
    <div :class="[
      'shrink-0 w-9 h-9 rounded-lg flex items-center justify-center transition-all duration-150',
      getBackgroundColor
    ]">
      <component :is="getIcon" :size="18" :class="getIconColor" />
    </div>

    <!-- Content -->
    <div class="flex-1 min-w-0">
      <!-- Title + Badge -->
      <div class="flex items-center gap-2 mb-1">
        <h4 class="text-sm font-semibold text-slate-900 truncate">
          {{ item.title }}
        </h4>
        <span :class="[
          'shrink-0 text-xs font-medium px-2 py-0.5 rounded-full',
          isSelected
            ? 'bg-primary-200 text-primary-700'
            : 'bg-slate-100 text-slate-600 group-hover:bg-slate-200'
        ]">
          {{ getTypeLabel }}
        </span>
      </div>

      <!-- Subtitle -->
      <p v-if="item.subtitle" class="text-xs text-slate-500 truncate">
        {{ item.subtitle }}
      </p>
    </div>

    <!-- Arrow -->
    <div class="shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
      <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </div>
  </button>
</template>
