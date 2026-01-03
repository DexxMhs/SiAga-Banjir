<!DOCTYPE html>
<html>

<head>
    <title>Laporan Rekapitulasi Banjir</title>
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
            color: #666;
        }

        .meta {
            margin-bottom: 15px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            color: white;
            display: inline-block;
        }

        .bg-red {
            background-color: #ef4444;
        }

        .bg-blue {
            background-color: #3b82f6;
        }

        .bg-green {
            background-color: #10b981;
        }

        .bg-orange {
            background-color: #f97316;
        }

        .bg-gray {
            background-color: #6b7280;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: 20px;
            color: #444;
            border-left: 4px solid #607afb;
            padding-left: 8px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 9px;
            text-align: right;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Sistem Monitoring & Pelaporan Banjir</h1>
        <p>Laporan Resmi Rekapitulasi Data</p>
    </div>

    <div class="meta">
        <strong>Tanggal Cetak:</strong> {{ now()->format('d F Y, H:i') }} <br>
        <strong>Periode Data:</strong>
        {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : 'Awal' }}
        s/d
        {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : 'Hari Ini' }}
    </div>

    <div class="section-title">A. Laporan Petugas Lapangan ({{ $officerReports->count() }})</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Waktu</th>
                <th style="width: 15%">Kode</th>
                <th style="width: 20%">Pos Pantau</th>
                <th style="width: 10%">Tinggi Air</th>
                <th style="width: 10%">Status</th>
                <th style="width: 10%">Validasi</th>
                <th style="width: 15%">Petugas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($officerReports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $report->report_code }}</td>
                    <td>{{ $report->station->name ?? '-' }}</td>
                    <td>{{ $report->water_level }} cm</td>
                    <td>
                        @php
                            $color = match ($report->calculated_status) {
                                'awas' => 'bg-red',
                                'siaga' => 'bg-orange',
                                default => 'bg-green',
                            };
                        @endphp
                        <span class="badge {{ $color }}">{{ strtoupper($report->calculated_status) }}</span>
                    </td>
                    <td>{{ ucfirst($report->validation_status) }}</td>
                    <td>{{ $report->officer->name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; font-style: italic;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">B. Laporan Masyarakat ({{ $publicReports->count() }})</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Waktu</th>
                <th style="width: 15%">Kode</th>
                <th style="width: 25%">Lokasi</th>
                <th style="width: 15%">Tinggi Air</th>
                <th style="width: 10%">Status</th>
                <th style="width: 15%">Pelapor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($publicReports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $report->report_code }}</td>
                    <td>{{ $report->location }}</td>
                    <td>{{ $report->water_level }} cm</td>
                    <td>
                        @php
                            $color = match ($report->status) {
                                'emergency' => 'bg-red',
                                'diproses' => 'bg-blue',
                                'selesai' => 'bg-green',
                                default => 'bg-orange',
                            };
                        @endphp
                        <span class="badge {{ $color }}">{{ strtoupper($report->status) }}</span>
                    </td>
                    <td>{{ $report->user->name ?? 'Anonim' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; font-style: italic;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh Sistem Admin | Halaman <span class="page-number"></span>
    </div>

</body>

</html>
