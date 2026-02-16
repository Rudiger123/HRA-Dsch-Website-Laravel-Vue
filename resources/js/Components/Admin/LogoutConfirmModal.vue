<script setup>
import { router } from '@inertiajs/vue3'
import { AlertCircle } from 'lucide-vue-next'

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['close'])

// Helper route function
const route = (routeName, params = {}) => {
  if (typeof window.route === 'function') {
    return window.route(routeName, params)
  }
  return '/'
}

const handleLogout = () => {
  router.post(route('logout'))
}

const handleCancel = () => {
  emit('close')
}
</script>

<template>
  <Teleport to="body">
    <!-- Backdrop -->
    <Transition name="fade">
      <div
        v-if="isOpen"
        class="fixed inset-0 bg-black/50 z-40 transition-opacity"
        @click="handleCancel"
      />
    </Transition>

    <!-- Modal -->
    <Transition name="modal">
      <div
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
      >
        <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full transform transition-all">
          <!-- Header with icon -->
          <div class="bg-gradient-to-r from-red-50 to-red-100 px-6 py-6 border-b border-red-200">
            <div class="flex items-center gap-3">
              <div class="flex-shrink-0">
                <AlertCircle class="h-6 w-6 text-red-600" />
              </div>
              <h3 class="text-lg font-bold text-gray-900">Déconnexion</h3>
            </div>
          </div>

          <!-- Content -->
          <div class="px-6 py-6">
            <p class="text-gray-600 text-center">
              Êtes-vous sûr de vouloir vous déconnecter ?
            </p>
          </div>

          <!-- Actions -->
          <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl flex gap-3">
            <!-- Cancel button -->
            <button
              @click="handleCancel"
              class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition"
            >
              Annuler
            </button>

            <!-- Logout button -->
            <button
              @click="handleLogout"
              class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition"
            >
              Déconnecter
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>
