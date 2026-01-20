<script setup>
import { Head, Link } from '@inertiajs/vue3'
defineProps({ patient: Object, visits: Array })
</script>

<template>
  <Head :title="patient.name" />
  <div class="max-w-5xl mx-auto p-6 space-y-4">
    <div>
      <h1 class="text-2xl font-semibold">{{ patient.name }}</h1>
      <div class="text-sm text-gray-500">
        NIK: {{ patient.nik ?? '-' }} | HP: {{ patient.phone ?? '-' }}
      </div>
    </div>

    <div class="bg-white border rounded p-4">
      <div class="flex justify-between mb-2">
        <div class="font-medium">Riwayat Kunjungan</div>
        <Link class="underline" :href="route('visits.create')">+ Kunjungan</Link>
      </div>

      <div v-for="v in visits" :key="v.id" class="border-b py-2">
        <Link :href="route('visits.show', v.id)">
          {{ v.no_rawat }} – {{ v.visit_date }}
        </Link>
      </div>
    </div>
  </div>
</template>