<!DOCTYPE html>
<html>

<head>
    <title>Laporan #{{ $report->report_code }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .meta-table td {
            padding: 5px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 130px;
        }

        .status-box {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .status-awas {
            color: #dc2626;
            border-color: #dc2626;
            background-color: #fef2f2;
        }

        .status-siaga {
            color: #d97706;
            border-color: #d97706;
            background-color: #fffbeb;
        }

        .status-normal {
            color: #059669;
            border-color: #059669;
            background-color: #ecfdf5;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-top: 20px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .data-table th {
            background-color: #f2f2f2;
        }

        .photo-gallery {
            width: 100%;
            margin-top: 10px;
        }

        .photo-item {
            display: inline-block;
            width: 30%;
            margin-right: 2%;
            vertical-align: top;
        }

        .photo-item img {
            width: 100%;
            height: auto;
            border: 1px solid #999;
        }

        .footer {
            margin-top: 10px;
            text-align: right;
        }

        .signature {
            display: inline-block;
            text-align: center;
            width: 200px;
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #333;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Laporan Pemantauan Banjir</h1>
        <p>Sistem Informasi Monitoring Debit Air & Curah Hujan</p>
        <p>Dicetak pada: {{ date('d F Y, H:i') }}</p>
    </div>

    <div class="status-box status-{{ $report->calculated_status }}">
        STATUS SAAT INI: {{ strtoupper($report->calculated_status) }}
        <br>
        <span style="font-size: 10px; font-weight: normal; color: #555;">Ketinggian Air: {{ $report->water_level }}
            cm</span>
    </div>

    <table class="meta-table">
        <tr>
            <td class="label">Kode Laporan</td>
            <td>: <strong>{{ $report->report_code }}</strong></td>
            <td class="label">Waktu Lapor</td>
            <td>: {{ $report->created_at->translatedFormat('d F Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td class="label">Petugas Lapangan</td>
            <td>: {{ $report->officer->name }} ({{ $report->officer->nomor_induk }})</td>
            <td class="label">Lokasi Pos</td>
            <td>: {{ $report->station->name }}</td>
        </tr>
    </table>

    <div class="section-title">Data Teknis</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Parameter</th>
                <th>Nilai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tinggi Muka Air</td>
                <td>{{ $report->water_level }} cm</td>
                <td>Batas Awas: {{ $report->station->threshold_awas ?? '-' }} cm</td>
            </tr>
            <tr>
                <td>Curah Hujan</td>
                <td>{{ $report->rainfall ?? '0' }} mm</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Status Pompa</td>
                <td>{{ $report->pump_status ?? '-' }}</td>
                <td>-</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Catatan Lapangan</div>
    <div style="border: 1px solid #ddd; padding: 10px; min-height: 50px; background: #fafafa;">
        {{ $report->note ?? 'Tidak ada catatan khusus.' }}
    </div>

    @if ($report->photo)
        <div class="section-title">Bukti Foto</div>
        <div class="photo-gallery">
            <div class="photo-item">
                {{-- Gunakan public_path agar DOMPDF bisa membaca file lokal --}}
                <img src="{{ public_path('storage/' . $report->photo) }}" alt="Foto Bukti">
            </div>
        </div>
    @endif

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,<br>Admin Verifikator</p>
            <div class="signature-line"></div>
            <p>{{ $report->validator->name ?? '( Belum Divalidasi )' }}</p>
        </div>
    </div>

</body>

</html>
