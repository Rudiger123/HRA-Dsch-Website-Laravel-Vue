<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import {
	Menu, X, Phone, Clock, MapPin,
	Facebook, Twitter, Instagram, Mail,
	ChevronDown
} from 'lucide-vue-next'

const mobileMenuOpen = ref(false)
const scrolled = ref(false)
const servicesDropdownOpen = ref(false)

const navigation = [
	{ name: 'Accueil', href: '/' },
	{
		name: 'Services',
		href: '/services',
		dropdown: true,
		items: [
			{ name: 'Tous les services', href: '/services' },
			{ name: 'Pédiatrie', href: '/services/pediatrie' },
			{ name: 'Maternité', href: '/services/maternite' },
			{ name: 'Cardiologie', href: '/services/cardiologie' },
			{ name: 'Urgences 24/7', href: '/services/urgences' },
		]
	},
	{ name: 'Tarifs', href: '/tarifs' },
	{ name: 'Équipe Médicale', href: '/equipe' },
	{ name: 'FAQ', href: '/faq' },
	{ name: 'Rendez-vous', href: '/rendez-vous' },
	{ name: 'Contact', href: '/contact' }
]

const handleScroll = () => {
	scrolled.value = window.scrollY > 20
}

onMounted(() => {
	window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
	window.removeEventListener('scroll', handleScroll)
})
</script>

