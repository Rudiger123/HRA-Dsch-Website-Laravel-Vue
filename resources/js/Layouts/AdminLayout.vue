<script setup>
import { ref, computed } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import {
  LayoutDashboard, Users, Stethoscope, Hospital,
  Newspaper, Calendar, Mail, DollarSign, Clock,
  User, LogOut, Menu, X, Bell, Search, ChevronDown,
  Settings, Activity, Shield, Sparkles
} from 'lucide-vue-next'
import GlobalSearch from '@/Components/Admin/GlobalSearch.vue'
import LogoutConfirmModal from '@/Components/Admin/LogoutConfirmModal.vue'

const page = usePage()
const user = computed(() => page.props.auth?.user)

// Helper route function for Laravel routes
const route = (routeName, params = {}) => {
  if (typeof window.route === 'function') {
    return window.route(routeName, params)
  }
  return '/' // Fallback
}

const sidebarOpen = ref(true)
const userMenuOpen = ref(false)
const notificationsOpen = ref(false)
const showLogoutModal = ref(false)

const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value
}

const logout = () => {
  showLogoutModal.value = true
}

const closeLogoutModal = () => {
  showLogoutModal.value = false
}

// Menu de navigation selon permissions
const navigationItems = computed(() => {
  const items = [
    {
      name: 'Dashboard',
      route: 'admin.dashboard',
      icon: LayoutDashboard,
      permission: null,
    },
  ]

  if (user.value?.permissions?.includes('view_services')) {
    items.push({
      name: 'Services',
      route: 'admin.services.index',
      icon: Hospital,
      permission: 'view_services',
    })
  }

  if (user.value?.permissions?.includes('view_medecins')) {
    items.push({
      name: 'Médecins',
      route: 'admin.medecins.index',
      icon: Stethoscope,
      permission: 'view_medecins',
    })
  }

  if (user.value?.permissions?.includes('view_actualites')) {
    items.push({
      name: 'Actualités',
      route: 'admin.actualites.index',
      icon: Newspaper,
      permission: 'view_actualites',
    })
  }

  if (user.value?.permissions?.includes('view_all_rdv') || user.value?.permissions?.includes('view_own_rdv')) {
    items.push({
      name: 'Rendez-vous',
      route: 'admin.rdv-requests.index',
      icon: Calendar,
      permission: 'view_all_rdv',
    })
  }

  if (user.value?.permissions?.includes('view_contacts')) {
    items.push({
      name: 'Messages',
      route: 'admin.contacts.index',
      icon: Mail,
      permission: 'view_contacts',
      badge: page.props.unread_messages_count,
    })
  }

  if (user.value?.permissions?.includes('manage_tarifs')) {
    items.push({
      name: 'Tarifs',
      route: 'admin.tarifs.index',
      icon: DollarSign,
      permission: 'manage_tarifs',
    })
  }

  if (user.value?.permissions?.includes('manage_horaires')) {
    items.push({
      name: 'Horaires',
      route: 'admin.horaires.index',
      icon: Clock,
      permission: 'manage_horaires',
    })
  }

  if (user.value?.permissions?.includes('view_users')) {
    items.push({
      name: 'Utilisateurs',
      route: 'admin.users.index',
      icon: Users,
      permission: 'view_users',
    })
  }

  if (user.value?.permissions?.includes('view_audit_log')) {
    items.push({
      name: 'Journal d\'activité',
      route: 'admin.activity-log.index',
      icon: Activity,
      permission: 'view_audit_log',
    })
  }

  return items
})

const isActiveRoute = (routeName) => {
  return page.url.startsWith(route(routeName))
}

const userRole = computed(() => {
  const roles = {
    'super_admin': 'Super Administrateur',
    'admin': 'Administrateur',
    'editeur': 'Éditeur',
    'receptionniste': 'Réceptionniste',
    'medecin': 'Médecin',
  }
  return roles[user.value?.role] || user.value?.role
})
</script>

