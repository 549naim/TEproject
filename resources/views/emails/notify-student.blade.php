<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $subjectText }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 30px;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">

        <h2 style="color: #2c3e50; text-align: center; margin-bottom: 20px;">
            {{ $subjectText }}
        </h2>

        <p style="font-size: 15px; color: #333333; line-height: 1.6; margin-bottom: 15px;">
            Dear Student,
        </p>

        <p style="font-size: 15px; color: #333333; line-height: 1.6; margin-bottom: 15px;">
            Please complete your teaching evaluation between 
            <strong>{{ $startDate }}</strong> and <strong>{{ $endDate }}</strong>.
        </p>

        <p style="font-size: 15px; color: #333333; line-height: 1.6; margin-bottom: 15px;">
            On your first login, please click <strong> <a href="{{ url('/password/reset') }}" style="color: #e61616; text-decoration: underline;">“Forgot Password”</a>.</strong>
            You must use your <strong>institutional email</strong> to log in.
        </p>

        <div style="text-align: center; margin: 25px 0;">
            <a href="{{ url('/login') }}" style="display: inline-block; padding: 10px 22px; background-color: #4CAF50; color: #ffffff; text-decoration: none; border-radius: 6px; font-size: 15px; font-weight: bold;">
                Click Here to Login
            </a>
        </div>

        <p style="font-size: 14px; color: #555555; line-height: 1.6;">
            Thank you for your cooperation.
        </p>

    </div>
</body>
</html>
