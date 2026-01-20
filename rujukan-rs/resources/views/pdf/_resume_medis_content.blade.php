<div style="text-align:center; font-size:16px; font-weight:bold; margin-bottom:6px;">
    RESUME MEDIS PASIEN
</div>

<div style="text-align:center; margin-bottom:12px;">
    {{ $visit->hospital->name ?? '-' }}
</div>

<div style="margin-top:12px; font-weight:bold;">A. Identitas Pasien</div>
<table style="width:100%; border-collapse:collapse; margin-top:6px;">
    <tr>
        <td style="border:none; padding:2px;" width="25%">Nama</td>
        <td style="border:none; padding:2px;" width="75%">: {{ $visit->patient->name }}</td>
    </tr>
    <tr>
        <td style="border:none; padding:2px;">NIK</td>
        <td style="border:none; padding:2px;">: {{ $visit->patient->nik ?? '-' }}</td>
    </tr>
    <tr>
        <td style="border:none; padding:2px;">Alamat</td>
        <td style="border:none; padding:2px;">: {{ $visit->patient->address ?? '-' }}</td>
    </tr>
    <tr>
        <td style="border:none; padding:2px;">No HP</td>
        <td style="border:none; padding:2px;">: {{ $visit->patient->phone ?? '-' }}</td>
    </tr>
</table>

<div style="margin-top:12px; font-weight:bold;">B. Data Kunjungan</div>
<table style="width:100%; border-collapse:collapse; margin-top:6px;">
    <tr>
        <td style="border:none; padding:2px;" width="25%">No Rawat</td>
        <td style="border:none; padding:2px;" width="75%">: {{ $visit->no_rawat }}</td>
    </tr>
    <tr>
        <td style="border:none; padding:2px;">Tanggal</td>
        <td style="border:none; padding:2px;">
            : {{ $visit->visit_date ? \Carbon\Carbon::parse($visit->visit_date)->format('d-m-Y H:i') : '-' }}
        </td>
    </tr>
    <tr>
        <td style="border:none; padding:2px;">Poliklinik</td>
        <td style="border:none; padding:2px;">: {{ $visit->department->name ?? '-' }}</td>
    </tr>
</table>

