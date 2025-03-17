<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background: #007BFF;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            font-size: 20px;
        }
        .content {
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            background: #007BFF;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Welcome to Our Service</div>
        <div class="content">
            <p>Hi there, {{  $data['name'] }}.</p>
            <p>Thank you for signing up, {{  $data['email'] }}. We are excited to have you on board!</p>

            <p>Click the button below to get started:</p>
            <p style="text-align: center;"><a href="#" class="button">Get Started</a></p>
            <p>If you have any questions, feel free to reach out.</p>
        </div>
        <div class="footer">
            &copy; 2025 Your Company. All rights reserved.
        </div>
    </div>
</body>
</html>
