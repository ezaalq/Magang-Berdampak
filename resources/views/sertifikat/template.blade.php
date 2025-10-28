<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Template</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            text-align: center;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .certificate {
            border: 5px solid #333;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .title {
            font-size: 36px;
            margin: 20px 0;
            font-weight: bold;
            color: #333;
        }

        .content {
            font-size: 18px;
            line-height: 1.6;
            margin: 20px 0;
        }

        .placeholder {
            font-weight: bold;
            color: #007bff;
        }

        .signature {
            margin-top: 50px;
            border-top: 1px solid #333;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
            padding-top: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <div class="header">Certificate of Achievement</div>
        <div class="title">Certificate</div>
        <div class="content">
            <p>This is to certify that</p>
            <p class="placeholder">{{ $student_name }}</p>
            <p>has successfully completed</p>
            <p class="placeholder">{{ $certificate_name }}</p>
            <p>on</p>
            <p class="placeholder">{{ $issue_date }}</p>
            <p>{{ $description }}</p>
        </div>
        <div class="signature">
            Signature
        </div>
    </div>
</body>

</html>
