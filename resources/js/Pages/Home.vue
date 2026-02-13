<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/Button.vue';
import ServiceCard from '@/Components/ServiceCard.vue';
import Alert from '@/Components/Alert.vue';
</script>

<template>
    <AppLayout>
        <!-- Hero Section -->
        <div class="bg-primary-600 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-5xl font-bold mb-4 text-white">
                    HRAD - Setup Réussi ✅
                </h1>
                <p class="text-xl mb-8 text-primary-100">
                    Hôpital Régional Annexe de Dschang
                </p>
                <p class="text-lg text-primary-50 mb-8">
                    Laravel 11 + Inertia.js + Vue 3 + Tailwind CSS v4
                </p>
                <div class="flex gap-4 justify-center">
                    <Button variant="secondary" href="/services">
                        Nos Services
                    </Button>
                    <Button variant="outline" class="bg-white text-primary-600 hover:bg-primary-50">
                        Prendre Rendez-vous
                    </Button>
                </div>
            </div>
        </div>

        <!-- Alert de test -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <Alert type="success" :dismissible="true">
                <strong>Succès !</strong> Votre stack technique est opérationnelle.
            </Alert>
        </div>

        <!-- Services Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-3xl font-bold text-center mb-12 text-primary-700">
                Nos Services Principaux
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <ServiceCard
                    title="Consultations"
                    description="Consultations médicales générales et spécialisées avec nos médecins experts."
                    icon="👨‍⚕️"
                />

                <ServiceCard
                    title="Urgences 24/7"
                    description="Service d'urgences disponible 24h/24 et 7j/7 pour vos besoins médicaux urgents."
                    icon="🚑"
                />

                <ServiceCard
                    title="Laboratoire"
                    description="Analyses médicales complètes avec résultats rapides et fiables."
                    icon="🔬"
                />
            </div>
        </div>

        <!-- Test des boutons -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white rounded-lg shadow-md mb-12">
            <h3 class="text-2xl font-semibold mb-6 text-gray-800">Test des Composants</h3>

            <div class="space-y-4">
                <div class="flex gap-4 flex-wrap">
                    <Button variant="primary">Bouton Primary</Button>
                    <Button variant="secondary">Bouton Secondary</Button>
                    <Button variant="danger">Bouton Danger</Button>
                    <Button variant="outline">Bouton Outline</Button>
                </div>

                <Alert type="info">
                    <strong>Info :</strong> Tous les composants fonctionnent correctement !
                </Alert>

                <Alert type="warning">
                    <strong>Attention :</strong> Pensez à configurer votre base de données.
                </Alert>

                <Alert type="error">
                    <strong>Erreur :</strong> Ceci est un message d'erreur de test.
                </Alert>
            </div>
        </div>
    </AppLayout>
</template>
