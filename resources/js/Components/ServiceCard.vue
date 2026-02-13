
<script setup>
import { Link } from '@inertiajs/vue3'
import {
    Baby, Heart, HeartPulse, Scissors,
    Ambulance, Stethoscope, FlaskConical, Scan
} from 'lucide-vue-next'

const props = defineProps({
    service: {
        type: Object,
        required: true
    }
})

// Mapping icons
const iconComponents = {
    'Baby': Baby,
    'Heart': Heart,
    'HeartPulse': HeartPulse,
    'Scissors': Scissors,
    'Ambulance': Ambulance,
    'Stethoscope': Stethoscope,
    'FlaskConical': FlaskConical,
    'Scan': Scan
}

const IconComponent = iconComponents[props.service.icon] || Stethoscope
</script>

<template>
    <Link
        :href="`/services/${service.slug}`"
        class="group relative bg-white rounded-xl shadow-md p-6 border-2 border-transparent hover:border-primary-500 transition-all duration-300 cursor-pointer overflow-hidden"
    >
        <!-- Effet de fond au hover -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

        <!-- Contenu -->
        <div class="relative z-10">
            <!-- Icon avec animation -->
            <div class="w-16 h-16 mx-auto mb-4 bg-primary-100 rounded-full flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                <component :is="IconComponent" class="w-8 h-8 text-primary-600" />
            </div>

            <!-- Nom -->
            <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center group-hover:text-primary-600 transition-colors">
                {{ service.nom }}
            </h3>

            <!-- Description -->
            <p class="text-gray-600 text-sm text-center mb-4 line-clamp-3">
                {{ service.description }}
            </p>

            <!-- Tarif avec animation -->
            <div class="text-center">
                <span class="inline-block bg-primary-100 text-primary-700 px-4 py-2 rounded-full text-sm font-medium group-hover:bg-primary-500 group-hover:text-white transition-all duration-300">
                    {{ service.tarif_consultation.toLocaleString() }} FCFA
                </span>
            </div>

            <!-- Flèche hover -->
            <div class="mt-4 text-center opacity-0 group-hover:opacity-100 transition-opacity">
                <svg class="w-6 h-6 mx-auto text-primary-600 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </Link>
</template>
