<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const mobileMenuOpen = ref(false);

const navigation = [
	{ name: 'Accueil', href: '/', current: true },
	{ name: 'Services', href: '/services', current: false },
	{ name: 'Rendez-vous', href: '/rdv', current: false },
	{ name: 'Contact', href: '/contact', current: false },
];
</script>

<template>
	<div class="min-h-screen bg-gray-50">
		<!-- Header / Navigation -->
		<nav class="bg-white shadow-sm">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex justify-between h-16">
					<!-- Logo -->
					<div class="flex items-center">
						<Link href="/" class="flex items-center">
							<span class="text-2xl font-bold text-primary-600">HRAD</span>
							<span class="ml-2 text-gray-600">Dschang</span>
						</Link>
					</div>

					<!-- Navigation Desktop -->
					<div class="hidden md:flex md:items-center md:space-x-8">
						<Link
							v-for="item in navigation"
							:key="item.name"
							:href="item.href"
							:class="[
								'text-gray-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors',
							]"
						>
							{{ item.name }}
						</Link>
					</div>

					<!-- Bouton Menu Mobile -->
					<div class="flex items-center md:hidden">
						<button
							@click="mobileMenuOpen = !mobileMenuOpen"
							class="text-gray-700 hover:text-primary-600"
						>
							<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
							</svg>
						</button>
					</div>
				</div>
			</div>

			<!-- Menu Mobile -->
			<div v-show="mobileMenuOpen" class="md:hidden">
				<div class="px-2 pt-2 pb-3 space-y-1">
					<Link
						v-for="item in navigation"
						:key="item.name"
						:href="item.href"
						class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 rounded-md"
					>
						{{ item.name }}
					</Link>
				</div>
			</div>
		</nav>

		<!-- Contenu principal -->
		<main>
			<slot />
		</main>

		<!-- Footer -->
		<footer class="bg-gray-800 text-white mt-12">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
				<div class="text-center">
					<p class="text-sm">
						© {{ new Date().getFullYear() }} HRAD Dschang - Hôpital Régional Annexe de Dschang
					</p>
					<p class="text-xs text-gray-400 mt-2">
						Tous droits réservés
					</p>
				</div>
			</div>
		</footer>
	</div>
</template>
