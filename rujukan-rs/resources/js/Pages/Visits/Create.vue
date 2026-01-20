<script setup>
import { Head, useForm } from '@inertiajs/vue3'
defineProps({ patients: Array, departments: Array })

const form = useForm({
  patient_id: '',
  department_id: '',
})
</script>

<template>
  <Head title="Kunjungan Baru" />
  <div class="max-w-xl mx-auto p-6">
    <h1 class="text-xl mb-4">Kunjungan Baru</h1>

    <select v-model="form.patient_id" class="w-full border p-2 mb-2 rounded">
      <option value="">-- Pilih Pasien --</option>
      <option v-for="p in patients" :key="p.id" :value="p.id">{{ p.name }}</option>
    </select>

    <select v-model="form.department_id" class="w-full border p-2 mb-4 rounded">
      <option value="">-- Pilih Poli --</option>
      <option v-for="d in departments" :key="d.id" :value="d.id">{{ d.name }}</option>
    </select>

    <button class="bg-black text-white px-4 py-2 rounded"
      @click="form.post(route('visits.store'))">
      Simpan & Generate No Rawat
    </button>
  </div>
</template>