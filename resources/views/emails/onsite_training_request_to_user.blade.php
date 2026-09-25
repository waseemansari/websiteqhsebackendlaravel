<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>On-Site Training Request Received</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f5f6fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .email-container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .email-header { background-color: #ccb368; color: #ffffff; padding: 30px; text-align: center; }
        .email-header h1 { margin: 0; font-size: 24px; letter-spacing: 0.5px; }
        .email-body { padding: 30px; color: #333333; }
        .email-body p { font-size: 16px; line-height: 1.6; }
        .details-box { background-color: #fff8e1; padding: 20px; border-radius: 8px; margin: 20px 0; border: 1px solid #ccb368; }
        .details-box p { margin: 10px 0; font-size: 15px; line-height: 1.6; }
        .next-step { background-color: #f0f8f3; border-left: 4px solid #087f43; padding: 14px 16px; margin: 20px 0; }
        .next-step p { margin: 0; font-size: 15px; }
        a { color: #a58b39; text-decoration: none; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ $company['company_name'] }}</h1>
        </div>
      
        <div class="email-body">
            <p>Dear {{ $request->contact_name }},</p>

            <p>
                Thank you for requesting {{ strtolower($requestType) }} on-site training with QHSE International USA. We have received your information and will review your facility, equipment, and training needs before preparing a quote.
            </p>

            <div class="next-step">
                <p>
                    Our {{ $branch['name'] ?? $company['company_name'] }} team will review your request and contact you soon using the details you provided.
                </p>
            </div>

            <div class="details-box">
                <strong>Your Request Summary</strong><br><br>
                <p><strong>Request type:</strong> {{ $requestType }}</p>
                <p><strong>Company:</strong> {{ $request->company_name }}</p>
                <p><strong>Training needs:</strong><br>{{ $request->training_needs }}</p>
                @if($request->training_topic)
                    <p><strong>Training topic:</strong><br>{{ $request->training_topic }}</p>
                @endif
                <p><strong>Number of participants:</strong> {{ $request->number_of_participants }}</p>
                @if($request->delivery_preference)
                    <p><strong>Delivery preference:</strong> {{ $request->delivery_preference }}</p>
                @endif
                <p><strong>Preferred dates:</strong><br>{{ $request->preferred_dates }}</p>
                <p><strong>Branch:</strong> {{ $branch['name'] ?? $request->branch_id }}</p>
            </div>

            <p>
                If you need to update your request, please reply to this email or contact our team directly.
            </p>

            <p>
                Kind Regards,<br>
                <strong>{{ $branch['manager'] ?? $company['company_manager'] }}</strong><br>
                {{ $branch['name'] ?? $company['company_name'] }}<br>
                Tel: {{ $branch['phone'] ?? $company['company_phone'] }}<br>
                <a href="mailto:{{ $branch['email'] ?? $company['company_email'] }}">{{ $branch['email'] ?? $company['company_email'] }}</a><br>
                <a href="{{ $branch['url'] ?? $company['company_url'] }}">{{ $branch['url'] ?? $company['company_url'] }}</a>
            </p>
        </div>
    </div>
</body>
</html>