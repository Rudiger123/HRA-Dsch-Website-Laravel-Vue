<script setup>
import { XCircle } from 'lucide-vue-next'

defineProps({
  show: Boolean,
  title: String,
  message: String,
  confirmText: {
    type: String,
    default: 'Confirmer'
  },
  cancelText: {
    type: String,
    default: 'Annuler'
  },
  type: {
    type: String,
    default: 'danger' // danger, warning, info
  }
})

const emit = defineEmits(['confirm', 'cancel'])
</script>

<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
          <!-- Overlay -->
          <div
            @click="emit('cancel')"
            class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
          />

          <!-- Modal -->
          <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full p-6 z-10">
            <!-- Icon -->
            <div :class="[
              'w-12 h-12 rounded-full flex items-center justify-center mb-4',
              type === 'danger' ? 'bg-red-100' : type === 'warning' ? 'bg-yellow-100' : 'bg-blue-100'
            ]">
              <XCircle :size="24" :class="[
                type === 'danger' ? 'text-red-600' : type === 'warning' ? 'text-yellow-600' : 'text-blue-600'
              ]" />
            </div>

            <!-- Title -->
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ title }}</h3>

            <!-- Message -->
            <p class="text-gray-600 mb-6">{{ message }}</p>

            <!-- Actions -->
            <div class="flex gap-3">
              <button
                @click="emit('cancel')"
                type="button"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition"
              >
                {{ cancelText }}
              </button>
              <button
                @click="emit('confirm')"
                type="button"
                :class="[
                  'flex-1 px-4 py-2 rounded-lg font-medium transition',
                  type === 'danger'
                    ? 'bg-red-600 text-white hover:bg-red-700'
                    : type === 'warning'
                    ? 'bg-yellow-600 text-white hover:bg-yellow-700'
                    : 'bg-blue-600 text-white hover:bg-blue-700'
                ]"
              >
                {{ confirmText }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>
