<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Alert from '@/Components/Alert.vue'
import { Phone, Mail, MapPin, Facebook, Twitter, Instagram } from 'lucide-vue-next'

// State
const showSuccess = ref(false)
const showError = ref(false)
const fieldErrors = ref({})

// Form
const form = useForm({
    nom: '',
    email: '',
    telephone: '',
    message: ''
})

// Validation
const validateEmail = (email) => {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (email && !regex.test(email)) {
        fieldErrors.value.email = 'Email invalide'
        return false
    }
    delete fieldErrors.value.email
    return true
}

const validateName = (name) => {
    if (name && name.length < 3) {
        fieldErrors.value.nom = 'Minimum 3 caractères'
        return false
    }
    delete fieldErrors.value.nom
    return true
}

const validateMessage = (message) => {
    if (message && message.length < 10) {
        fieldErrors.value.message = 'Minimum 10 caractères'
        return false
    }
    delete fieldErrors.value.message
    return true
}

// Form validity
const isFormValid = computed(() => {
    return (
        form.nom.trim().length >= 3 &&
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email) &&
        form.message.trim().length >= 10 &&
        Object.keys(fieldErrors.value).length === 0
    )
})

// Handle inputs
const handleNameInput = () => validateName(form.nom)
const handleEmailInput = () => validateEmail(form.email)
const handleMessageInput = () => validateMessage(form.message)

// Submit
const submit = () => {
    const isNameValid = validateName(form.nom)
    const isEmailValid = validateEmail(form.email)
    const isMessageValid = validateMessage(form.message)

    if (!isNameValid || !isEmailValid || !isMessageValid) {
        return
    }

    form.post('/api/contacts', {
        onSuccess: () => {
            showSuccess.value = true
            form.reset()
            fieldErrors.value = {}

            setTimeout(() => {
                showSuccess.value = false
            }, 5000)
        },
        onError: (errors) => {
            showError.value = true
            fieldErrors.value = errors

            setTimeout(() => {
                showError.value = false
            }, 5000)
        }
    })
}

// Contact data
const contacts = [
    {
        icon: 'phone',
        title: 'Standard',
        value: '+237 XXX XXX XXX',
        href: 'tel:+237XXXXXXXXX'
    },
    {
        icon: 'emergency',
        title: 'Urgences 24/7',
        value: '+237 XXX XXX XXX',
        href: 'tel:+237XXXXXXXXX',
        highlighted: true
    },
    {
        icon: 'mail',
        title: 'Email',
        value: 'contact@hrad.cm',
        href: 'mailto:contact@hrad.cm'
    },
    {
        icon: 'address',
        title: 'Adresse',
        value: 'Dschang, Région de l\'Ouest, Cameroun'
    }
]

const horaires = [
    { jour: 'Lundi', horaire: '8h00 - 17h00' },
    { jour: 'Mardi', horaire: '8h00 - 17h00' },
    { jour: 'Mercredi', horaire: '8h00 - 17h00' },
    { jour: 'Jeudi', horaire: '8h00 - 17h00' },
    { jour: 'Vendredi', horaire: '8h00 - 17h00' },
    { jour: 'Samedi', horaire: '8h00 - 12h00' },
    { jour: 'Dimanche', horaire: 'Fermé' }
]

const reseauxSociaux = [
    { name: 'Facebook', icon: Facebook, href: 'https://facebook.com', color: 'bg-blue-600' },
    { name: 'Twitter', icon: Twitter, href: 'https://twitter.com', color: 'bg-sky-500' },
    { name: 'Instagram', icon: Instagram, href: 'https://instagram.com', color: 'bg-pink-600' }
]
</script>

