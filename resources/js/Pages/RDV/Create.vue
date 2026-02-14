<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Alert from '@/Components/Alert.vue'
import Button from '@/Components/Button.vue'
import { Calendar, Phone, AlertCircle } from 'lucide-vue-next'

// Props
const props = defineProps({
    services: {
        type: Array,
        default: () => []
    }
})

// State
const showSuccess = ref(false)
const showError = ref(false)
const fieldErrors = ref({})
const successMessage = ref('')

// Form helper
const form = useForm({
    nom_patient: '',
    age: null,
    telephone: '',
    service_id: '',
    motif: '',
    confirmation_whatsapp: true
})

// Validation rules
const phoneRegex = /^\+237[0-9]{9}$/

// Validate phone format
const validatePhone = (phone) => {
    if (!phone) {
        delete fieldErrors.value.telephone
        return true
    }

    if (!phoneRegex.test(phone)) {
        fieldErrors.value.telephone = 'Format invalide. Ex: +237677123456'
        return false
    }

    delete fieldErrors.value.telephone
    return true
}

// Validate name
const validateName = (name) => {
    if (name && name.length < 3) {
        fieldErrors.value.nom_patient = 'Minimum 3 caractères'
        return false
    }
    delete fieldErrors.value.nom_patient
    return true
}

// Validate age
const validateAge = (age) => {
    if (age !== null && age !== '') {
        const ageNum = parseInt(age)
        if (isNaN(ageNum) || ageNum < 0 || ageNum > 120) {
            fieldErrors.value.age = 'Âge invalide (0-120)'
            return false
        }
    }
    delete fieldErrors.value.age
    return true
}

// Validate service
const validateService = (serviceId) => {
    if (!serviceId) {
        fieldErrors.value.service_id = 'Sélectionnez un service'
        return false
    }
    delete fieldErrors.value.service_id
    return true
}

// Check form validity
const isFormValid = computed(() => {
    return (
        form.nom_patient.trim().length >= 3 &&
        phoneRegex.test(form.telephone) &&
        form.service_id !== '' &&
        Object.keys(fieldErrors.value).length === 0
    )
})

// Handle input events
const handlePhoneInput = () => {
    validatePhone(form.telephone)
}

const handleNameInput = () => {
    validateName(form.nom_patient)
}

const handleAgeInput = () => {
    validateAge(form.age)
}

const handleServiceChange = () => {
    validateService(form.service_id)
}

// Format phone input
const formatPhoneInput = (event) => {
    let value = event.target.value.replace(/\D/g, '')

    if (value.startsWith('237')) {
        value = '+237' + value.substring(3)
    } else if (value) {
        value = '+237' + value
    }

    form.telephone = value.slice(0, 13)
}

// Submit form
const submit = () => {
    // Final validation
    const isNameValid = validateName(form.nom_patient)
    const isPhoneValid = validatePhone(form.telephone)
    const isServiceValid = validateService(form.service_id)
    const isAgeValid = validateAge(form.age)

    if (!isNameValid || !isPhoneValid || !isServiceValid || !isAgeValid) {
        return
    }

    form.post('/api/rdv-requests', {
        onSuccess: () => {
            successMessage.value = `✅ Demande envoyée avec succès ! Nous vous rappelons sous 2 heures au ${form.telephone}.`
            showSuccess.value = true
            form.reset()
            fieldErrors.value = {}

            // Auto-dismiss après 5 secondes
            setTimeout(() => {
                showSuccess.value = false
            }, 5000)
        },
        onError: (errors) => {
            showError.value = true
            fieldErrors.value = errors

            // Auto-dismiss après 5 secondes
            setTimeout(() => {
                showError.value = false
            }, 5000)
        }
    })
}

// Format phone for display
const formatPhoneDisplay = (phone) => {
    return phone
        .replace(/^(\+237)(\d{2})(\d{2})(\d{2})(\d{2})$/, '$1 $2 $3 $4 $5')
}
</script>

