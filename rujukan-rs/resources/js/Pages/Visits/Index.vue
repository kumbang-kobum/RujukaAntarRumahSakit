<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
defineOptions({ layout: AppLayout })
</script>

<template>
  <Head title="Kunjungan" />
  <div class="max-w-5xl mx-auto p-6">
    <div class="flex justify-between mb-4">
      <h1 class="text-2xl font-semibold">Kunjungan</h1>
      <Link class="bg-black text-white px-4 py-2 rounded" :href="route('visits.create')">
        + Kunjungan
      </Link>
    </div>

    <div class="bg-white border rounded">
      <div v-for="v in visits.data" :key="v.id" class="p-4 border-b flex justify-between">
        <div>
          <div class="font-medium">{{ v.no_rawat }}</div>
          <div class="text-sm text-gray-500">Pasien: {{ v.patient?.name }}</div>
        </div>
        <Link class="underline" :href="route('visits.show', v.id)">Detail</Link>
      </div>
    </div>
  </div>
</template>