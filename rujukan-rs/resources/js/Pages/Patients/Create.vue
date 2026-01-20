<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, useForm, Link } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

const form = useForm({
  nik: '',
  name: '',
  dob: '',
  gender: '',
  address_detail: '',
  phone: '',
})

function submit() {
  form.post(route('patients.store'))
}
</script>

<template>
  <Head title="Pasien Baru" />

  <div class="space-y-6">
    <div class="rounded-2xl bg-white/80 border border-sky-100 p-6">
      <div class="flex items-start justify-between gap-4">
        <div>
          <h1 class="text-2xl font-semibold text-slate-900">Pasien Baru</h1>
          <p class="text-sm text-slate-600 mt-1">
            Lengkapi identitas pasien sesuai data yang tersedia.
          </p>
        </div>
        <Link :href="route('patients.index')" class="text-sm font-semibold text-sky-700 hover:underline">
          ← Kembali
        </Link>
      </div>

      <form class="mt-6 space-y-4" @submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="label">NIK</label>
            <input v-model="form.nik" class="input" placeholder="NIK (opsional)" />
            <div v-if="form.errors.nik" class="err">{{ form.errors.nik }}</div>
          </div>

          <div>
            <label class="label">Nama</label>
            <input v-model="form.name" class="input" placeholder="Nama pasien" />
            <div v-if="form.errors.name" class="err">{{ form.errors.name }}</div>
          </div>

          <div>
            <label class="label">Tanggal Lahir</label>
            <input v-model="form.dob" type="date" class="input" />
            <div v-if="form.errors.dob" class="err">{{ form.errors.dob }}</div>
          </div>

          <div>
            <label class="label">Jenis Kelamin</label>
            <select v-model="form.gender" class="input">
              <option value="">- pilih -</option>
              <option value="M">Laki-laki</option>
              <option value="F">Perempuan</option>
            </select>
            <div v-if="form.errors.gender" class="err">{{ form.errors.gender }}</div>
          </div>

          <div class="md:col-span-2">
            <label class="label">Alamat Detail</label>
            <textarea v-model="form.address_detail" rows="3" class="input" placeholder="Alamat lengkap (opsional)"></textarea>
            <div v-if="form.errors.address_detail" class="err">{{ form.errors.address_detail }}</div>
          </div>

          <div>
            <label class="label">No HP</label>
            <input v-model="form.phone" class="input" placeholder="08xxxx / 62xxxx" />
            <div v-if="form.errors.phone" class="err">{{ form.errors.phone }}</div>
          </div>
        </div>

        <div class="pt-2 flex gap-2">
          <button class="btn-primary" :disabled="form.processing">
            Simpan
          </button>
          <Link :href="route('patients.index')" class="btn-ghost">
            Batal
          </Link>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.label { @apply block text-sm font-semibold text-slate-700 mb-1; }
.input { @apply w-full rounded-xl border border-slate-200 bg-white/90 px-3 py-2 text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-200; }
.err { @apply mt-1 text-xs text-red-600; }
.btn-primary { @apply px-4 py-2 rounded-xl bg-sky-600 text-white text-sm font-semibold hover:bg-sky-700 disabled:opacity-50; }
.btn-ghost { @apply px-4 py-2 rounded-xl border border-slate-200 bg-white/70 text-sm font-semibold text-slate-700 hover:bg-white; }
</style>