<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .certificate {
            border: 2px solid #000;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>Certificate of Completion</h1>
        <p>This is to certify that</p>
        <p><strong>{{ $mahasiswa->nama }}</strong></p>
        <p>has successfully completed</p>
        <p><strong>{{ $data['nama_sertifikat'] }}</strong></p>
        <p>on {{ $data['tanggal_terbit'] ? \Carbon\Carbon::parse($data['tanggal_terbit'])->format('F j, Y') : 'N/A' }}</p>
        <p>{{ $data['deskripsi'] ?? '' }}</p>
    </div>
</body>
</html>
