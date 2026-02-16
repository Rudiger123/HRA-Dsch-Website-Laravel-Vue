<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import { Search, X } from 'lucide-vue-next'

const props = defineProps({
  modelValue: String,
  placeholder: {
    type: String,
    default: 'Rechercher...'
  }
})

const emit = defineEmits(['update:modelValue'])

const search = ref(props.modelValue || '')

watch(search, (value) => {
  emit('update:modelValue', value)
})

const clearSearch = () => {
  search.value = ''
}
</script>

<template>
  <div class="relative">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
      <Search :size="20" class="text-gray-400" />
    </div>
    <input
      v-model="search"
      type="text"
      :placeholder="placeholder"
      class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
    />
    <button
      v-if="search"
      @click="clearSearch"
      type="button"
      class="absolute inset-y-0 right-0 pr-3 flex items-center"
    >
      <X :size="20" class="text-gray-400 hover:text-gray-600" />
    </button>
  </div>
</template>
