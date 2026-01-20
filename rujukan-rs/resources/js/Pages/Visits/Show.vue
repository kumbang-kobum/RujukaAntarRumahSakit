<script setup>
import { Head, Link, router } from '@inertiajs/vue3'

const props = defineProps({
  visit: Object,
  examinations: { type: Array, default: () => [] },
  catalogProcedures: { type: Array, default: () => [] },
  catalogDrugs: { type: Array, default: () => [] },
})

/* ========= Pemeriksaan ========= */
function addExamination() {
  router.post(`/visits/${props.visit.id}/examinations`)
}

/* ========= TTV ========= */
function ensureVital(exam) {
  if (!exam.vitalSign) {
    exam.vitalSign = {
      systolic: '',
      diastolic: '',
      pulse: '',
      resp_rate: '',
      temperature: '',
      spo2: '',
      weight: '',
      height: '',
      pain_scale: '',
    }
  }
}
function submitTTV(exam) {
  ensureVital(exam)
  router.post(`/examinations/${exam.id}/vital-signs`, exam.vitalSign)
}

/* ========= SOAP ========= */
function ensureSoap(exam) {
  if (!exam.soapNote) {
    exam.soapNote = {
      subjective: '',
      objective: '',
      assessment: '',
      plan: '',
    }
  }
}
function submitSOAP(exam) {
  ensureSoap(exam)
  router.post(`/examinations/${exam.id}/soap`, exam.soapNote)
}

/* ========= Tindakan ========= */
function ensureProcedureForm(exam) {
  if (!exam._procedureForm) {
    exam._procedureForm = { procedure_id: '', qty: 1, note: '' }
  }
}
function submitProcedure(exam) {
  ensureProcedureForm(exam)
  router.post(`/examinations/${exam.id}/procedures`, exam._procedureForm)
}

/* ========= Obat ========= */
function ensureDrugForm(exam) {
  if (!exam._drugForm) {
    exam._drugForm = { drug_id: '', qty: 1, note: '' }
  }
}
function submitDrug(exam) {
  ensureDrugForm(exam)
  router.post(`/examinations/${exam.id}/drugs`, exam._drugForm)
}

function ensureDocForm(exam) {
  if (!exam._docForm) {
    exam._docForm = { type: 'lab', title: '', file: null }
  }
}

function submitDocument(exam) {
  ensureDocForm(exam)
  const fd = new FormData()
  fd.append('type', exam._docForm.type)
  fd.append('title', exam._docForm.title)
  fd.append('file', exam._docForm.file)

  router.post(`/examinations/${exam.id}/documents`, fd)
}
</script>

