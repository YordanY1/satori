<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <title>Бърз въпрос</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f7f9;
            color: #111;
            margin: 0;
            padding: 0
        }

        .card {
            max-width: 600px;
            margin: 24px auto;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden
        }

        .head {
            padding: 16px 20px;
            background: #f3f4f6;
            border-bottom: 1px solid #e5e7eb
        }

        .head h1 {
            margin: 0;
            font-size: 18px
        }

        .content {
            padding: 20px;
            line-height: 1.6
        }

        .label {
            font-weight: 600;
            color: #374151
        }

        .box {
            margin-top: 12px;
            padding: 12px;
            border-left: 4px solid #111;
            background: #fafafa;
            white-space: pre-line
        }

        .footer {
            padding: 12px 20px;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            background: #fafafa
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="head">
            <h1>❓ Бърз въпрос от чатбота</h1>
        </div>
        <div class="content">
            <p><span class="label">Име:</span> {{ $name }}</p>
            <p><span class="label">Имейл:</span> {{ $email }}</p>
            <div class="box">{{ $message }}</div>
        </div>
        <div class="footer">Автоматично съобщение от izdatelstvo-satori.com</div>
    </div>
</body>

</html>
