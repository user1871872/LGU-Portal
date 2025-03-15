<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Permit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
            border: 5px solid red;
        }
        .header {
            text-align: center;
            font-size: 20px;
        }
        .title {
            background-color: red;
            color: white;
            font-weight: bold;
            font-size: 24px;
            padding: 10px;
            text-align: center;
            margin-bottom: 10px;
        }
        .box {
            width: 80%;
            margin: 10px auto;
            padding: 10px;
            border: 2px solid black;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <p>Republic of the Philippines</p>
            <p>Province of Bohol</p>
            <p><strong>MUNICIPALITY OF ANDA</strong></p>
            <p>BUSINESS PERMITS AND LICENSING OFFICE</p>
        </div>

        <!-- TITLE -->
        <div class="title">BUSINESS PERMIT 2024</div>

        <div><strong>PERMIT NO.:</strong> __________</div>

        <p>is granted to:</p>

        <!-- PROPRIETOR -->
        <div class="box">{{ $permit->first_name }} {{ $permit->middle_name }} {{ $permit->last_name }}</div>
        <p>Name of Proprietor</p>

        <!-- BUSINESS NAME -->
        <div class="box">{{ $permit->business_name }}</div>
        <p>Business Name</p>

        <!-- BUSINESS LOCATION -->
        <div class="box">{{ $permit->business_address }}</div>
        <p>Business Location</p>

        <p>Line/Kind of Business</p>

        <!-- ISSUED DATE -->
        <p>Issued on the {{ date('jS \d\a\y \o\f F, Y', strtotime($permit->issued_at)) }} at Anda, Bohol, Philippines.</p>

        <p><strong>HON. ANGELINA B. SIMACIO</strong><br>Local Chief Executive</p>

        <!-- FOOTER -->
        <div class="footer">
            <p>Note: This authorizes the licensee to engage and operate for the quarter indicated as attested by the Business Permit and Licensing Office.</p>
            <p>Revoked or canceled. This permit is subject to regulations and must be displayed in a visible place.</p>
        </div>
    </div>
</body>
</html>
