<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Permit</title>
    <style>
        .hero-section {
        background: url('/images/logo.jpg') no-repeat center center;
    }
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
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-align: center;
        width: 100%;
    }
    .header-content {
        flex-grow: 1;
        text-align: center;
    }
    .header img {
        width: 80px; /* Adjust the size as needed */
        height: 80px;
        border-radius: 50%;
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
            display: inline-block;
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
    <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/3/3a/Anda%2C_Bohol_seal.jpg?20200702154915" alt="Left Logo"> -->
    <div class="header-content">
        <p>Republic of the Philippines</p>
        <p>Province of Bohol</p>
        <p><strong>MUNICIPALITY OF ANDA</strong></p>
        <p>BUSINESS PERMITS AND LICENSING OFFICE</p>
    </div>
    <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/3/3a/Anda%2C_Bohol_seal.jpg?20200702154915" alt="Right Logo"> -->
</div>

        <!-- TITLE -->
        <div class="title">BUSINESS PERMIT {{ date('Y') }}</div>

        <div><strong>PERMIT NO.:</strong> {{ $permit->id }}</div>

        <p>is granted to:</p>

        <!-- PROPRIETOR -->
        <div class="box">{{ $permit->first_name }} {{ $permit->middle_name }} {{ $permit->last_name }}</div>
        <p>Name of Proprietor</p>

        <!-- BUSINESS NAME -->
        <div class="box">{{ $permit->business_name }}</div>
        <p>Business Name</p>

        <!-- BUSINESS LOCATION -->
        <div class="box">{{ $permit->province }} {{ $permit->town }} {{ $permit->barangay }}</div>
        <p>Business Location</p>
        <span class="box">{{ $permit->businessType->name }}</span>
        <p>Line/Kind of Business</p>

        <!-- ISSUED DATE -->
        <p>Issued on the {{ \Carbon\Carbon::parse($permit->issued_at)->format('jS \\d\\a\\y \\o\\f F, Y') }} at Anda, Bohol, Philippines.</p>


        <p><strong>HON. ANGELINA B. SIMACIO</strong><br>Local Chief Executive</p>

        <!-- FOOTER -->
        <div class="footer">
            <p>Note: This authorizes the licensee to engage and operate for the quarter indicated as attested by the Business Permit and Licensing Office.</p>
            <p>Revoked or canceled. This permit is subject to regulations and must be displayed in a visible place.</p>
        </div>
    </div>
</body>
</html>