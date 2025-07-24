<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: #ffffff; padding: 40px; border-radius: 8px;">
        <div style="text-align: center;">
            {{-- <img src="{{ url($site_logo ?? 'images/logo.png') }}" alt="{{ $site_name }}" height="50"> --}}
        </div>

        <h2 style="text-align: center; color: #333;">Reset Your Password</h2>

        <p>Hello {{ $user->name ?? 'User' }},</p>

        <p>We received a request to reset the password for your account.</p>

        <p style="text-align: center;">
            <a href="{{ $url }}" style="display: inline-block; padding: 12px 24px; background-color: #4f46e5; color: #ffffff; text-decoration: none; border-radius: 6px;">Reset Password</a>
        </p>

        <p>This password reset link will expire in {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutes.</p>

        <p>If you did not request a password reset, no further action is required.</p>

        <p>Thanks,<br>{{ $site_name }}</p>

        <hr>
        <p style="text-align: center; font-size: 12px; color: #888;">
            &copy; {{ date('Y') }} {{ $site_name }}. All rights reserved.
        </p>
    </div>
</body>
</html>
