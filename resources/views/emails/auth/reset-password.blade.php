<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>{{ __('auth.reset_password') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .header {
            background: #f3f4f6;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .content {
            padding: 25px;
            line-height: 1.6;
            color: #374151;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            margin: 20px 0;
            background: #0ea5e9;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            border-radius: 8px;
        }

        .footer {
            font-size: 12px;
            color: #6b7280;
            text-align: center;
            padding: 15px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ __('auth.reset_password') }}</h1>
        </div>
        <div class="content">
            <p>{{ __('auth.reset_intro') }}</p>
            <p>
                <a href="{{ $url }}" class="btn">{{ __('auth.reset_password_btn') }}</a>
            </p>
            <p>{{ __('auth.reset_warning') }}</p>
        </div>
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. {{ __('auth.all_rights_reserved') }}
        </div>
    </div>
</body>

</html>
