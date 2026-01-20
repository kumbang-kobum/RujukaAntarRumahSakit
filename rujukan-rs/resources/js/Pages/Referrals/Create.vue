<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const props = defineProps({
  visit: Object,
  hospitals: Array,
})

const departments = ref([])
const doctors = ref([])

const form = useForm({
  to_hospital_id: '',
  to_department_id: '',
  to_user_id: '',
  reason: '',
  notes: '',
})

watch(() => form.to_hospital_id, async (val) => {
  form.to_department_id = ''
  form.to_user_id = ''
  departments.value = []
  doctors.value = []
  if (!val) return

  const res = await fetch(`/referrals/options?hospital_id=${val}`)
  const json = await res.json()
  departments.value = json.departments ?? []
  doctors.value = json.doctors ?? []
})

function submit() {
  form.post(`/visits/${props.visit.id}/referrals`)
}
</script>

<template>
  <Head title="Rujukan Pasien" />

  <div class="max-w-3xl mx-auto p-6 space-y-4">
    <div class="flex justify-between items-start">
      <div>
        <h1 class="text-2xl font-semibold">Rujukan Pasien</h1>
        <div class="text-sm text-gray-500">
          {{ visit.no_rawat }} · {{ visit.patient?.name }}
        </div>
      </div>

      <Link class="underline text-sm" :href="`/visits/${visit.id}`">Kembali</Link>
    </div>

    <div class="bg-white border rounded p-4 space-y-3">
      <div>
        <label class="text-sm text-gray-600">Rumah sakit tujuan</label>
        <select v-model="form.to_hospital_id" class="w-full border p-2 rounded">
          <option value="">-- pilih RS --</option>
          <option v-for="h in hospitals" :key="h.id" :value="h.id">
            {{ h.name }}
          </option>
        </select>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label class="text-sm text-gray-600">Poli tujuan (opsional)</label>
          <select v-model="form.to_department_id" class="w-full border p-2 rounded">
            <option value="">-- pilih poli --</option>
            <option v-for="d in departments" :key="d.id" :value="d.id">
              {{ d.name }}
            </option>
          </select>
        </div>

        <div>
          <label class="text-sm text-gray-600">Dokter tujuan (opsional)</label>
          <select v-model="form.to_user_id" class="w-full border p-2 rounded">
            <option value="">-- pilih dokter --</option>
            <option v-for="u in doctors" :key="u.id" :value="u.id">
              {{ u.name }}
            </option>
          </select>
        </div>
      </div>

      <div>
        <label class="text-sm text-gray-600">Alasan rujuk</label>
        <textarea v-model="form.reason" class="w-full border p-2 rounded" rows="2"></textarea>
      </div>

      <div>
        <label class="text-sm text-gray-600">Catatan tambahan</label>
        <textarea v-model="form.notes" class="w-full border p-2 rounded" rows="2"></textarea>
      </div>

      <button class="bg-black text-white px-4 py-2 rounded" @click="submit">
        Kirim Rujukan
      </button>
    </div>
  </div>
</template>