<template>
  <div class="min-h-screen bg-slate-50 flex font-sans">
    <!-- Sidebar -->
    <aside
      :class="[
        'fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 transform transition-all duration-300 ease-out lg:translate-x-0 lg:static flex flex-col',
        sidebarOpen ? 'translate-x-0 shadow-2xl lg:shadow-none' : '-translate-x-full'
      ]"
    >
      <!-- Logo -->
      <div class="h-20 flex items-center justify-between px-6 border-b border-slate-100">
        <Link href="/" class="flex items-center gap-3 group">
          <div class="w-11 h-11 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30 group-hover:shadow-primary-500/50 transition-all duration-300 group-hover:scale-105">
            <Shield :size="24" class="text-white" />
          </div>
          <div class="flex flex-col">
            <span class="font-bold text-slate-900 text-lg tracking-tight leading-tight">HRA Dschang</span>
            <span class="text-xs text-slate-500 font-medium tracking-wide uppercase">Administration</span>
          </div>
        </Link>
        <button
          @click="toggleSidebar"
          class="lg:hidden p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors"
        >
          <X :size="20" />
        </button>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 px-4 py-6 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
        <div class="mb-6">
          <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Menu Principal</p>
          <ul class="space-y-1">
            <li v-for="item in navigationItems" :key="item.route">
              <Link
                :href="route(item.route)"
                :class="[
                  'group flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 relative overflow-hidden',
                  isActiveRoute(item.route)
                    ? 'bg-primary-50 text-primary-700 font-semibold shadow-sm shadow-primary-500/10'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                ]"
              >
                <div class="flex items-center gap-3 relative z-10">
                  <div :class="[
                    'p-2 rounded-lg transition-all duration-200',
                    isActiveRoute(item.route)
                      ? 'bg-primary-100 text-primary-600'
                      : 'bg-slate-100 text-slate-500 group-hover:bg-white group-hover:shadow-sm'
                  ]">
                    <component :is="item.icon" :size="18" />
                  </div>
                  <span class="text-sm">{{ item.name }}</span>
                </div>
                <span
                  v-if="item.badge"
                  class="relative z-10 bg-rose-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm shadow-rose-500/30 animate-pulse"
                >
                  {{ item.badge }}
                </span>
                <div
                  v-if="isActiveRoute(item.route)"
                  class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-primary-500 rounded-r-full"
                />
              </Link>
            </li>
          </ul>
        </div>

        <!-- Quick Actions -->
        <div class="px-4">
          <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-4 text-white shadow-xl shadow-slate-900/20">
            <div class="flex items-center gap-2 mb-2">
              <Sparkles :size="16" class="text-amber-400" />
              <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">Astuce</span>
            </div>
            <p class="text-sm text-slate-300 leading-relaxed mb-3">
              Utilisez les raccourcis clavier pour naviguer plus rapidement.
            </p>
            <kbd class="inline-flex items-center gap-1 px-2 py-1 bg-slate-700 rounded text-xs font-mono text-slate-300">
              <span>Ctrl</span> + <span>K</span>
            </kbd>
          </div>
        </div>
      </nav>

      <!-- User section -->
      <div class="p-4 border-t border-slate-100 bg-slate-50/50">
        <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-slate-100 shadow-sm">
          <div class="relative">
            <img
              :src="user?.photo_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user?.name || 'User') + '&background=random'"
              :alt="user?.name"
              class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-sm"
            />
            <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></div>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-slate-900 truncate">{{ user?.name }}</p>
            <p class="text-xs text-slate-500 font-medium truncate">{{ userRole }}</p>
          </div>
        </div>
      </div>
    </aside>

    <!-- Overlay mobile -->
    <div
      v-if="sidebarOpen"
      @click="toggleSidebar"
      class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden transition-opacity duration-300"
    />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
      <!-- Top Header -->
      <header class="h-20 bg-white/80 backdrop-blur-xl border-b border-slate-200/80 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
        <!-- Left: Menu burger + Breadcrumb -->
        <div class="flex items-center gap-4">
          <button
            @click="toggleSidebar"
            class="p-2.5 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-all duration-200 lg:hidden"
          >
            <Menu :size="20" />
          </button>

          <!-- Breadcrumb -->
          <nav class="hidden md:flex items-center gap-2 text-sm">
            <Link href="/admin/dashboard" class="text-slate-500 hover:text-primary-600 transition-colors flex items-center gap-1">
              <LayoutDashboard :size="14" />
              <span>Dashboard</span>
            </Link>
            <ChevronDown :size="14" class="text-slate-400 -rotate-90" />
            <span class="text-slate-900 font-semibold bg-slate-100 px-3 py-1 rounded-full">{{ page.props.title || 'Admin' }}</span>
          </nav>
        </div>

        <!-- Right: Search, Notifications, User menu -->
        <div class="flex items-center gap-2">
          <!-- Global Search -->
          <GlobalSearch />

          <!-- Notifications -->
          <div class="relative">
            <button
              @click="notificationsOpen = !notificationsOpen"
              class="relative p-2.5 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-all duration-200"
              :class="{ 'bg-slate-100 text-slate-700': notificationsOpen }"
            >
              <Bell :size="20" />
              <span
                v-if="page.props.unread_notifications_count > 0"
                class="absolute top-2 right-2 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"
              />
            </button>

            <!-- Dropdown notifications -->
            <Transition
              enter-active-class="transition ease-out duration-200"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-150"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <div
                v-if="notificationsOpen"
                class="absolute right-0 mt-3 w-96 bg-white rounded-2xl shadow-2xl shadow-slate-900/10 border border-slate-100 overflow-hidden"
              >
                <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                  <h3 class="font-semibold text-slate-900">Notifications</h3>
                  <button class="text-xs text-primary-600 hover:text-primary-700 font-medium">Tout marquer comme lu</button>
                </div>
                <div class="max-h-96 overflow-y-auto">
                  <p class="px-4 py-8 text-sm text-slate-500 text-center flex flex-col items-center gap-2">
                    <Bell :size="24" class="text-slate-300" />
                    Aucune notification
                  </p>
                </div>
              </div>
            </Transition>
          </div>

          <!-- User Menu -->
          <div class="relative ml-2">
            <button
              @click="userMenuOpen = !userMenuOpen"
              class="flex items-center gap-3 p-1.5 pr-3 rounded-full hover:bg-slate-100 transition-all duration-200 border border-transparent hover:border-slate-200"
              :class="{ 'bg-slate-100 border-slate-200': userMenuOpen }"
            >
              <img
                :src="user?.photo_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user?.name || 'User') + '&background=random'"
                :alt="user?.name"
                class="w-8 h-8 rounded-full object-cover ring-2 ring-white shadow-sm"
              />
              <div class="hidden lg:block text-left">
                <p class="text-sm font-semibold text-slate-900 leading-tight">{{ user?.name?.split(' ')[0] }}</p>
                <p class="text-xs text-slate-500 leading-tight">{{ userRole }}</p>
              </div>
              <ChevronDown :size="16" class="text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': userMenuOpen }" />
            </button>

            <!-- Dropdown menu -->
            <Transition
              enter-active-class="transition ease-out duration-200"
              enter-from-class="transform opacity-0 scale-95 -translate-y-2"
              enter-to-class="transform opacity-100 scale-100 translate-y-0"
              leave-active-class="transition ease-in duration-150"
              leave-from-class="transform opacity-100 scale-100 translate-y-0"
              leave-to-class="transform opacity-0 scale-95 -translate-y-2"
            >
              <div
                v-if="userMenuOpen"
                class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl shadow-slate-900/10 border border-slate-100 overflow-hidden"
              >
                <div class="px-4 py-4 bg-gradient-to-br from-slate-50 to-white border-b border-slate-100">
                  <p class="text-sm font-bold text-slate-900">{{ user?.name }}</p>
                  <p class="text-xs text-slate-500 mt-0.5">{{ user?.email }}</p>
                </div>

                <div class="p-2">
                  <Link
                    :href="route('admin.profile.edit')"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-700 hover:bg-slate-50 rounded-xl transition-colors group"
                  >
                    <div class="p-1.5 bg-slate-100 rounded-lg group-hover:bg-white group-hover:shadow-sm transition-all">
                      <User :size="16" class="text-slate-500" />
                    </div>
                    Mon Profil
                  </Link>

                  <Link
                    href="/"
                    target="_blank"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-700 hover:bg-slate-50 rounded-xl transition-colors group"
                  >
                    <div class="p-1.5 bg-slate-100 rounded-lg group-hover:bg-white group-hover:shadow-sm transition-all">
                      <Settings :size="16" class="text-slate-500" />
                    </div>
                    Voir le site
                  </Link>
                </div>

                <div class="p-2 border-t border-slate-100">
                  <button
                    @click="logout"
                    class="w-full flex items-center gap-3 px-3 py-2.5 text-sm text-rose-600 hover:bg-rose-50 rounded-xl transition-colors group"
                  >
                    <div class="p-1.5 bg-rose-100 rounded-lg group-hover:bg-white group-hover:shadow-sm transition-all">
                      <LogOut :size="16" class="text-rose-500" />
                    </div>
                    Déconnexion
                  </button>
                </div>
              </div>
            </Transition>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 p-4 lg:p-8 overflow-y-auto">
        <!-- Flash Messages -->
        <TransitionGroup
          enter-active-class="transition ease-out duration-300"
          enter-from-class="transform -translate-y-4 opacity-0"
          enter-to-class="transform translate-y-0 opacity-100"
          leave-active-class="transition ease-in duration-200"
          leave-from-class="transform translate-y-0 opacity-100"
          leave-to-class="transform -translate-y-4 opacity-0"
        >
          <div v-if="page.props.flash?.success" key="success" class="mb-6">
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-start gap-3 shadow-sm shadow-emerald-500/10">
              <div class="shrink-0 w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-semibold text-emerald-900">Succès</p>
                <p class="text-sm text-emerald-700 mt-0.5">{{ page.props.flash.success }}</p>
              </div>
            </div>
          </div>

          <div v-if="page.props.flash?.error" key="error" class="mb-6">
            <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 flex items-start gap-3 shadow-sm shadow-rose-500/10">
              <div class="shrink-0 w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-semibold text-rose-900">Erreur</p>
                <p class="text-sm text-rose-700 mt-0.5">{{ page.props.flash.error }}</p>
              </div>
            </div>
          </div>

          <div v-if="page.props.flash?.info" key="info" class="mb-6">
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-start gap-3 shadow-sm shadow-blue-500/10">
              <div class="shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-semibold text-blue-900">Information</p>
                <p class="text-sm text-blue-700 mt-0.5">{{ page.props.flash.info }}</p>
              </div>
            </div>
          </div>
        </TransitionGroup>

        <!-- Slot content -->
        <slot />
      </main>

      <!-- Footer -->
      <footer class="bg-white border-t border-slate-200 px-4 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500">
          <div class="flex items-center gap-2">
            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
            <p>© 2026 HRA Dschang. Tous droits réservés.</p>
          </div>
          <div class="flex gap-6">
            <Link href="/mentions-legales" class="hover:text-primary-600 transition-colors font-medium">Mentions Légales</Link>
            <Link href="/confidentialite" class="hover:text-primary-600 transition-colors font-medium">Confidentialité</Link>
          </div>
        </div>
      </footer>
    </div>

    <!-- Logout Confirmation Modal -->
    <LogoutConfirmModal
      :is-open="showLogoutModal"
      @close="closeLogoutModal"
    />
  </div>
</template>