<template>
  <Head :title="visit.no_rawat" />

  <div class="max-w-5xl mx-auto p-6 space-y-4">
    <div class="flex justify-between items-start">
      <div>
        <h1 class="text-2xl font-semibold">{{ visit.no_rawat }}</h1>
        <div class="text-sm text-gray-500">Pasien: {{ visit.patient?.name }}</div>
      </div>

      <button class="bg-black text-white px-4 py-2 rounded" @click="addExamination">
        + Tambah Pemeriksaan
      </button>

    <Link
    class="bg-blue-600 text-white px-4 py-2 rounded"
    :href="route('referrals.create', visit.id)"
    >
    Rujuk ke RS lain
    </Link>

    <button
    v-if="visit.status !== 'closed'"
    class="bg-red-600 text-white px-4 py-2 rounded"
    @click="router.post(`/visits/${visit.id}/close`)"
  >
    Tutup & Buat Nota
  </button>

  <a
    v-else
    class="underline text-sm"
    :href="`/billings/${visit.billing?.id}`"
  >
    Lihat Nota
  </a>

    </div>

    <div class="bg-white border rounded">
      <div v-if="examinations.length === 0" class="p-4 text-sm text-gray-500">
        Belum ada pemeriksaan.
      </div>

      <div v-for="exam in examinations" :key="exam.id" class="p-4 border-b last:border-b-0">
        <div class="font-medium">Pemeriksaan {{ exam.examined_at }}</div>
        <div class="text-sm text-gray-500">Dokter: {{ exam.examiner?.name }}</div>
        <div class="text-sm">Status: <strong>{{ exam.status }}</strong></div>

        <!-- TTV -->
        <div class="mt-3 border rounded p-3 bg-gray-50">
          <div class="font-medium mb-2">TTV</div>

          <!-- pastikan vitalSign ada saat form difokus/di-render -->
          <div class="hidden">{{ ensureVital(exam) }}</div>

          <form @submit.prevent="submitTTV(exam)">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
              <input v-model="exam.vitalSign.systolic" placeholder="Sistolik" class="border p-2 rounded" />
              <input v-model="exam.vitalSign.diastolic" placeholder="Diastolik" class="border p-2 rounded" />
              <input v-model="exam.vitalSign.pulse" placeholder="Nadi" class="border p-2 rounded" />
              <input v-model="exam.vitalSign.resp_rate" placeholder="RR" class="border p-2 rounded" />
              <input v-model="exam.vitalSign.temperature" placeholder="Suhu" class="border p-2 rounded" />
              <input v-model="exam.vitalSign.spo2" placeholder="SpO₂" class="border p-2 rounded" />
              <input v-model="exam.vitalSign.weight" placeholder="BB" class="border p-2 rounded" />
              <input v-model="exam.vitalSign.height" placeholder="TB" class="border p-2 rounded" />
              <input v-model="exam.vitalSign.pain_scale" placeholder="Nyeri (0-10)" class="border p-2 rounded" />
            </div>

            <button class="mt-2 px-3 py-2 bg-black text-white rounded">
              Simpan TTV
            </button>
          </form>
        </div>

        <!-- SOAP -->
        <div class="mt-4 border rounded p-3 bg-white">
        <div class="font-medium mb-2">SOAP</div>

        <div class="hidden">{{ ensureSoap(exam) }}</div>

        <form @submit.prevent="submitSOAP(exam)">
            <textarea v-model="exam.soapNote.subjective"
            placeholder="Subjective"
            class="w-full border rounded p-2 mb-2" rows="2" />

            <textarea v-model="exam.soapNote.objective"
            placeholder="Objective"
            class="w-full border rounded p-2 mb-2" rows="2" />

            <textarea v-model="exam.soapNote.assessment"
            placeholder="Assessment"
            class="w-full border rounded p-2 mb-2" rows="2" />

            <textarea v-model="exam.soapNote.plan"
            placeholder="Plan"
            class="w-full border rounded p-2 mb-2" rows="2" />

            <button class="px-3 py-2 bg-black text-white rounded">
            Simpan SOAP
            </button>
        </form>
        </div>

        <!-- TINDAKAN -->
        <div class="mt-4 border rounded p-3 bg-white">
        <div class="font-medium mb-2">Tindakan</div>

        <div class="hidden">{{ ensureProcedureForm(exam) }}</div>

        <form class="grid grid-cols-1 md:grid-cols-4 gap-2" @submit.prevent="submitProcedure(exam)">
            <select v-model="exam._procedureForm.procedure_id" class="border p-2 rounded md:col-span-2">
            <option value="">-- pilih tindakan --</option>
            <option v-for="p in catalogProcedures" :key="p.id" :value="p.id">
                {{ p.name }} (Rp {{ p.default_price }})
            </option>
            </select>

            <input v-model="exam._procedureForm.qty" type="number" min="1" class="border p-2 rounded" placeholder="Qty" />
            <button class="bg-black text-white rounded px-3 py-2">Tambah</button>

            <input v-model="exam._procedureForm.note" class="border p-2 rounded md:col-span-4" placeholder="Catatan (opsional)" />
        </form>

        <div class="mt-3 text-sm">
            <div v-if="exam.procedures?.length === 0" class="text-gray-500">Belum ada tindakan.</div>

            <div v-for="it in exam.procedures" :key="it.id" class="flex justify-between border-b py-1">
            <div>
                <div class="font-medium">{{ it.procedure?.name }}</div>
                <div class="text-gray-500">Qty {{ it.qty }} × Rp {{ it.price }}</div>
            </div>
            <div class="font-semibold">
                Rp {{ (Number(it.qty) * Number(it.price)).toFixed(0) }}
            </div>
            </div>
        </div>

        <!-- OBAT -->
        <div class="mt-4 border rounded p-3 bg-white">
        <div class="font-medium mb-2">Obat</div>

        <div class="hidden">{{ ensureDrugForm(exam) }}</div>

        <form class="grid grid-cols-1 md:grid-cols-4 gap-2" @submit.prevent="submitDrug(exam)">
            <select v-model="exam._drugForm.drug_id" class="border p-2 rounded md:col-span-2">
            <option value="">-- pilih obat --</option>
            <option v-for="d in catalogDrugs" :key="d.id" :value="d.id">
                {{ d.name }} (Rp {{ d.default_price }})
            </option>
            </select>

            <input v-model="exam._drugForm.qty" type="number" min="1" class="border p-2 rounded" placeholder="Qty" />
            <button class="bg-black text-white rounded px-3 py-2">Tambah</button>

            <input v-model="exam._drugForm.note" class="border p-2 rounded md:col-span-4" placeholder="Catatan (opsional)" />
        </form>

        <div class="mt-3 text-sm">
            <div v-if="exam.drugs?.length === 0" class="text-gray-500">Belum ada obat.</div>

            <div v-for="it in exam.drugs" :key="it.id" class="flex justify-between border-b py-1">
            <div>
                <div class="font-medium">{{ it.drug?.name }}</div>
                <div class="text-gray-500">Qty {{ it.qty }} × Rp {{ it.price }}</div>
            </div>
            <div class="font-semibold">
                Rp {{ (Number(it.qty) * Number(it.price)).toFixed(0) }}
            </div>
            </div>
        </div>

        <!-- DOKUMEN -->
        <div class="mt-4 border rounded p-3 bg-white">
        <div class="font-medium mb-2">Dokumen (Lab / Radiologi)</div>

        <div class="hidden">{{ ensureDocForm(exam) }}</div>

        <form @submit.prevent="submitDocument(exam)" class="grid grid-cols-1 md:grid-cols-4 gap-2">
            <select v-model="exam._docForm.type" class="border p-2 rounded">
            <option value="lab">Lab</option>
            <option value="radiology">Radiologi</option>
            <option value="other">Lainnya</option>
            </select>

            <input v-model="exam._docForm.title" class="border p-2 rounded md:col-span-2" placeholder="Judul dokumen" />
            <input type="file" class="border p-2 rounded"
            @change="e => exam._docForm.file = e.target.files[0]" />

            <button class="bg-black text-white rounded px-3 py-2 md:col-span-4">
            Upload
            </button>
        </form>

        <div class="mt-3 text-sm">
            <div v-if="exam.documents?.length === 0" class="text-gray-500">
            Belum ada dokumen.
            </div>

            <div v-for="doc in exam.documents" :key="doc.id" class="flex justify-between border-b py-1">
            <div>
                <div class="font-medium">{{ doc.title }}</div>
                <div class="text-gray-500">
                {{ doc.type }} · {{ doc.original_name }}
                </div>
            </div>

            <a class="underline text-sm" :href="`/documents/${doc.id}/download`">
                Download
            </a>
            </div>
        </div>
        </div>

                <!-- NOTA PEMBAYARAN -->
        <div class="mt-6 border rounded p-4 bg-white">
        <h2 class="font-semibold text-lg mb-2">Nota Pembayaran</h2>

        <div class="text-sm space-y-1">
            <div
            v-for="exam in examinations"
            :key="exam.id"
            class="border-b pb-2 mb-2"
            >
            <!-- button pemeriksaan -->
            <div class="font-medium">Pemeriksaan {{ exam.examined_at }}</div>
            
            <div v-for="p in exam.procedures" :key="'p'+p.id" class="flex justify-between">
                <span>{{ p.procedure?.name }} ({{ p.qty }})</span>
                <span>Rp {{ (p.qty * p.price).toLocaleString() }}</span>
            </div>

            <div v-for="d in exam.drugs" :key="'d'+d.id" class="flex justify-between">
                <span>{{ d.drug?.name }} ({{ d.qty }})</span>
                <span>Rp {{ (d.qty * d.price).toLocaleString() }}</span>
            </div>
            </div>

            <div class="flex justify-between font-semibold text-lg pt-2 border-t">
            <span>Total</span>
            <span>Rp {{ visit.total_cost?.toLocaleString() }}</span>
            </div>
        </div>
        </div>

        <div class="bg-white border rounded p-4">
        <div class="font-medium mb-2">Rujukan</div>

        <div v-if="!visit.referrals || visit.referrals.length === 0" class="text-sm text-gray-500">
            Belum ada rujukan.
        </div>

        <div v-for="r in visit.referrals" :key="r.id" class="border-b last:border-b-0 py-2 text-sm">
            <div class="font-medium">
            Tujuan: {{ r.to_hospital?.name }}
            <span v-if="r.to_department">· {{ r.to_department.name }}</span>
            <span v-if="r.to_user">· {{ r.to_user.name }}</span>
            </div>
            <div class="text-gray-500">Status: {{ r.status }}</div>
            <div v-if="r.reason">Alasan: {{ r.reason }}</div>
        </div>
        </div>

        </div>
        </div>
      </div>
    </div>

    <Link class="underline text-sm" :href="route('visits.index')">
      ← Kembali ke daftar kunjungan
    </Link>
  </div>
</template>