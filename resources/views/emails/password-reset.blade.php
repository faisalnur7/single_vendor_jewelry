<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <title>Reset Your Password | {{ $site_name ?? 'Store' }}</title>
    <!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        table, td {
            mso-table-lspace: 0;
            mso-table-rspace: 0;
        }
        
        img {
            border: 0;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }
        
        a {
            text-decoration: none;
            color: inherit;
        }
        
        /* Main Container */
        .email-wrapper {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #e94560, #ff6b6b, #feca57);
        }
        
        .logo {
            margin-bottom: 20px;
        }
        
        .logo img {
            max-width: 180px;
            height: auto;
            display: inline-block;
        }
        
        .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin: 0;
        }
        
        .header-title {
            font-size: 24px;
            font-weight: 600;
            color: #ffffff;
            margin-top: 15px;
            line-height: 1.3;
        }
        
        /* Content Body */
        .body {
            padding: 50px 40px;
            background-color: #ffffff;
        }
        
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 20px;
        }
        
        .message {
            font-size: 16px;
            color: #4a4a68;
            line-height: 1.7;
            margin-bottom: 30px;
        }
        
        /* Button Container */
        .button-section {
            text-align: center;
            margin: 40px 0;
        }
        
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e94560 0%, #ff6b6b 100%);
            color: #ffffff !important;
            padding: 18px 45px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 15px rgba(233, 69, 96, 0.3);
            transition: all 0.3s ease;
        }
        
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(233, 69, 96, 0.4);
        }
        
        .button svg {
            margin-right: 10px;
            width: 20px;
            height: 20px;
            fill: currentColor;
        }
        
        /* Info Boxes */
        .info-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f5 100%);
            border-left: 4px solid #e94560;
            padding: 18px 22px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .info-box p {
            margin: 0;
            color: #4a4a68;
            font-size: 15px;
            line-height: 1.6;
        }
        
        .info-box strong {
            color: #1a1a2e;
        }
        
        /* Security Box */
        .security-box {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe8e8 100%);
            border-left: 4px solid #dc3545;
            padding: 18px 22px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .security-box p {
            margin: 0;
            color: #8b0000;
            font-size: 15px;
            line-height: 1.6;
        }
        
        .security-box strong {
            color: #dc3545;
        }
        
        /* URL Display */
        .url-box {
            background: #f8f9fa;
            border: 1px dashed #dee2e6;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        
        .url-box p {
            margin: 0;
            font-size: 14px;
            color: #6c757d;
            line-height: 1.5;
        }
        
        .url-text {
            font-family: 'Courier New', monospace;
            background: #ffffff;
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            margin-top: 10px;
            word-break: break-all;
            font-size: 13px;
            color: #495057;
            display: block;
        }
        
        /* Footer */
        .footer {
            background: #1a1a2e;
            padding: 30px 40px;
            text-align: center;
        }
        
        .footer-text {
            color: #a0a0b8;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        
        .footer-text a {
            color: #e94560;
            text-decoration: none;
            font-weight: 600;
        }
        
        .footer-text a:hover {
            text-decoration: underline;
        }
        
        .copyright {
            color: #6b6b8a;
            font-size: 12px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #2a2a4a;
        }
        
        /* Responsive */
        @media screen and (max-width: 600px) {
            .header {
                padding: 30px 20px;
            }
            
            .header-title {
                font-size: 20px;
            }
            
            .body {
                padding: 30px 20px;
            }
            
            .footer {
                padding: 25px 20px;
            }
            
            .button {
                padding: 16px 35px;
                font-size: 15px;
                display: block;
                width: 100%;
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #1a1a2e;
            }
            
            .email-wrapper {
                background-color: #16213e;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        
        <!-- Header Section -->
        <div class="header">
            <h1 class="logo-text">{{ $site_name ?? 'Stainless Steel Jewelry' }}</h1>
            <h2 class="header-title">Reset Your Password</h2>
        </div>
        
        <!-- Main Content -->
        <div class="body">
            <!-- Greeting -->
            <p class="greeting">Hello {{ $user->name ?? 'Valued Customer' }},</p>
            
            <!-- Main Message -->
            <p class="message">
                We received a request to reset your password. Click the button below to create a new secure password for your account.
            </p>
            
            <!-- Reset Button -->
            <div class="button-section">
                <a href="{{ $url }}" class="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L12 17h-1.098A4.915 4.915 0 0112 16c-2.796 0-5.303-.814-7.07-2.226l-.8-.8A5.973 5.973 0 0012 12a6 6 0 106 6c1.062 0 2.096-.276 2.986-.608l1.65-1.65A2 2 0 1115 7z"/>
                    </svg>
                    Reset Password Now
                </a>
            </div>
            
            <!-- Expiry Information -->
            <div class="info-box">
                <p>
                    <strong>⏰ Link Expiry:</strong> This reset link will expire in 
                    <span style="color: #e94560; font-weight: 600;">{{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutes</span>. 
                    Please complete the password reset before the link expires.
                </p>
            </div>
            
            <!-- Security Notice -->
            <div class="security-box">
                <p>
                    <strong>🔒 Security Alert:</strong> If you did not request a password reset, please ignore this email. Your account remains secure and no changes will be made.
                </p>
            </div>
            
            <!-- Alternative URL -->
            <p class="message" style="font-size: 14px; color: #6c757d;">
                <strong>Can't click the button?</strong><br>
                Copy and paste this URL into your browser:
            </p>
            <div class="url-box">
                <span class="url-text">{{ $url }}</span>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                Need assistance? Contact our support team at<br>
                <a href="mailto:support@stainlesssteeljewellery.com">support@stainlesssteeljewellery.com</a>
            </p>
            <p class="copyright">
                &copy; {{ date('Y') }} {{ $site_name ?? 'Stainless Steel Jewelry' }}. All rights reserved.
            </p>
        </div>
        
    </div>
</body>
</html>