<template>
	<div class="min-h-screen flex flex-col bg-gray-50">
		<!-- Header -->
		<header :class="['sticky top-0 z-40 bg-white transition-all', scrolled ? 'shadow-lg' : 'shadow']">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex items-center justify-between h-20">
					<!-- Logo -->
					<Link href="/" class="flex items-center gap-3 group">
						<img src="/images/logo-hrad.png" alt="HRAD Logo" class="h-14 w-auto transition-transform group-hover:scale-105" />
						<div class="hidden sm:block">
							<div class="text-xl font-bold text-primary-600 leading-tight">HRAD</div>
							<div class="text-xs text-gray-600">Hôpital Régional Annexe</div>
						</div>
					</Link>

					<!-- Navigation Desktop -->
					<nav class="hidden lg:flex items-center gap-1">
						<template v-for="item in navigation" :key="item.name">
							<!-- Menu avec dropdown -->
							<div
								v-if="item.dropdown"
								class="relative"
								@mouseenter="servicesDropdownOpen = true"
								@mouseleave="servicesDropdownOpen = false"
							>
								<button
									class="flex items-center gap-1 text-gray-700 hover:text-primary-600 font-medium px-4 py-2 rounded-md transition-colors"
									:class="{ 'text-primary-600 bg-primary-50': $page.url.startsWith('/services') }"
								>
									{{ item.name }}
									<ChevronDown class="w-4 h-4" :class="{ 'rotate-180': servicesDropdownOpen }" />
								</button>

								<!-- Dropdown menu -->
								<div
									v-show="servicesDropdownOpen"
									class="absolute top-full left-0 mt-1 w-64 bg-white rounded-lg shadow-xl border border-gray-100 py-2 animate-fade-in-down"
								>
									<Link
										v-for="subItem in item.items"
										:key="subItem.href"
										:href="subItem.href"
										class="block px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors"
									>
										{{ subItem.name }}
									</Link>
								</div>
							</div>

							<!-- Menu simple -->
							<Link
								v-else
								:href="item.href"
								class="text-gray-700 hover:text-primary-600 font-medium px-4 py-2 rounded-md transition-colors"
								:class="{ 'text-primary-600 bg-primary-50': $page.url === item.href }"
							>
								{{ item.name }}
							</Link>
						</template>
					</nav>

					<!-- CTA Urgences + Mobile Menu Button -->
					<div class="flex items-center gap-3">
						<!-- Bouton Urgences Desktop -->
						<a
							href="tel:+237XXXXXXXXX"
							class="hidden sm:flex items-center gap-2 bg-danger-500 hover:bg-danger-600 text-white font-bold px-4 py-2 rounded-lg transition-all transform hover:scale-105 animate-pulse"
						>
							<Phone class="w-4 h-4" />
							<span class="hidden md:inline">Urgences</span>
						</a>

						<!-- Mobile Menu Button -->
						<button
							@click="mobileMenuOpen = !mobileMenuOpen"
							class="lg:hidden p-2 text-gray-600 hover:text-primary-600 transition-colors"
						>
							<Menu v-if="!mobileMenuOpen" class="w-6 h-6" />
							<X v-else class="w-6 h-6" />
						</button>
					</div>
				</div>

				<!-- Mobile Menu -->
				<div
					v-if="mobileMenuOpen"
					class="lg:hidden py-4 border-t border-gray-100 animate-fade-in-down"
				>
					<!-- Liens principaux mobile -->
					<Link
						v-for="item in navigation.filter(i => !i.dropdown)"
						:key="item.name"
						:href="item.href"
						class="block py-3 px-4 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-md transition-colors"
						@click="mobileMenuOpen = false"
					>
						{{ item.name }}
					</Link>

					<!-- Services submenu mobile -->
					<div class="py-2">
						<div class="text-sm font-semibold text-gray-500 px-4 py-2">Services</div>
						<Link
							v-for="subItem in navigation.find(i => i.dropdown)?.items"
							:key="subItem.href"
							:href="subItem.href"
							class="block py-2 px-8 text-gray-600 hover:bg-primary-50 hover:text-primary-600 transition-colors"
							@click="mobileMenuOpen = false"
						>
							{{ subItem.name }}
						</Link>
					</div>

					<!-- CTA Mobile -->
					<a
						href="tel:+237XXXXXXXXX"
						class="block mt-4 mx-4 bg-danger-500 text-white text-center font-bold py-3 rounded-lg hover:bg-danger-600 transition-colors"
					>
						🚨 Urgences 24/7
					</a>
				</div>
			</div>
		</header>

		<!-- Main Content -->
		<main class="grow">
			<slot />
		</main>

		<!-- Footer -->
		<footer class="bg-gray-900 text-gray-300 mt-auto">
			<!-- Footer principal -->
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
					<!-- Colonne 1 : À propos -->
					<div>
						<div class="flex items-center gap-3 mb-6">
							<img
								src="/images/logo-hrad.png"
								alt="HRAD"
								class="h-12 w-auto"
							/>
							<div>
								<div class="text-white font-bold text-lg">HRAD</div>
								<div class="text-xs text-gray-400">Dschang</div>
							</div>
						</div>
						<p class="text-sm mb-6 text-gray-400 leading-relaxed">
							Hôpital Régional Annexe de Dschang - Votre partenaire santé depuis 1987.
							Soins de qualité, équipe dévouée, disponible 24h/24.
						</p>
						<div class="flex gap-3">
							<a href="#" class="bg-gray-800 hover:bg-primary-600 p-2 rounded-lg transition-colors">
								<Facebook class="w-5 h-5" />
							</a>
							<a href="#" class="bg-gray-800 hover:bg-primary-600 p-2 rounded-lg transition-colors">
								<Twitter class="w-5 h-5" />
							</a>
							<a href="#" class="bg-gray-800 hover:bg-primary-600 p-2 rounded-lg transition-colors">
								<Instagram class="w-5 h-5" />
							</a>
						</div>
					</div>

					<!-- Colonne 2 : Liens rapides -->
					<div>
						<h3 class="text-white font-semibold text-lg mb-6 border-b border-gray-700 pb-3">
							Liens Rapides
						</h3>
						<ul class="space-y-3">
							<li>
								<Link href="/" class="hover:text-primary-400 transition-colors flex items-center gap-2 group">
									<span class="w-1 h-1 bg-primary-500 rounded-full group-hover:w-2 transition-all"></span>
									Accueil
								</Link>
							</li>
							<li>
								<Link href="/services" class="hover:text-primary-400 transition-colors flex items-center gap-2 group">
									<span class="w-1 h-1 bg-primary-500 rounded-full group-hover:w-2 transition-all"></span>
									Nos Services
								</Link>
							</li>
							<li>
								<Link href="/equipe" class="hover:text-primary-400 transition-colors flex items-center gap-2 group">
									<span class="w-1 h-1 bg-primary-500 rounded-full group-hover:w-2 transition-all"></span>
									Équipe Médicale
								</Link>
							</li>
							<li>
								<Link href="/rendez-vous" class="hover:text-primary-400 transition-colors flex items-center gap-2 group">
									<span class="w-1 h-1 bg-primary-500 rounded-full group-hover:w-2 transition-all"></span>
									Prendre Rendez-vous
								</Link>
							</li>
							<li>
								<Link href="/contact" class="hover:text-primary-400 transition-colors flex items-center gap-2 group">
									<span class="w-1 h-1 bg-primary-500 rounded-full group-hover:w-2 transition-all"></span>
									Nous Contacter
								</Link>
							</li>
						</ul>
					</div>

					<!-- Colonne 3 : Contact & Horaires -->
					<div>
						<h3 class="text-white font-semibold text-lg mb-6 border-b border-gray-700 pb-3">
							Contact & Horaires
						</h3>
						<div class="space-y-4 text-sm">
							<div class="flex items-start gap-3">
								<Phone class="w-5 h-5 text-primary-500 mt-0.5" />
								<div>
									<div class="text-white font-medium">Standard</div>
									<a href="tel:+237XXXXXXXXX" class="hover:text-primary-400 transition-colors">
										+237 XXX XXX XXX
									</a>
								</div>
							</div>

							<div class="flex items-start gap-3">
								<Phone class="w-5 h-5 text-danger-500 mt-0.5 animate-pulse" />
								<div>
									<div class="text-white font-medium">Urgences 24/7</div>
									<a href="tel:+237XXXXXXXXX" class="text-danger-400 hover:text-danger-300 font-bold transition-colors">
										+237 XXX XXX XXX
									</a>
								</div>
							</div>

							<div class="flex items-start gap-3">
								<Mail class="w-5 h-5 text-primary-500 mt-0.5" />
								<div>
									<div class="text-white font-medium">Email</div>
									<a href="mailto:contact@hrad-dschang.cm" class="hover:text-primary-400 transition-colors">
										contact@hrad-dschang.cm
									</a>
								</div>
							</div>

							<div class="flex items-start gap-3">
								<Clock class="w-5 h-5 text-primary-500 mt-0.5" />
								<div>
									<div class="text-white font-medium mb-1">Horaires</div>
									<div class="text-gray-400 space-y-1">
										<div>Lun-Ven : 8h00 - 17h00</div>
										<div>Samedi : 8h00 - 12h00</div>
										<div class="text-danger-400 font-semibold">Urgences : 24h/24, 7j/7</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Colonne 4 : Localisation -->
					<div>
						<h3 class="text-white font-semibold text-lg mb-6 border-b border-gray-700 pb-3">
							Notre Localisation
						</h3>
						<div class="flex items-start gap-3 mb-4 text-sm">
							<MapPin class="w-5 h-5 text-primary-500 mt-0.5" />
							<div>
								<div class="text-white font-medium mb-1">Adresse</div>
								<p class="text-gray-400">
									Route de Fongo-Tongo<br />
									Dschang, Menoua<br />
									Région de l'Ouest, Cameroun
								</p>
							</div>
						</div>

						<!-- Mini carte placeholder -->
						<div class="bg-gray-800 rounded-lg overflow-hidden h-32 hover:opacity-80 transition-opacity cursor-pointer">
							<a
								href="https://maps.google.com/?q=HRAD+Dschang"
								target="_blank"
								class="flex w-full h-full items-center justify-center text-gray-500 hover:text-primary-400 transition-colors"
							>
								<MapPin class="w-8 h-8" />
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- Footer bottom -->
			<div class="border-t border-gray-800">
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
					<div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-400">
						<div class="text-center md:text-left">
							<p>&copy; 2026 HRAD - Hôpital Régional Annexe de Dschang. Tous droits réservés.</p>
						</div>

						<div class="flex flex-wrap justify-center gap-6">
							<Link href="/mentions-legales" class="hover:text-primary-400 transition-colors">
								Mentions Légales
							</Link>
							<Link href="/politique-confidentialite" class="hover:text-primary-400 transition-colors">
								Confidentialité
							</Link>
							<Link href="/cgv" class="hover:text-primary-400 transition-colors">
								CGV
							</Link>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
</template>
