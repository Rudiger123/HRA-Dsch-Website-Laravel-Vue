<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    type: {
        type: String,
        default: 'button',
    },
    variant: {
        type: String,
        default: 'primary', // primary, secondary, danger, outline
    },
    href: {
        type: String,
        default: null,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const classes = computed(() => {
    const baseClasses = 'inline-flex items-center justify-center px-4 py-2 rounded-lg font-semibold transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';

    const variantClasses = {
        primary: 'bg-primary-500 hover:bg-primary-600 text-white focus:ring-primary-500',
        secondary: 'bg-secondary-500 hover:bg-secondary-600 text-white focus:ring-secondary-500',
        danger: 'bg-danger-500 hover:bg-danger-600 text-white focus:ring-danger-500',
        outline: 'border-2 border-primary-500 text-primary-500 hover:bg-primary-50 focus:ring-primary-500',
    };

    const disabledClasses = 'opacity-50 cursor-not-allowed';

    return `${baseClasses} ${variantClasses[props.variant]} ${props.disabled ? disabledClasses : ''}`;
});
</script>

<template>
    <component
        :is="href ? Link : 'button'"
        :href="href"
        :type="!href ? type : undefined"
        :disabled="disabled"
        :class="classes"
    >
        <slot />
    </component>
</template>