<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-primary-50 to-white py-16 border-b border-gray-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Icon -->
                <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <Calendar class="w-12 h-12 text-primary-600" />
                </div>

                <!-- Titre -->
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4 animate-fade-in">
                    Prendre Rendez-vous
                </h1>

                <!-- Sous-titre -->
                <p class="text-xl text-gray-600 animate-fade-in animation-delay-200">
                    Remplissez le formulaire, nous vous rappelons sous 2 heures
                </p>
            </div>
        </section>

        <!-- Success Alert -->
        <transition name="slide-down">
            <Alert v-if="showSuccess" type="success" dismissible @close="showSuccess = false" class="sticky top-20 z-50 mx-4 mt-4">
                {{ successMessage }}
            </Alert>
        </transition>

        <!-- Error Alert -->
        <transition name="slide-down">
            <Alert v-if="showError" type="error" dismissible @close="showError = false" class="sticky top-20 z-50 mx-4 mt-4">
                ❌ Une erreur est survenue. Veuillez réessayer.
            </Alert>
        </transition>

        <!-- Formulaire -->
        <section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="bg-white rounded-xl shadow-xl p-8 animate-fade-in animation-delay-400">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Nom Complet -->
                    <div>
                        <label for="nom" class="block font-medium text-gray-700 mb-2">
                            Votre nom complet <span class="text-danger-600">*</span>
                        </label>
                        <input
                            id="nom"
                            v-model="form.nom_patient"
                            type="text"
                            placeholder="Ex: Marie Kamga"
                            @input="handleNameInput"
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all"
                            :class="{ 'border-red-500': fieldErrors.nom_patient }"
                        />
                        <p v-if="fieldErrors.nom_patient" class="text-red-600 text-sm mt-1">
                            {{ fieldErrors.nom_patient }}
                        </p>
                    </div>

                    <!-- Âge -->
                    <div>
                        <label for="age" class="block font-medium text-gray-700 mb-2">
                            Âge du patient <span class="text-gray-500 text-sm">(optionnel)</span>
                        </label>
                        <input
                            id="age"
                            v-model="form.age"
                            type="number"
                            min="0"
                            max="120"
                            placeholder="Ex: 34"
                            @input="handleAgeInput"
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all"
                            :class="{ 'border-red-500': fieldErrors.age }"
                        />
                        <p v-if="fieldErrors.age" class="text-red-600 text-sm mt-1">
                            {{ fieldErrors.age }}
                        </p>
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="telephone" class="block font-medium text-gray-700 mb-2">
                            Numéro de téléphone <span class="text-danger-600">*</span>
                        </label>
                        <input
                            id="telephone"
                            v-model="form.telephone"
                            type="tel"
                            placeholder="+237 XXX XXX XXX"
                            @input="formatPhoneInput"
                            @blur="validatePhone(form.telephone)"
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all"
                            :class="{ 'border-red-500': fieldErrors.telephone }"
                        />
                        <p v-if="fieldErrors.telephone" class="text-red-600 text-sm mt-1 flex items-center gap-1">
                            <AlertCircle class="w-4 h-4" />
                            {{ fieldErrors.telephone }}
                        </p>
                        <p v-else class="text-gray-600 text-sm mt-1">
                            Format : +237 suivi de 9 chiffres
                        </p>
                    </div>

                    <!-- Service Médical -->
                    <div>
                        <label for="service" class="block font-medium text-gray-700 mb-2">
                            Service souhaité <span class="text-danger-600">*</span>
                        </label>
                        <select
                            id="service"
                            v-model="form.service_id"
                            @change="handleServiceChange"
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all appearance-none bg-white cursor-pointer"
                            :class="{ 'border-red-500': fieldErrors.service_id }"
                        >
                            <option value="">Sélectionnez un service...</option>
                            <option v-for="service in services" :key="service.id" :value="service.id">
                                {{ service.nom }}
                            </option>
                        </select>
                        <p v-if="fieldErrors.service_id" class="text-red-600 text-sm mt-1">
                            {{ fieldErrors.service_id }}
                        </p>
                    </div>

                    <!-- Motif de consultation -->
                    <div>
                        <label for="motif" class="block font-medium text-gray-700 mb-2">
                            Motif de consultation <span class="text-gray-500 text-sm">(optionnel)</span>
                        </label>
                        <textarea
                            id="motif"
                            v-model="form.motif"
                            rows="4"
                            placeholder="Décrivez brièvement votre besoin..."
                            maxlength="500"
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all resize-none"
                        ></textarea>
                        <p class="text-gray-600 text-sm mt-1">
                            {{ form.motif.length }}/500 caractères
                        </p>
                    </div>

                    <!-- Confirmation WhatsApp -->
                    <div class="flex items-center gap-3 bg-primary-50 p-4 rounded-lg border border-primary-200">
                        <input
                            id="whatsapp"
                            v-model="form.confirmation_whatsapp"
                            type="checkbox"
                            class="w-5 h-5 text-primary-600 rounded cursor-pointer"
                        />
                        <label for="whatsapp" class="cursor-pointer text-gray-800 flex-1">
                            <span class="font-medium">☑️ Recevoir confirmation par WhatsApp</span>
                            <p class="text-sm text-gray-600 mt-1">Vous recevrez une notification WhatsApp dès que nous confirmons votre RDV</p>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button
                        @click="submit"
                        :disabled="!isFormValid || form.processing"
                        class="w-full bg-primary-500 hover:bg-primary-600 disabled:bg-gray-400 text-white font-semibold py-4 px-6 rounded-lg transition-all duration-300 flex items-center justify-center gap-2"
                    >
                        <span v-if="!form.processing">Envoyer ma demande</span>
                        <span v-else class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Envoi en cours...
                        </span>
                    </button>
                </form>
            </div>
        </section>

        <!-- Informations Utiles -->
        <section class="bg-gray-50 py-16 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Informations Utiles</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Délai de réponse -->
                    <div class="bg-white rounded-lg p-8 shadow-md border-l-4 border-primary-500">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">⏱️ Délai de Réponse</h3>
                        <p class="text-gray-600">
                            Rappel sous <span class="font-bold text-primary-600">2 heures</span> en semaine, <span class="font-bold">4 heures</span> le week-end.
                        </p>
                    </div>

                    <!-- Horaires RDV -->
                    <div class="bg-white rounded-lg p-8 shadow-md border-l-4 border-secondary-500">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">🕐 Horaires de RDV</h3>
                        <p class="text-gray-600">
                            <span class="font-bold">Lun-Ven :</span> 8h - 17h<br />
                            <span class="font-bold">Samedi :</span> 8h - 12h<br />
                            <span class="font-bold">Dimanche :</span> Fermé
                        </p>
                    </div>

                    <!-- Urgences -->
                    <div class="bg-danger-50 rounded-lg p-8 shadow-md border-l-4 border-danger-500">
                        <h3 class="text-xl font-semibold text-danger-900 mb-3">🚑 Urgences</h3>
                        <p class="text-danger-800">
                            Pour les <span class="font-bold">urgences</span>, appelez directement :<br />
                            <a href="tel:+237XXXXXXXXX" class="font-bold text-danger-600 hover:text-danger-700">
                                +237 XXX XXX XXX
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
    transition: all 0.3s ease;
}

.slide-down-enter-from {
    transform: translateY(-2rem);
    opacity: 0;
}

.slide-down-leave-to {
    transform: translateY(-2rem);
    opacity: 0;
}

@keyframes fade-in {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.animate-fade-in {
    animation: fade-in 0.5s ease-out forwards;
    opacity: 0;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}
</style>
