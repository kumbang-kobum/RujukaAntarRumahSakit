<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

defineProps({
  stats: Object,
})
</script>

<template>
  <Head title="Dashboard" />

  <div class="space-y-6">
    <!-- HEADER -->
    <div>
      <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
      <div class="text-sm text-slate-500 mt-1">
        Ringkasan aktivitas rumah sakit Anda.
      </div>
    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="card">
        <div class="text-sm text-slate-500">Pasien</div>
        <div class="text-3xl font-semibold text-sky-700">{{ stats.patients }}</div>
      </div>

      <div class="card">
        <div class="text-sm text-slate-500">Kunjungan Hari Ini</div>
        <div class="text-3xl font-semibold text-emerald-700">{{ stats.visitsToday }}</div>
      </div>

      <div class="card">
        <div class="text-sm text-slate-500">Kunjungan Aktif</div>
        <div class="text-3xl font-semibold text-orange-600">{{ stats.activeVisits }}</div>
      </div>

      <div class="card">
        <div class="text-sm text-slate-500">Rujukan Hari Ini</div>
        <div class="text-3xl font-semibold text-purple-700">{{ stats.referralsToday }}</div>
      </div>
    </div>

    <!-- HERO -->
    <div class="rounded-2xl p-6 bg-white/80 border border-sky-100">
      <div class="text-sm text-slate-500">Selamat datang</div>
      <div class="text-2xl font-semibold text-slate-900">
        Sistem Rujukan Pasien Antar Rumah Sakit
      </div>
      <div class="mt-2 text-slate-600">
        Gunakan menu di kiri untuk registrasi pasien, membuat kunjungan, pemeriksaan (TTV & SOAP),
        rujukan, dan resume medis.
      </div>

      <div class="mt-4 flex flex-wrap gap-2">
        <Link
          :href="route('patients.create')"
          class="px-4 py-2 rounded-xl bg-sky-600 text-white text-sm hover:bg-sky-700"
        >
          + Registrasi Pasien
        </Link>

        <Link
          :href="route('visits.create')"
          class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm hover:bg-emerald-700"
        >
          + Registrasi Kunjungan
        </Link>

        <Link
          :href="route('visits.index')"
          class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:bg-slate-800"
        >
          Lihat Kunjungan
        </Link>
      </div>
    </div>

    <!-- QUICK LINKS -->
    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
      <div class="rounded-2xl p-5 bg-white/80 border border-sky-100">
        <div class="text-slate-500 text-sm">Data</div>
        <div class="font-semibold text-slate-900 mt-1">Pasien</div>
        <div class="text-slate-600 text-sm mt-2">Kelola data pasien dan riwayat.</div>
        <Link :href="route('patients.index')" class="inline-block mt-4 text-sky-700 font-semibold text-sm">
          Buka Daftar Pasien →
        </Link>
      </div>

      <div class="rounded-2xl p-5 bg-white/80 border border-sky-100">
        <div class="text-slate-500 text-sm">Layanan</div>
        <div class="font-semibold text-slate-900 mt-1">Kunjungan</div>
        <div class="text-slate-600 text-sm mt-2">TTV, SOAP, tindakan, obat, dokumen klinis.</div>
        <Link :href="route('visits.index')" class="inline-block mt-4 text-emerald-700 font-semibold text-sm">
          Buka Daftar Kunjungan →
        </Link>
      </div>

      <div class="rounded-2xl p-5 bg-white/80 border border-sky-100">
        <div class="text-slate-500 text-sm">Komunikasi</div>
        <div class="font-semibold text-slate-900 mt-1">Rujukan + WhatsApp</div>
        <div class="text-slate-600 text-sm mt-2">Rujukan antar RS & kirim resume via WA.</div>
        <div class="mt-4 text-slate-500 text-sm">
          Masuk dari halaman detail kunjungan.
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card {
  @apply bg-white rounded-xl shadow p-4 text-center;
}
</style>