<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Discontinued</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .card {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }

        .icon {
            font-size: 60px;
            color: #dc3545;
            margin-bottom: 20px;
        }

        h1 {
            margin-bottom: 15px;
            color: #333;
        }

        p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
        }

        .contact {
            margin-top: 25px;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s ease;
        }

        .btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="icon">⚠</div>

    <h1>Service Discontinued</h1>

    <p>
        Your service has been temporarily discontinued.
    </p>

    <p class="contact">
        For assistance, please contact our support team.
    </p>

    {{-- Optional button --}}
    {{-- <a href="mailto:support@example.com" class="btn">Contact Support</a> --}}
</div>
</body>
</html>
