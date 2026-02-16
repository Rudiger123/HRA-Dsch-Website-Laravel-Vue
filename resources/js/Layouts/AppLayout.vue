<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted } from 'vue'
import {
	Menu, X, Phone, Clock, MapPin,
	Facebook, Twitter, Instagram, Mail,
	ChevronDown, Stethoscope, Users, FileText,
	AlertCircle, HelpCircle, Calendar
} from 'lucide-vue-next'

const mobileMenuOpen = ref(false)
const scrolled = ref(false)
const servicesDropdownOpen = ref(false)
const mobileServicesOpen = ref(false)

// Navigation principale - groupée par importance
const mainNavigation = [
	{ name: 'Accueil', href: '/', icon: null },
	{
		name: 'Services',
		href: '/services',
		dropdown: true,
		icon: Stethoscope,
		items: [
			{ name: 'Tous les services', href: '/services' },
			{ name: 'Pédiatrie', href: '/services/pediatrie' },
			{ name: 'Maternité', href: '/services/maternite' },
			{ name: 'Cardiologie', href: '/services/cardiologie' },
			{ name: 'Urgences 24/7', href: '/services/urgences' },
		]
	},
	{ name: 'Équipe', href: '/equipe', icon: Users },
	{ name: 'À Propos', href: '/a-propos', icon: FileText },
	{ name: 'Actualités', href: '/actualites', icon: null },
]

