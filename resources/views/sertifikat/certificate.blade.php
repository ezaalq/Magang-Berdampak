<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 5mm;
        }
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.4;
        }
        .certificate {
            width: 100%;
            max-width: 297mm;
            background-color: #fff;
            border: 2px solid #d4af37;
            position: relative;
            padding: 10mm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .logo {
            width: 50px;
            height: 50px;
            background-color: #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: #666;
            border-radius: 50%;
        }
        .institution {
            text-align: center;
            flex-grow: 1;
        }
        .institution h2 {
            margin: 0;
            font-size: 18px;
            color: #d4af37;
        }
        .institution p {
            margin: 3px 0 0 0;
            font-size: 10px;
        }
        .title {
            text-align: center;
            margin: 15px 0;
        }
        .title h1 {
            font-size: 32px;
            margin: 0;
            color: #d4af37;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .content {
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .recipient {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .recipient strong {
            font-size: 20px;
            color: #000;
        }
        .achievement {
            font-size: 12px;
            margin: 10px 0;
        }
        .date {
            font-size: 12px;
            margin: 10px 0;
        }
        .signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .signature {
            text-align: center;
            width: 150px;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            margin-bottom: 3px;
            height: 30px;
        }
        .signature-title {
            font-size: 9px;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <div class="logo">Logo</div>
            <div class="institution">
                <h2>Magang Berdampak</h2>
                <p>Professional Internship Program</p>
            </div>
            <div class="logo">Logo</div>
        </div>

        <div class="title">
            <h1>Certificate of Completion</h1>
        </div>

        <div class="content">
            <p class="recipient">This is to certify that</p>
            <p class="recipient"><strong>{{ $mahasiswa->nama }}</strong></p>
            <p class="recipient">has successfully completed the internship program and demonstrated outstanding performance in</p>
            <p class="achievement"><strong>{{ $data['nama_sertifikat'] }}</strong></p>
            <p class="achievement">{{ $data['deskripsi'] ?? 'Various professional development activities and projects.' }}</p>
            <p class="date">Issued on {{ $data['tanggal_terbit'] ? \Carbon\Carbon::parse($data['tanggal_terbit'])->format('F j, Y') : 'N/A' }}</p>
        </div>

        <div class="signatures">
            <div class="signature">
                <div class="signature-line"></div>
                <p class="signature-title">Program Director</p>
            </div>
            <div class="signature">
                <div class="signature-line"></div>
                <p class="signature-title">Supervisor</p>
            </div>
        </div>

        <div class="footer">
            <p>This certificate is awarded in recognition of dedication, hard work, and professional growth during the internship period.</p>
            <p>Certificate ID: {{ $data['id'] ?? 'N/A' }}</p>
        </div>
    </div>
</body>
</html>
