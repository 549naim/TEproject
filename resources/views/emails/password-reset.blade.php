<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f8fafc; padding:20px;">
    <div style="max-width:600px; margin:auto; background:white; border-radius:8px; padding:30px;">
        <h2 style="color:#0d6efd;">Dear {{ $user->name ?? 'User' }},</h2>
        <p>You are receiving this email because we received a password reset request for your account.</p>

        <p style="text-align:center; margin:30px 0;">
            <a href="{{ $url }}" style="background:#0d6efd; color:white; padding:12px 20px; border-radius:6px; text-decoration:none;">
                Reset Password
            </a>
        </p>

        <p>If you did not request a password reset, no further action is required.</p>
        <hr>
        <p style="font-size:12px; color:#6c757d;">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
</body>
</html>
