<script setup>
import { Head, useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '', nik: '', phone: ''
})
</script>

<template>
  <Head title="Pasien Baru" />
  <div class="max-w-xl mx-auto p-6">
    <h1 class="text-xl mb-4">Pasien Baru</h1>

    <input v-model="form.name" placeholder="Nama"
      class="w-full border p-2 mb-2 rounded" />

    <input v-model="form.nik" placeholder="NIK"
      class="w-full border p-2 mb-2 rounded" />

    <input v-model="form.phone" placeholder="No HP"
      class="w-full border p-2 mb-2 rounded" />

    <button class="bg-black text-white px-4 py-2 rounded"
      @click="form.post(route('patients.store'))">
      Simpan
    </button>
  </div>
</template>