<!DOCTYPE html>
<html>

<head>
    <title>Laporan Masyarakat #{{ $report->report_code }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
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
            font-weight: 800;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
            color: #666;
        }

        /* Styling Status Box Updated */
        .status-box {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-emergency {
            color: #dc2626;
            /* Merah */
            border-color: #dc2626;
            background-color: #fef2f2;
        }

        .status-selesai {
            color: #059669;
            /* Hijau */
            border-color: #059669;
            background-color: #ecfdf5;
        }

        .status-diproses {
            color: #2563eb;
            /* Biru */
            border-color: #2563eb;
            background-color: #eff6ff;
        }

        .status-pending {
            color: #4b5563;
            /* Abu-abu */
            border-color: #9ca3af;
            background-color: #f3f4f6;
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
            color: #555;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-top: 25px;
            color: #111;
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
            font-weight: bold;
        }

        .note-box {
            border: 1px solid #ddd;
            padding: 10px;
            background: #fafafa;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .note-label {
            font-weight: bold;
            font-size: 11px;
            display: block;
            margin-bottom: 4px;
            color: #666;
            text-transform: uppercase;
        }

        .photo-container {
            text-align: center;
            margin-top: 10px;
            border: 1px solid #eee;
            padding: 10px;
        }

        .photo-container img {
            max-width: 100%;
            max-height: 400px;
            /* Batasi tinggi agar tidak memakan satu halaman penuh */
            height: auto;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }

        .signature {
            display: inline-block;
            text-align: center;
            width: 200px;
        }

        .signature-line {
            margin-top: 70px;
            border-top: 1px solid #333;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Laporan Masyarakat</h1>
        <p>Arsip Digital Sistem Monitoring Banjir</p>
        <p>ID Dokumen: {{ $report->report_code }} | Dicetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    {{-- Logika Penentuan Class Warna CSS --}}
    @php
        $statusClass = match ($report->status) {
            'emergency' => 'status-emergency',
            'selesai' => 'status-selesai',
            'diproses' => 'status-diproses',
            default => 'status-pending',
        };

        $statusLabel = match ($report->status) {
            'emergency' => 'DARURAT (EMERGENCY)',
            'selesai' => 'SELESAI / TERATASI',
            'diproses' => 'SEDANG DIPROSES',
            default => 'MENUNGGU VERIFIKASI',
        };
    @endphp

    <div class="status-box {{ $statusClass }}">
        STATUS LAPORAN: {{ $statusLabel }}
    </div>

    <table class="meta-table">
        <tr>
            <td class="label">Kode Laporan</td>
            <td>: <strong>{{ $report->report_code }}</strong></td>

            <td class="label">Waktu Lapor</td>
            <td>: {{ $report->created_at->translatedFormat('d F Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td class="label">Nama Pelapor</td>
            <td>: {{ $report->user->name ?? 'User Terhapus' }}</td>

            <td class="label">Lokasi Kejadian</td>
            <td>: {{ $report->location }}</td>
        </tr>
    </table>

    <div class="section-title">Detail Teknis</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30%">Parameter</th>
                <th style="width: 70%">Informasi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Estimasi Tinggi Air</td>
                <td><strong>{{ $report->water_level }} cm</strong></td>
            </tr>
            <tr>
                <td>Koordinat Lokasi</td>
                <td>
                    Latitude: {{ $report->latitude }} <br>
                    Longitude: {{ $report->longitude }}
                </td>
            </tr>
            <tr>
                <td>Status Validasi</td>
                <td>
                    {{ ucfirst($report->status) }}
                    @if ($report->validated_by)
                        <small>(Divalidasi oleh: {{ $report->validator->name }})</small>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Catatan & Keterangan</div>

    {{-- Catatan Pelapor --}}
    <div class="note-box">
        <span class="note-label">Catatan dari Pelapor:</span>
        {{ $report->note ?? '-' }}
    </div>

    {{-- Catatan Admin (Penting untuk Print Out) --}}
    @if ($report->admin_note)
        <div class="note-box" style="background-color: #f0fdf4; border-color: #bbf7d0;">
            <span class="note-label">Tindak Lanjut / Catatan Admin:</span>
            {{ $report->admin_note }}
        </div>
    @endif

    @if ($report->photo)
        <div class="section-title">Bukti Foto</div>
        <div class="photo-container">
            {{-- Pastikan file ada sebelum dirender agar tidak error di DOMPDF --}}
            @if (file_exists(public_path('storage/' . $report->photo)))
                <img src="{{ public_path('storage/' . $report->photo) }}" alt="Foto Bukti">
            @else
                <p style="color: red; font-style: italic;">(File foto tidak ditemukan di server)</p>
            @endif
        </div>
    @endif

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,<br>Admin Verifikator</p>
            <div class="signature-line"></div>
            <p style="font-weight: bold;">{{ $report->validator->name ?? '( ..................... )' }}</p>
            <p style="font-size: 10px; margin-top: -10px;">{{ $report->updated_at->format('d/m/Y') }}</p>
        </div>
    </div>

</body>

</html>
