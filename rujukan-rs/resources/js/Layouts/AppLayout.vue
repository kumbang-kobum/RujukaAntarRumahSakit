<script setup>
import { computed } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'

const page = usePage()

const user = computed(() => page.props.auth?.user)

function logout() {
  router.post(route('logout'))
}

function isActive(name) {
  try {
    return route().current(name)
  } catch (e) {
    return false
  }
}

function hasRoute(name) {
  try {
    return route().has(name)
  } catch (e) {
    return false
  }
}

const menu = computed(() => {
  const items = [
    { label: 'Dashboard', icon: '🏠', route: 'dashboard', show: hasRoute('dashboard') },

    { section: 'Registrasi' },
    { label: 'Registrasi Pasien', icon: '🧾', route: 'patients.create', show: hasRoute('patients.create') },
    { label: 'Registrasi Kunjungan', icon: '🩺', route: 'visits.create', show: hasRoute('visits.create') },

    { section: 'Data' },
    { label: 'Daftar Pasien', icon: '👤', route: 'patients.index', show: hasRoute('patients.index') },
    { label: 'Daftar Kunjungan', icon: '📋', route: 'visits.index', show: hasRoute('visits.index') },
  ]

  return items.filter(i => i.show !== false)
})
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-sky-50 via-sky-100 to-emerald-50">
    <div class="flex min-h-screen">
      <!-- SIDEBAR -->
      <aside class="w-72 bg-white/80 backdrop-blur border-r border-sky-100 px-4 py-5">
        <div class="flex items-center gap-3 px-2">
          <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-sky-500 to-emerald-500"></div>
          <div>
            <div class="text-sm text-slate-500">Rujukan Antar RS</div>
            <div class="font-semibold text-slate-800">Dashboard</div>
          </div>
        </div>

        <div class="mt-6 px-2">
          <div class="text-xs text-slate-500">Login sebagai</div>
          <div class="mt-1 font-medium text-slate-800">{{ user?.name ?? '-' }}</div>
          <div class="text-xs text-slate-500">{{ user?.email ?? '-' }}</div>
        </div>

        <nav class="mt-6 space-y-1">
          <template v-for="(item, idx) in menu" :key="idx">
            <div v-if="item.section" class="mt-5 mb-2 px-2 text-xs font-semibold text-slate-500 uppercase">
              {{ item.section }}
            </div>

            <Link
              v-else
              :href="route(item.route)"
              class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm transition"
              :class="isActive(item.route)
                ? 'bg-sky-100 text-sky-700 font-semibold'
                : 'text-slate-700 hover:bg-white hover:text-slate-900'"
            >
              <span class="text-base">{{ item.icon }}</span>
              <span>{{ item.label }}</span>
            </Link>
          </template>
        </nav>

        <div class="mt-8 px-2">
          <button
            class="w-full rounded-xl bg-slate-900 text-white py-2 text-sm hover:bg-slate-800"
            @click="logout"
          >
            Logout
          </button>
        </div>
      </aside>

      <!-- MAIN -->
      <main class="flex-1">
        <!-- TOPBAR -->
        <div class="sticky top-0 z-10 bg-white/50 backdrop-blur border-b border-sky-100">
          <div class="px-6 py-4 flex items-center justify-between">
            <div class="text-slate-800 font-semibold">
              {{ page.props.title ?? 'Aplikasi Rujukan' }}
            </div>
            <div class="text-xs text-slate-500">
              {{ new Date().toLocaleString() }}
            </div>
          </div>
        </div>

        <!-- CONTENT -->
        <div class="px-6 py-6">
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>