<script setup>
import { Head } from '@inertiajs/vue3'
defineProps({ patient: Object, visits: Array })
</script>

<template>
  <Head title="Riwayat Pasien" />

  <div class="max-w-5xl mx-auto p-6">
    <h1 class="text-xl font-semibold mb-4">
      Riwayat {{ patient.name }}
    </h1>

    <div v-for="v in visits" :key="v.id" class="border rounded mb-4 p-4 bg-white">
      <div class="font-medium">{{ v.no_rawat }} · {{ v.visit_date }}</div>

      <div v-for="exam in v.examinations" :key="exam.id" class="mt-2 text-sm">
        <div class="font-medium">Pemeriksaan</div>

        <div v-for="p in exam.procedures" :key="'p'+p.id">
          {{ p.procedure?.name }} ({{ p.qty }})
        </div>

        <div v-for="d in exam.drugs" :key="'d'+d.id">
          {{ d.drug?.name }} ({{ d.qty }})
        </div>
      </div>
    </div>
  </div>
</template>