<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-primary-50 to-white py-12 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4 animate-fade-in">
                    Nous Contacter
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto animate-fade-in animation-delay-200">
                    Une question ? Une remarque ? N'hésitez pas à nous écrire.
                </p>
            </div>
        </section>

        <!-- Success/Error Alerts -->
        <transition name="slide-down">
            <Alert v-if="showSuccess" type="success" dismissible @close="showSuccess = false" class="sticky top-20 z-50 mx-4 mt-4">
                ✅ Message envoyé ! Nous vous répondrons dans les 24 heures.
            </Alert>
        </transition>

        <transition name="slide-down">
            <Alert v-if="showError" type="error" dismissible @close="showError = false" class="sticky top-20 z-50 mx-4 mt-4">
                ❌ Une erreur est survenue. Veuillez réessayer.
            </Alert>
        </transition>

        <!-- Main Content -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Colonne Gauche : Formulaire (60%) -->
                <div class="lg:col-span-2 animate-fade-in animation-delay-400">
                    <div class="bg-white rounded-xl shadow-xl p-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-8">Envoyez-nous un Message</h2>

                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Nom -->
                            <div>
                                <label for="nom" class="block font-medium text-gray-700 mb-2">
                                    Nom <span class="text-danger-600">*</span>
                                </label>
                                <input
                                    id="nom"
                                    v-model="form.nom"
                                    type="text"
                                    placeholder="Ex: Marie Kamga"
                                    @input="handleNameInput"
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all"
                                    :class="{ 'border-red-500': fieldErrors.nom }"
                                />
                                <p v-if="fieldErrors.nom" class="text-red-600 text-sm mt-1">
                                    {{ fieldErrors.nom }}
                                </p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block font-medium text-gray-700 mb-2">
                                    Email <span class="text-danger-600">*</span>
                                </label>
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    placeholder="Ex: marie@email.com"
                                    @input="handleEmailInput"
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all"
                                    :class="{ 'border-red-500': fieldErrors.email }"
                                />
                                <p v-if="fieldErrors.email" class="text-red-600 text-sm mt-1">
                                    {{ fieldErrors.email }}
                                </p>
                            </div>

                            <!-- Téléphone -->
                            <div>
                                <label for="telephone" class="block font-medium text-gray-700 mb-2">
                                    Téléphone <span class="text-gray-500 text-sm">(optionnel)</span>
                                </label>
                                <input
                                    id="telephone"
                                    v-model="form.telephone"
                                    type="tel"
                                    placeholder="+237 XXX XXX XXX"
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all"
                                />
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block font-medium text-gray-700 mb-2">
                                    Message <span class="text-danger-600">*</span>
                                </label>
                                <textarea
                                    id="message"
                                    v-model="form.message"
                                    rows="6"
                                    placeholder="Votre message..."
                                    maxlength="1000"
                                    @input="handleMessageInput"
                                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all resize-none"
                                    :class="{ 'border-red-500': fieldErrors.message }"
                                ></textarea>
                                <div class="flex items-center justify-between mt-2">
                                    <p v-if="fieldErrors.message" class="text-red-600 text-sm">
                                        {{ fieldErrors.message }}
                                    </p>
                                    <p class="text-gray-600 text-sm ml-auto">
                                        {{ form.message.length }}/1000
                                    </p>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button
                                @click="submit"
                                :disabled="!isFormValid || form.processing"
                                class="w-full bg-primary-500 hover:bg-primary-600 disabled:bg-gray-400 text-white font-semibold py-4 px-6 rounded-lg transition-all duration-300 flex items-center justify-center gap-2"
                            >
                                <span v-if="!form.processing">Envoyer le Message</span>
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
                </div>

                <!-- Colonne Droite : Infos (40%) -->
                <div class="lg:col-span-1 animate-fade-in animation-delay-600">
                    <!-- Section Contact Direct -->
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Contact Direct</h3>

                        <div class="space-y-4">
                            <!-- Standard -->
                            <a href="tel:+237XXXXXXXXX" class="flex items-start gap-4 hover:bg-primary-50 p-3 rounded-lg transition-colors">
                                <Phone class="w-6 h-6 text-primary-600 flex-shrink-0 mt-1" />
                                <div>
                                    <p class="font-medium text-gray-900">Standard</p>
                                    <p class="text-gray-600">+237 XXX XXX XXX</p>
                                </div>
                            </a>

                            <!-- Urgences -->
                            <a href="tel:+237XXXXXXXXX" class="flex items-start gap-4 hover:bg-danger-50 p-3 rounded-lg transition-colors border-l-4 border-danger-500">
                                <Phone class="w-6 h-6 text-danger-600 flex-shrink-0 mt-1" />
                                <div>
                                    <p class="font-medium text-danger-900">Urgences 24/7</p>
                                    <p class="text-danger-700 font-semibold">+237 XXX XXX XXX</p>
                                </div>
                            </a>

                            <!-- Email -->
                            <a href="mailto:contact@hrad.cm" class="flex items-start gap-4 hover:bg-primary-50 p-3 rounded-lg transition-colors">
                                <Mail class="w-6 h-6 text-primary-600 flex-shrink-0 mt-1" />
                                <div>
                                    <p class="font-medium text-gray-900">Email</p>
                                    <p class="text-gray-600">contact@hrad.cm</p>
                                </div>
                            </a>

                            <!-- Adresse -->
                            <a href="https://maps.google.com" target="_blank" class="flex items-start gap-4 hover:bg-primary-50 p-3 rounded-lg transition-colors">
                                <MapPin class="w-6 h-6 text-primary-600 flex-shrink-0 mt-1" />
                                <div>
                                    <p class="font-medium text-gray-900">Adresse</p>
                                    <p class="text-gray-600">Dschang, Région de l'Ouest, Cameroun</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Section Horaires -->
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Horaires</h3>

                        <div class="space-y-3">
                            <div v-for="(h, i) in horaires" :key="i" class="flex justify-between items-center py-2 border-b border-gray-200 last:border-0">
                                <span class="font-medium text-gray-700">{{ h.jour }}</span>
                                <span :class="[
                                    'text-sm font-semibold',
                                    h.horaire === 'Fermé' ? 'text-danger-600' : 'text-primary-600'
                                ]">
                                    {{ h.horaire }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Section Réseaux Sociaux -->
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Suivez-nous</h3>

                        <div class="flex gap-4">
                            <a
                                v-for="reseau in reseauxSociaux"
                                :key="reseau.name"
                                :href="reseau.href"
                                target="_blank"
                                :title="reseau.name"
                                :class="[reseau.color, 'w-12 h-12 rounded-full flex items-center justify-center text-white hover:scale-110 transition-transform duration-300']"
                            >
                                <component :is="reseau.icon" class="w-6 h-6" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Google Maps -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Localisation</h2>

            <div class="relative">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3974.0886626408647!2d10.031388!3d5.6411111!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x171c8f0ac5e5e5d7%3A0x0!2sHR%C3%89AD%20Dschang!5e0!3m2!1sfr!2scm!4v1234567890"
                    width="100%"
                    height="400"
                    style="border: 0; border-radius: 0.75rem;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
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

.animation-delay-600 {
    animation-delay: 0.6s;
}
</style>
