<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resume Medis</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; line-height: 1.4; }
    </style>
</head>
<body>
    @include('pdf._resume_medis_content', ['visit' => $visit])
</body>
</html>