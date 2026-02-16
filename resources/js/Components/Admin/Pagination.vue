<script setup>
import { Link } from '@inertiajs/vue3'
import { ChevronLeft, ChevronRight } from 'lucide-vue-next'

defineProps({
  links: Array,
  meta: Object
})
</script>

<template>
  <div v-if="links && links.length > 3" class="flex items-center justify-between border-t border-gray-200 pt-4">
    <!-- Info -->
    <div class="text-sm text-gray-700">
      Affichage de <span class="font-semibold">{{ meta.from }}</span> à
      <span class="font-semibold">{{ meta.to }}</span> sur
      <span class="font-semibold">{{ meta.total }}</span> résultats
    </div>

    <!-- Pagination -->
    <div class="flex items-center gap-2">
      <!-- Previous -->
      <Link
        v-if="links[0].url"
        :href="links[0].url"
        class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition"
        preserve-state
      >
        <ChevronLeft :size="20" class="text-gray-600" />
      </Link>
      <span v-else class="p-2 border border-gray-200 rounded-lg opacity-50 cursor-not-allowed">
        <ChevronLeft :size="20" class="text-gray-400" />
      </span>

      <!-- Pages -->
      <template v-for="(link, index) in links.slice(1, -1)" :key="index">
        <Link
          v-if="link.url"
          :href="link.url"
          preserve-state
          :class="[
            'px-4 py-2 rounded-lg font-medium transition',
            link.active
              ? 'bg-blue-600 text-white'
              : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'
          ]"
        >
          {{ link.label }}
        </Link>
        <span
          v-else
          class="px-4 py-2 rounded-lg font-medium bg-gray-100 text-gray-500 cursor-default"
        >
          {{ link.label }}
        </span>
      </template>

      <!-- Next -->
      <Link
        v-if="links[links.length - 1].url"
        :href="links[links.length - 1].url"
        class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition"
        preserve-state
      >
        <ChevronRight :size="20" class="text-gray-600" />
      </Link>
      <span v-else class="p-2 border border-gray-200 rounded-lg opacity-50 cursor-not-allowed">
        <ChevronRight :size="20" class="text-gray-400" />
      </span>
    </div>
  </div>
</template>
