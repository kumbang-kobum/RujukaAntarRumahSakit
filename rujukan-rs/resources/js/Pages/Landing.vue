<script setup>
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Rujukan Antar RS" />

  <div class="min-h-screen bg-gradient-to-br from-sky-50 via-sky-100 to-emerald-50">
    <div class="max-w-6xl mx-auto px-6 py-10">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-sky-500 to-emerald-500"></div>
          <div>
            <div class="text-slate-900 font-semibold">Rujukan Antar RS</div>
            <div class="text-xs text-slate-500">RSU Handayani</div>
          </div>
        </div>

        <div class="flex gap-2">
          <Link
            :href="route('login')"
            class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:bg-slate-800"
          >
            Login
          </Link>
          <Link
            v-if="route().has('register')"
            :href="route('register')"
            class="px-4 py-2 rounded-xl bg-white/80 border border-sky-100 text-slate-800 text-sm hover:bg-white"
          >
            Register
          </Link>
        </div>
      </div>

      <div class="mt-14 grid lg:grid-cols-2 gap-8 items-center">
        <div class="space-y-4">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/70 border border-sky-100 text-sm text-slate-700">
            <span>⚡</span>
            <span>Koordinasi dokter antar RS + WA otomatis</span>
          </div>

          <h1 class="text-4xl font-bold text-slate-900 leading-tight">
            Sistem Rujukan Pasien Antar Rumah Sakit
          </h1>

          <p class="text-slate-600">
            Registrasi pasien, kunjungan, TTV & SOAP, tindakan & obat, upload berkas lab/radiologi,
            rujukan antar RS, dan resume medis PDF yang bisa dibagikan via WhatsApp.
          </p>

          <div class="flex flex-wrap gap-2 pt-2">
            <Link
              :href="route('login')"
              class="px-5 py-3 rounded-2xl bg-gradient-to-r from-sky-600 to-emerald-600 text-white text-sm font-semibold hover:opacity-95"
            >
              Masuk ke Dashboard
            </Link>

            <a
              href="#fitur"
              class="px-5 py-3 rounded-2xl bg-white/80 border border-sky-100 text-slate-800 text-sm hover:bg-white"
            >
              Lihat Fitur
            </a>
          </div>
        </div>

        <div class="rounded-3xl bg-white/80 border border-sky-100 p-6">
          <div class="text-slate-900 font-semibold">Ringkas fitur utama</div>
          <ul id="fitur" class="mt-4 space-y-3 text-sm text-slate-700">
            <li class="flex gap-2"><span>✅</span> Registrasi pasien & nomor rawat otomatis</li>
            <li class="flex gap-2"><span>✅</span> Pemeriksaan: TTV + SOAP per kunjungan</li>
            <li class="flex gap-2"><span>✅</span> Tindakan & obat + biaya</li>
            <li class="flex gap-2"><span>✅</span> Upload dokumen klinis (lab/radiologi)</li>
            <li class="flex gap-2"><span>✅</span> Rujukan antar RS + koordinasi dokter</li>
            <li class="flex gap-2"><span>✅</span> Resume medis PDF + link share via WA</li>
          </ul>
        </div>
      </div>

      <div class="mt-16 text-xs text-slate-500">
        © {{ new Date().getFullYear() }} RSU Handayani • Sistem Rujukan
      </div>
    </div>
  </div>
</template>