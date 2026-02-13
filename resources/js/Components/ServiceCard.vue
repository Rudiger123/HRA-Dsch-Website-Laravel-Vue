<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
        default: '🏥',
    },
});
</script>

<template>
    <div class="card hover:shadow-lg transition-shadow duration-200">
        <div class="text-4xl mb-4">{{ icon }}</div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ title }}</h3>
        <p class="text-gray-600">{{ description }}</p>
    </div>
</template>
