<script setup>
import { Head, Link } from '@inertiajs/vue3'

defineProps({
  billing: Object,
})
</script>

<template>
  <Head title="Nota Pembayaran" />

  <div class="max-w-4xl mx-auto p-6 space-y-4">
    <div class="flex justify-between items-start">
      <div>
        <h1 class="text-2xl font-semibold">Nota Pembayaran</h1>
        <div class="text-sm text-gray-500">
          No Rawat: {{ billing.visit?.no_rawat }} · Pasien: {{ billing.visit?.patient?.name }}
        </div>
      </div>

      <Link class="underline text-sm" :href="`/visits/${billing.visit_id}`">Kembali</Link>
    </div>

    <div class="bg-white border rounded">
      <div class="p-4 border-b font-medium">Detail</div>

      <div class="p-4 space-y-2">
        <div v-for="it in billing.items" :key="it.id" class="flex justify-between text-sm">
          <div>
            <div class="font-medium">{{ it.name }}</div>
            <div class="text-gray-500">{{ it.type }} · Qty {{ it.qty }} × Rp {{ Number(it.price).toLocaleString() }}</div>
          </div>
          <div class="font-semibold">
            Rp {{ Number(it.total).toLocaleString() }}
          </div>
        </div>

        <div class="border-t pt-3 space-y-1 text-sm">
          <div class="flex justify-between">
            <span>Subtotal</span>
            <span>Rp {{ Number(billing.subtotal).toLocaleString() }}</span>
          </div>
          <div class="flex justify-between">
            <span>Diskon</span>
            <span>Rp {{ Number(billing.discount).toLocaleString() }}</span>
          </div>
          <div class="flex justify-between font-semibold text-lg">
            <span>Total</span>
            <span>Rp {{ Number(billing.total).toLocaleString() }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- PDF nanti kita tambah tombol di sini -->
    <a
    class="bg-black text-white px-4 py-2 rounded inline-block"
    :href="`/billings/${billing.id}/pdf`"
    >
    Download PDF
    </a>
  </div>
</template>