// Navigation secondaire - dans un menu
const secondaryNavigation = [
	{ name: 'Tarifs', href: '/tarifs' },
	{ name: 'FAQ', href: '/faq' },
	{ name: 'Contact', href: '/contact' },
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
		<!-- Top Bar Info - Desktop Only -->
		<div class="hidden md:block bg-gradient-to-r from-primary-600 to-primary-700 text-white text-sm py-3 border-b border-primary-800">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex justify-between items-center flex-wrap gap-4">
					<!-- Left: Contact Info -->
					<div class="flex items-center gap-6">
						<a href="tel:+237XXXXXXXXX" class="flex items-center gap-2 hover:text-secondary-200 transition-colors group">
							<Phone class="w-4 h-4 group-hover:animate-pulse" />
							<span>+237 XXX XXX XXX</span>
						</a>
						<span class="text-primary-300">|</span>
						<a href="mailto:contact@hrad-dschang.cm" class="flex items-center gap-2 hover:text-secondary-200 transition-colors">
							<Mail class="w-4 h-4" />
							<span>contact@hrad-dschang.cm</span>
						</a>
					</div>

					<!-- Right: Horaires + Urgences -->
					<div class="flex items-center gap-4">
						<div class="flex items-center gap-1 text-primary-100">
							<Clock class="w-4 h-4" />
							<span>Lun-Ven 8h-17h | Sam 8h-12h</span>
						</div>
						<span class="text-primary-300">|</span>
						<a
							href="tel:+237XXXXXXXXX"
							class="flex items-center gap-1 bg-danger-500 hover:bg-danger-600 px-3 py-1 rounded font-bold transition-all transform hover:scale-105"
						>
							<AlertCircle class="w-4 h-4" />
							Urgences 24/7
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Main Header -->
		<header :class="['sticky top-0 z-40 bg-white transition-all', scrolled ? 'shadow-lg' : 'shadow']" :style="{ top: 'var(--header-offset, 0)' }">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex items-center justify-between h-16 md:h-20">
					<!-- Logo -->
					<Link href="/" class="flex items-center gap-2 group flex-shrink-0">
						<img src="/images/logo-hrad.png" alt="HRAD Logo" class="h-12 md:h-14 w-auto transition-transform group-hover:scale-110" />
						<div class="hidden sm:block">
							<div class="text-lg md:text-xl font-bold text-primary-600 leading-tight">HRAD</div>
							<div class="text-xs text-gray-600">Hôpital Régional</div>
						</div>
					</Link>

					<!-- Navigation Desktop - Spacée -->
					<nav class="hidden lg:flex items-center gap-2 flex-1 mx-8">
						<template v-for="item in mainNavigation" :key="item.name">
							<!-- Menu avec dropdown -->
							<div
								v-if="item.dropdown"
								class="relative group"
								@mouseenter="servicesDropdownOpen = true"
								@mouseleave="servicesDropdownOpen = false"
							>
								<button
									class="flex items-center gap-1 text-gray-700 hover:text-primary-600 font-medium px-4 py-3 rounded-md transition-colors whitespace-nowrap"
									:class="{ 'text-primary-600 bg-primary-50': $page.url.startsWith('/services') }"
								>
									<component v-if="item.icon" :is="item.icon" class="w-4 h-4" />
									{{ item.name }}
									<ChevronDown class="w-4 h-4 transition-transform group-hover:rotate-180" />
								</button>

								<!-- Mega Dropdown - Deux colonnes -->
								<div
									v-show="servicesDropdownOpen"
									class="absolute top-full left-0 mt-1 w-80 bg-white rounded-lg shadow-2xl border border-gray-100 p-4 animate-fade-in-down"
								>
									<div class="space-y-2">
										<Link
											v-for="subItem in item.items"
											:key="subItem.href"
											:href="subItem.href"
											class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-md transition-all hover:translate-x-1"
										>
											<div class="w-2 h-2 bg-primary-500 rounded-full group-hover:w-3"></div>
											<span>{{ subItem.name }}</span>
										</Link>
									</div>
								</div>
							</div>

							<!-- Menu simple -->
							<Link
								v-else
								:href="item.href"
								class="text-gray-700 hover:text-primary-600 font-medium px-4 py-3 rounded-md transition-colors whitespace-nowrap flex items-center gap-2"
								:class="{ 'text-primary-600 bg-primary-50': $page.url === item.href }"
							>
								<component v-if="item.icon" :is="item.icon" class="w-4 h-4 hidden lg:inline" />
								{{ item.name }}
							</Link>
						</template>
					</nav>

					<!-- Right Side - Desktop -->
					<div class="hidden lg:flex items-center gap-3">
						<!-- Lien Rendez-vous - CTA Principal -->
						<Link
							href="/rendez-vous"
							class="flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-bold px-5 py-2.5 rounded-lg transition-all transform hover:scale-105 shadow-sm"
						>
							<Calendar class="w-4 h-4" />
							Rendez-vous
						</Link>

						<!-- Menu Secondaire Dropdown -->
						<div class="relative group">
							<button
								class="text-gray-700 hover:text-primary-600 font-medium px-3 py-2 rounded-md transition-colors"
							>
								<Menu class="w-5 h-5" />
							</button>
							<div class="absolute top-full right-0 mt-1 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all">
								<Link
									v-for="item in secondaryNavigation"
									:key="item.href"
									:href="item.href"
									class="block px-4 py-2.5 text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors text-sm"
								>
									{{ item.name }}
								</Link>
								<div class="border-t border-gray-100 my-2"></div>
								<Link
									href="/mentions-legales"
									class="block px-4 py-2.5 text-gray-600 hover:text-primary-600 text-sm transition-colors"
								>
									Mentions Légales
								</Link>
								<Link
									href="/confidentialite"
									class="block px-4 py-2.5 text-gray-600 hover:text-primary-600 text-sm transition-colors"
								>
									Politique Confidentialité
								</Link>
								<Link
									href="/cgu"
									class="block px-4 py-2.5 text-gray-600 hover:text-primary-600 text-sm transition-colors"
								>
									CGU
								</Link>
							</div>
						</div>
					</div>

					<!-- Mobile: Menu Button + Urgences -->
					<div class="lg:hidden flex items-center gap-2">
						<!-- Mini CTA Urgences Mobile -->
						<a
							href="tel:+237XXXXXXXXX"
							class="md:hidden flex items-center gap-1 bg-danger-500 text-white font-bold px-3 py-2 rounded-lg text-sm transition-all"
						>
							<Phone class="w-4 h-4" />
						</a>

						<!-- Menu Button -->
						<button
							@click="mobileMenuOpen = !mobileMenuOpen"
							class="p-2 text-gray-600 hover:text-primary-600 transition-colors"
						>
							<Menu v-if="!mobileMenuOpen" class="w-6 h-6" />
							<X v-else class="w-6 h-6" />
						</button>
					</div>
				</div>

				<!-- Mobile Menu - Hiérarchisé -->
				<div
					v-if="mobileMenuOpen"
					class="lg:hidden py-4 border-t border-gray-100 max-h-[calc(100vh-80px)] overflow-y-auto animate-fade-in-down"
				>
					<!-- Navigation principale -->
					<div class="space-y-1">
						<template v-for="item in mainNavigation" :key="item.name">
							<!-- Services avec submenu -->
							<div v-if="item.dropdown">
								<button
									@click="mobileServicesOpen = !mobileServicesOpen"
									class="w-full flex items-center justify-between py-3 px-4 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-md font-medium transition-colors"
								>
									<span class="flex items-center gap-2">
										<Stethoscope class="w-4 h-4" />
										{{ item.name }}
									</span>
									<ChevronDown :class="['w-4 h-4 transition-transform', mobileServicesOpen && 'rotate-180']" />
								</button>
								<div v-if="mobileServicesOpen" class="bg-primary-50 py-2">
									<Link
										v-for="subItem in item.items"
										:key="subItem.href"
										:href="subItem.href"
										class="block py-2.5 px-8 text-gray-700 hover:text-primary-600 transition-colors border-l-2 border-transparent hover:border-primary-600"
										@click="mobileMenuOpen = false"
									>
										{{ subItem.name }}
									</Link>
								</div>
							</div>

							<!-- Liens simples -->
							<Link
								v-else
								:href="item.href"
								class="flex items-center gap-2 py-3 px-4 text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-md font-medium transition-colors"
								@click="mobileMenuOpen = false"
							>
								<component v-if="item.icon" :is="item.icon" class="w-4 h-4" />
								{{ item.name }}
							</Link>
						</template>
					</div>

					<!-- Divider -->
					<div class="my-4 border-t border-gray-200"></div>

					<!-- Navigation secondaire -->
					<div class="space-y-1">
						<Link
							v-for="item in secondaryNavigation"
							:key="item.href"
							:href="item.href"
							class="block py-2.5 px-4 text-gray-600 hover:bg-primary-50 hover:text-primary-600 rounded-md transition-colors text-sm"
							@click="mobileMenuOpen = false"
						>
							{{ item.name }}
						</Link>
					</div>

					<!-- Divider -->
					<div class="my-4 border-t border-gray-200"></div>

					<!-- CTA Principal -->
					<Link
						href="/rendez-vous"
						class="flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 rounded-lg m-4 transition-colors"
						@click="mobileMenuOpen = false"
					>
						<Calendar class="w-4 h-4" />
						Prendre Rendez-vous
					</Link>

					<!-- Urgences -->
					<a
						href="tel:+237XXXXXXXXX"
						class="flex items-center justify-center gap-2 bg-danger-500 hover:bg-danger-600 text-white font-bold py-3 rounded-lg m-4 transition-colors animate-pulse"
					>
						<AlertCircle class="w-4 h-4" />
						Urgences 24/7
					</a>

					<!-- Pages légales -->
					<div class="py-4 border-t border-gray-200 space-y-1 text-xs">
						<Link href="/mentions-legales" class="block px-4 py-2 text-gray-600 hover:text-primary-600" @click="mobileMenuOpen = false">
							Mentions Légales
						</Link>
						<Link href="/confidentialite" class="block px-4 py-2 text-gray-600 hover:text-primary-600" @click="mobileMenuOpen = false">
							Politique Confidentialité
						</Link>
						<Link href="/cgu" class="block px-4 py-2 text-gray-600 hover:text-primary-600" @click="mobileMenuOpen = false">
							CGU
						</Link>
					</div>
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
								<Link href="/a-propos" class="hover:text-primary-400 transition-colors flex items-center gap-2 group">
									<span class="w-1 h-1 bg-primary-500 rounded-full group-hover:w-2 transition-all"></span>
									À Propos
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
							<Link href="/confidentialite" class="hover:text-primary-400 transition-colors">
								Confidentialité
							</Link>
							<Link href="/cgu" class="hover:text-primary-400 transition-colors">
								CGU
							</Link>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
</template>
