<!DOCTYPE html>
<html>
<head>
    <title>{{ $subjectText }}</title>
</head>
<body>
 {!! $bodyText !!}
    <p>
    <a href="{{ url('/login') }}" style="color: blue;">
        Click here to login and complete your evaluation
    </a>
</p>
</body>
</html>