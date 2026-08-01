<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $surat->jenis_surat?->label() }} - {{ $surat->nomor_surat }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
            margin: 2cm;
            font-size: 12pt;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .border-b-2 { border-bottom: 2px solid black; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-8 { margin-bottom: 2rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-8 { margin-top: 2rem; }
        
        .header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid black;
            position: relative;
        }
        .header h1 {
            font-size: 16pt;
            margin: 0;
            padding: 0;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 18pt;
            margin: 0;
            padding: 0;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            font-size: 11pt;
        }
        
        .title-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .surat-title {
            text-decoration: underline;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }
        .surat-number {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-data td {
            vertical-align: top;
            padding: 2px 0;
        }
        .table-data td:first-child {
            width: 150px;
        }
        .table-data td:nth-child(2) {
            width: 20px;
            text-align: center;
        }

        .signature-section {
            width: 100%;
            margin-top: 40px;
        }
        .signature-table {
            width: 100%;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .qr-code {
            width: 100px;
            height: 100px;
            margin: 10px auto;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="header text-center">
        <h1>PEMERINTAH KABUPATEN INDONESIA</h1>
        <h1>KECAMATAN MAJU BERSAMA</h1>
        <h2>DESA MANDIRI</h2>
        <p>Jl. Raya Desa Mandiri No. 1 Kode Pos 12345</p>
        <p>Email: desa@mandiri.id | Website: www.desa.id</p>
    </div>

    <!-- JUDUL SURAT -->
    <div class="title-section">
        <p class="surat-title">{{ $surat->jenis_surat?->label() }}</p>
        <p class="surat-number">Nomor: {{ $surat->nomor_surat }}</p>
    </div>

    <!-- ISI SURAT -->
    <div class="mb-4">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Mandiri, Kecamatan Maju Bersama, Kabupaten Indonesia, menerangkan dengan sesungguhnya bahwa:</p>
    </div>

    <table class="table-data mb-4">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td class="font-bold">{{ $surat->nama_pemohon }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $surat->nik_pemohon }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $surat->alamat_pemohon }}</td>
        </tr>
    </table>

    <div class="mb-4">
        <p>Orang tersebut di atas adalah benar warga Desa Mandiri dan surat keterangan ini dibuat dengan keperluan:</p>
        <p class="font-bold">"{{ $surat->keperluan }}"</p>
    </div>

    @if($surat->catatan_pemohon)
    <div class="mb-4">
        <p>Keterangan Tambahan:</p>
        <p>{{ $surat->catatan_pemohon }}</p>
    </div>
    @endif

    <div class="mb-8">
        <p>Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- TANDA TANGAN -->
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td>
                    <p class="mb-1">Pemohon,</p>
                    <br><br><br><br>
                    <p class="font-bold uppercase">{{ $surat->nama_pemohon }}</p>
                </td>
                <td>
                    <p class="mb-1">Desa Mandiri, {{ $surat->tanggal_selesai?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y') }}</p>
                    <p class="mb-1">Kepala Desa Mandiri,</p>
                    
                    @if($surat->qr_code)
                        <!-- Embed QR Code Image -->
                        <img src="{{ public_path('storage/' . $surat->qr_code) }}" class="qr-code" alt="QR Code">
                    @else
                        <br><br><br><br>
                    @endif
                    
                    <p class="font-bold underline uppercase">BAPAK KEPALA DESA</p>
                    <p>NIP. 19800101 201001 1 001</p>
                </td>
            </tr>
        </table>
    </div>

    <div style="position: fixed; bottom: -30px; left: 0; width: 100%; font-size: 8pt; color: #666; border-top: 1px solid #ccc; padding-top: 5px;">
        <p>Dokumen ini ditandatangani secara elektronik dan dapat diverifikasi melalui scan QR Code. DesaOS &copy; {{ date('Y') }}</p>
    </div>

</body>
</html>
