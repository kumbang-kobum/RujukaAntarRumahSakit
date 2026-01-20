<script setup>
import { Head, Link } from '@inertiajs/vue3'
defineProps({ patients: Object })
</script>

<template>
  <Head title="Pasien" />
  <div class="max-w-5xl mx-auto p-6">
    <div class="flex justify-between mb-4">
      <h1 class="text-2xl font-semibold">Pasien</h1>
      <Link class="bg-black text-white px-4 py-2 rounded" :href="route('patients.create')">
        + Pasien
      </Link>
    </div>

    <div class="bg-white border rounded">
      <div v-for="p in patients.data" :key="p.id" class="p-4 border-b flex justify-between">
        <div>
          <div class="font-medium">{{ p.name }}</div>
          <div class="text-sm text-gray-500">NIK: {{ p.nik ?? '-' }}</div>
        </div>
        <Link class="underline" :href="route('patients.show', p.id)">Detail</Link>
      </div>
    </div>
  </div>
</template>