<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { ChevronLeft, ChevronRight } from 'lucide-vue-next'

const props = defineProps({
  links: Array,
  meta: Object,
  perPageOptions: {
    type: Array,
    default: () => [7, 15, 25, 50]
  },
  currentPerPage: {
    type: Number,
    default: 7
  }
})

const emit = defineEmits(['perPageChange'])

const selectedPerPage = ref(props.currentPerPage || 7)

/**
 * Gérer le changement du nombre d'éléments par page
 */
const handlePerPageChange = () => {
  // Émettre un événement pour que le parent gère le changement
  emit('perPageChange', selectedPerPage.value)
}

/**
 * Déterminer si la pagination doit s'afficher
 */
const shouldShowPagination = computed(() => {
  return props.links && props.links.length >= 3 && props.meta?.total
})
</script>

<template>
  <div v-if="shouldShowPagination" class="flex flex-col gap-4">
    <!-- Première ligne : Info + Sélecteur par page -->
    <div class="flex items-center justify-between flex-wrap gap-4">
      <!-- Info -->
      <div class="text-sm text-slate-700">
        <span class="font-semibold">{{ meta?.from || 1 }}</span>
        à
        <span class="font-semibold">{{ meta?.to || 1 }}</span>
        sur
        <span class="font-semibold">{{ meta?.total || 0 }}</span>
        résultats
      </div>

      <!-- Sélecteur éléments par page -->
      <div class="flex items-center gap-3">
        <label class="text-sm font-medium text-slate-700">Afficher par page :</label>
        <select
          v-model.number="selectedPerPage"
          @change="handlePerPageChange"
          class="px-3 py-1.5 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:border-slate-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
        >
          <option v-for="option in perPageOptions" :key="option" :value="option">
            {{ option }}
          </option>
        </select>
      </div>
    </div>

    <!-- Deuxième ligne : Pagination buttons -->
    <div class="flex items-center justify-center gap-2 flex-wrap">
      <!-- Previous -->
      <Link
        v-if="links[0].url"
        :href="links[0].url"
        class="p-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition"
        preserve-state
      >
        <ChevronLeft :size="20" class="text-slate-600" />
      </Link>
      <span v-else class="p-2 border border-slate-200 rounded-lg opacity-50 cursor-not-allowed">
        <ChevronLeft :size="20" class="text-slate-400" />
      </span>

      <!-- Pages -->
      <template v-for="(link, index) in links.slice(1, -1)" :key="index">
        <Link
          v-if="link.url"
          :href="link.url"
          preserve-state
          :class="[
            'px-3.5 py-2 rounded-lg font-medium transition text-sm',
            link.active
              ? 'bg-primary-600 text-white shadow-md'
              : 'bg-white text-slate-700 border border-slate-300 hover:bg-slate-50 hover:border-slate-400'
          ]"
        >
          {{ link.label }}
        </Link>
        <span
          v-else
          class="px-3.5 py-2 rounded-lg font-medium bg-slate-100 text-slate-500 cursor-default text-sm"
        >
          {{ link.label }}
        </span>
      </template>

      <!-- Next -->
      <Link
        v-if="links[links.length - 1].url"
        :href="links[links.length - 1].url"
        class="p-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition"
        preserve-state
      >
        <ChevronRight :size="20" class="text-slate-600" />
      </Link>
      <span v-else class="p-2 border border-slate-200 rounded-lg opacity-50 cursor-not-allowed">
        <ChevronRight :size="20" class="text-slate-400" />
      </span>
    </div>
  </div>
</template>
