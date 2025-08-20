<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('contact_mail.new_message_title') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            color: #111827;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .header {
            background: #f3f4f6;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #111827;
        }

        .content {
            padding: 25px;
            line-height: 1.6;
        }

        .content p {
            margin: 0 0 12px;
        }

        .label {
            font-weight: 600;
            color: #374151;
        }

        .message-box {
            margin-top: 15px;
            padding: 15px;
            border-left: 4px solid #3b82f6;
            background: #f9fafb;
            font-style: italic;
            white-space: pre-line;
        }

        .footer {
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📩 {{ __('contact_mail.new_message_title') }}</h1>
        </div>
        <div class="content">
            <p><span class="label">{{ __('contact_mail.name') }}:</span> {{ $contact->name }}</p>
            <p><span class="label">{{ __('contact_mail.email') }}:</span> {{ $contact->email }}</p>

            @if (!empty($contact->phone))
                <p><span class="label">{{ __('contact_mail.phone') }}:</span> {{ $contact->phone }}</p>
            @endif

            <div class="message-box">
                {{ $contact->message }}
            </div>
        </div>
        <div class="footer">
            {!! __('contact_mail.footer', ['site' => config('app.url')]) !!}
        </div>
    </div>
</body>

</html>
