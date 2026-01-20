<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Preview Resume Medis</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 20px; background: #f5f5f5; }
        .toolbar {
            position: sticky;
            top: 0;
            background: #fff;
            padding: 10px 12px;
            display: flex;
            gap: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: 12px;
        }
        .btn {
            background:#111;
            color:#fff;
            padding:8px 12px;
            border-radius:8px;
            text-decoration:none;
            display:inline-block;
            border:none;
            cursor:pointer;
            font-size: 13px;
        }
        .btn.blue { background:#2563eb; }
        .paper {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 16px;
        }

        @media print {
            body { margin: 0; background: #fff; }
            .toolbar { display: none; }
            .paper { max-width: none; border: none; border-radius: 0; padding: 0; }
        }
    </style>
</head>
<body>

<div class="toolbar">
    <a class="btn" href="{{ route('visits.show', $visit->id) }}">← Kembali</a>

    <button class="btn blue" onclick="window.print()">Cetak (Ctrl+P)</button>

    <a class="btn blue" href="{{ route('visits.resume.pdf', $visit->id) }}">Download PDF</a>
</div>

<div class="paper">
    {{-- reuse konten resume --}}
    @include('pdf._resume_medis_content', ['visit' => $visit])
</div>

</body>
</html>