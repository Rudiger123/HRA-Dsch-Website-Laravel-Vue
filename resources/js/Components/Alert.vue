<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'info', // success, error, warning, info
    },
    dismissible: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const alertClasses = computed(() => {
    const classes = {
        success: 'bg-secondary-50 border-secondary-500 text-secondary-800',
        error: 'bg-danger-50 border-danger-500 text-danger-800',
        warning: 'bg-yellow-50 border-yellow-500 text-yellow-800',
        info: 'bg-primary-50 border-primary-500 text-primary-800',
    };
    return classes[props.type] || classes.info;
});
</script>

<template>
    <div :class="['border-l-4 p-4 rounded-lg', alertClasses]" role="alert">
        <div class="flex items-start">
            <div class="flex-1">
                <slot />
            </div>
            <button
                v-if="dismissible"
                @click="emit('close')"
                class="ml-3 text-gray-400 hover:text-gray-600"
            >
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</template>
