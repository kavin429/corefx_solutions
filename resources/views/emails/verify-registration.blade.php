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
    .email-wrapper 
    { 
      width: 100%; padding: 
      30px 10px; 
    } 
    .email-container 
    { 
      max-width: 500px; 
      margin: auto; 
      background: #ffffff; 
      border-radius: 14px; 
      overflow: hidden; 
      box-shadow: 0 8px 25px rgba(0,0,0,0.08); 
    } 
    .email-header 
    { 
      background: linear-gradient(135deg, #0a3a3f, #21aab4); 
      color: #ffffff; text-align: center; padding: 25px 20px; 
    } 
    .email-header h2 {
       margin: 0; 
       font-weight: 600; 
       letter-spacing: 1px; 
      } 
      .email-body 
      { padding: 30px 25px;
       text-align: center; 
       color: #333; 
      }
       .email-body p 
       { 
        font-size: 14px;
         line-height: 1.6; 
         margin: 10px 0; } 
         .otp-box { 
          margin: 25px 0; 
          padding: 15px; background: #f0fbfc; border: 2px dashed #21aab4; border-radius: 10px; display: inline-block; } 
          .otp { font-size: 30px; letter-spacing: 8px; font-weight: bold; color: #0a3a3f; } 
          .expiry { font-size: 13px; color: #777; margin-top: 10px; } 
          .email-footer { border-top: 1px solid #eee; padding: 20px; text-align: center; font-size: 12px; color: #888; } 
          .brand { color: #0a3a3f; font-weight: 600; } @media (max-width: 500px) 
          { .otp { font-size: 24px; letter-spacing: 5px; } }
  </style>
</head>
<body>
  <div class="email-header"> 
    <h2>CoreFX Solutions</h2> 
  </div> 
  <div class="email-body"> 
    <p><strong>Email Verification</strong></p> 
    <p>Use the OTP below to verify your email address.</p> 
    <div class="otp-box"> <div class="otp">{{ $otp }}</div> 
  </div>
   <p class="expiry">This code will expire in <strong>5 minutes</strong>.</p> 
   <p>If you did not request this, you can safely ignore this email.</p> 
  </div> 
  <div class="email-footer"> 
    <p>Thank you for choosing <span class="brand">CoreFX Solutions</span></p> 
    <p>© {{ date('Y') }} CoreFX Solutions. All rights reserved.</p> 
  </div> 
</div>
</body>
</html>