@if($visit->referrals && $visit->referrals->count() > 0)
    <div style="margin-top:12px; font-weight:bold;">C. Informasi Rujukan</div>
    @php $ref = $visit->referrals->first(); @endphp
    <table style="width:100%; border-collapse:collapse; margin-top:6px;">
        <tr>
            <td style="border:none; padding:2px;" width="25%">RS Tujuan</td>
            <td style="border:none; padding:2px;" width="75%">: {{ $ref->toHospital->name ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:none; padding:2px;">Poli Tujuan</td>
            <td style="border:none; padding:2px;">: {{ $ref->toDepartment->name ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:none; padding:2px;">Dokter Tujuan</td>
            <td style="border:none; padding:2px;">: {{ $ref->toUser->name ?? '-' }}</td>
        </tr>
    </table>
@endif

<div style="margin-top:12px; font-weight:bold;">D. Riwayat Pemeriksaan</div>

@foreach($visit->examinations as $idx => $exam)
    <table style="width:100%; border-collapse:collapse; margin-top:10px;">
        <tr>
            <th colspan="4" style="border:1px solid #999; background:#f2f2f2; padding:5px; text-align:left;">
                Pemeriksaan {{ $idx + 1 }}
                ({{ $exam->examined_at ? \Carbon\Carbon::parse($exam->examined_at)->format('d-m-Y H:i') : '-' }})
                - {{ $exam->examiner->name ?? '-' }}
            </th>
        </tr>

        <tr>
            <th colspan="4" style="border:1px solid #999; background:#f9f9f9; padding:5px; text-align:left;">Tanda Vital</th>
        </tr>
        <tr>
            <td style="border:1px solid #999; padding:5px;">TD</td>
            <td style="border:1px solid #999; padding:5px;">{{ $exam->vitalSign?->systolic }}/{{ $exam->vitalSign?->diastolic }}</td>
            <td style="border:1px solid #999; padding:5px;">Nadi</td>
            <td style="border:1px solid #999; padding:5px;">{{ $exam->vitalSign?->pulse }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #999; padding:5px;">RR</td>
            <td style="border:1px solid #999; padding:5px;">{{ $exam->vitalSign?->resp_rate }}</td>
            <td style="border:1px solid #999; padding:5px;">Suhu</td>
            <td style="border:1px solid #999; padding:5px;">{{ $exam->vitalSign?->temperature }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #999; padding:5px;">SpO₂</td>
            <td style="border:1px solid #999; padding:5px;">{{ $exam->vitalSign?->spo2 }}</td>
            <td style="border:1px solid #999; padding:5px;">Nyeri</td>
            <td style="border:1px solid #999; padding:5px;">{{ $exam->vitalSign?->pain_scale }}</td>
        </tr>

        <tr>
            <th colspan="4" style="border:1px solid #999; background:#f9f9f9; padding:5px; text-align:left;">SOAP</th>
        </tr>
        <tr><td colspan="4" style="border:1px solid #999; padding:5px;"><strong>S:</strong> {{ $exam->soapNote?->subjective }}</td></tr>
        <tr><td colspan="4" style="border:1px solid #999; padding:5px;"><strong>O:</strong> {{ $exam->soapNote?->objective }}</td></tr>
        <tr><td colspan="4" style="border:1px solid #999; padding:5px;"><strong>A:</strong> {{ $exam->soapNote?->assessment }}</td></tr>
        <tr><td colspan="4" style="border:1px solid #999; padding:5px;"><strong>P:</strong> {{ $exam->soapNote?->plan }}</td></tr>

        <tr>
            <th colspan="4" style="border:1px solid #999; background:#f9f9f9; padding:5px; text-align:left;">Tindakan</th>
        </tr>
        @forelse($exam->procedures as $p)
            <tr>
                <td colspan="3" style="border:1px solid #999; padding:5px;">{{ $p->procedure->name }}</td>
                <td style="border:1px solid #999; padding:5px;">Qty {{ $p->qty }}</td>
            </tr>
        @empty
            <tr><td colspan="4" style="border:1px solid #999; padding:5px;">Tidak ada tindakan</td></tr>
        @endforelse

        <tr>
            <th colspan="4" style="border:1px solid #999; background:#f9f9f9; padding:5px; text-align:left;">Obat</th>
        </tr>
        @forelse($exam->drugs as $d)
            <tr>
                <td colspan="3" style="border:1px solid #999; padding:5px;">{{ $d->drug->name }}</td>
                <td style="border:1px solid #999; padding:5px;">Qty {{ $d->qty }}</td>
            </tr>
        @empty
            <tr><td colspan="4" style="border:1px solid #999; padding:5px;">Tidak ada obat</td></tr>
        @endforelse
    </table>
@endforeach

<div style="margin-top:12px; font-weight:bold;">E. Dokumen Pendukung (Lab/Radiologi)</div>
<table style="width:100%; border-collapse:collapse; margin-top:6px;">
    <tr>
        <th style="border:1px solid #999; background:#f2f2f2; padding:5px; text-align:left;">Nama File</th>
        <th style="border:1px solid #999; background:#f2f2f2; padding:5px; text-align:left;">Jenis</th>
        <th style="border:1px solid #999; background:#f2f2f2; padding:5px; text-align:left;">Uploader</th>
        <th style="border:1px solid #999; background:#f2f2f2; padding:5px; text-align:left;">Waktu</th>
    </tr>
    @php
        $docs = $visit->examinations->flatMap(fn($e) => $e->documents);
    @endphp

    @forelse($docs as $doc)
        <tr>
            <td style="border:1px solid #999; padding:5px;">{{ $doc->original_name }}</td>
            <td style="border:1px solid #999; padding:5px;">{{ $doc->type }}</td>
            <td style="border:1px solid #999; padding:5px;">{{ $doc->uploader->name ?? '-' }}</td>
            <td style="border:1px solid #999; padding:5px;">
                {{ $doc->created_at ? $doc->created_at->format('d-m-Y H:i') : '-' }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="border:1px solid #999; padding:5px;">Tidak ada dokumen</td>
        </tr>
    @endforelse
</table>