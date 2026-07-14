<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to {{ $company['company_name'] }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f6fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #ccb368; /* gold background */
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 0.5px;
        }
        .email-body {
            padding: 30px;
            color: #333333;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.6;
        }
        .details-box {
            background-color: #fff8e1; /* light gold tint */
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #ccb368;
        }
        .details-box li {
            font-size: 15px;
            line-height: 1.8;
        }
        .email-footer {
            background-color: #ccb368;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin-top: 15px;
            background-color: #ccb368;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
        }
        a {
            color: #ccb368;
            text-decoration: none;
        }
        .social-icons {
            margin-top: 15px;
            text-align: center;
        }
        .social-icons img {
            display: inline-block;
            margin: 0 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="email-container">
         <div class="email-header">
            <h1>{{ $subject }}</h1>
        </div>

        <div class="email-body">
            <p>Hello {{ $recipientName }},</p>
            
             
           
            <p>{!! nl2br(e($messageBody)) !!}</p>


            <p>If you have any questions, our support team is happy to help.</p>
             <p>Thank you for subscribing to our newsletter.</p>
            <p>
                Kind Regards,<br>
                <strong>{{ $company['company_manager'] }}</strong><br>
                {{ $company['company_name'] }}<br>
                Tel: {{ $company['company_phone'] }} | Admin: {{ $company['company_admin_phone'] }}<br>
                <a href="mailto:{{ $company['company_email'] }}">{{ $company['company_email'] }}</a><br>
                <a href="{{ $company['company_url'] }}">{{ $company['company_url'] }}</a>
            </p>
        </div>

        @include('emails.footer')
    </div>
</body>
</html>
