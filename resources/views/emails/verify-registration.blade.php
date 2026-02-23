<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body {
      font-family: system-ui, Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333;
      padding: 20px;
    }
    .email-container {
      background-color: #fff;
      max-width: 500px;
      margin: auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h3 {
      color: #0d6efd;
      margin-bottom: 20px;
    }
    p {
      font-size: 14px;
      line-height: 1.6;
    }
    h1 {
      letter-spacing: 6px;
      text-align: center;
      color: #000;
      margin: 20px 0;
      font-size: 28px;
    }
    hr {
      border: none;
      border-top: 1px solid #ddd;
      margin: 20px 0;
    }
    small {
      color: #999;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <h3>Trinity Global Capital LTD — Email Verification</h3>
    <p>Enter the below OTP to verify your email address.</p>
    <h1>{{ $otp }}</h1>
    <p>This code will expire in <strong>5 minutes</strong>.</p>
    <p>If you didn't request this, ignore this email.</p>
    <hr>
    <p>Thank you</p>
    <small>Trinity Global Capital LTD</small>
  </div>
</body>
</html>
