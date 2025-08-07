<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $subjectText }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 30px;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">

        <h2 style="color: #333333; text-align: center;">{{ $subjectText }}</h2>

        <p style="font-size: 16px; color: #333333; line-height: 1.6;">
            Dear Student,
        </p>

        <p style="font-size: 16px; color: #333333; line-height: 1.6;">
            Please complete your teaching evaluation between
            <strong>{{ $startDate }}</strong> and <strong>{{ $endDate }}</strong>.
        </p>

        <p style="font-size: 16px; color: #333333; line-height: 1.6;">
            Click the button below to log in and complete your evaluation.
        </p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" style="display: inline-block; padding: 12px 24px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 6px; font-size: 16px;">
                Click here to login
            </a>
        </div>

        <p style="font-size: 16px; color: #333333; line-height: 1.6;">
            Thank you.
        </p>

    </div>
</body>
</html>
