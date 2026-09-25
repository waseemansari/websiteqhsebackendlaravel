<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to {{ $company['company_name'] }}</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f5f6fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .email-container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .email-header { background-color: #ccb368; color: #ffffff; padding: 30px; text-align: center; }
        .email-header h1 { margin: 0; font-size: 24px; letter-spacing: 0.5px; }
        .email-body { padding: 30px; color: #333333; }
        .email-body p { font-size: 16px; line-height: 1.6; }
        .details-box { background-color: #fff8e1; padding: 20px; border-radius: 8px; margin: 20px 0; border: 1px solid #ccb368; }
        .details-box p { margin: 10px 0; font-size: 15px; line-height: 1.6; }
        a { color: #ccb368; text-decoration: none; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1> {{ $company['company_name'] }}</h1>
        </div>

        <div class="email-body">
            @if($isAdmin)
                <p>Dear Admin,</p>
                <p>A new {{ $requestType }} on-site training request was submitted. Please check the details below.</p>
            @else
                <p>Dear {{ $request->contact_name }},</p>
                <p>Thank you for contacting {{ $company['company_name'] }}. We received your on-site training request and our team will contact you soon.</p>
            @endif

            <div class="details-box">
                <strong>On-Site Training Request Details:</strong><br><br>
                <p><strong>Request Date:</strong> {{ $request->created_at?->format('m/d/Y') }}</p>
                <p><strong>Request Type:</strong> {{ $requestType }}</p>
                <p><strong>Branch:</strong> {{ $request->branch_id }}</p>
                <p><strong>Company:</strong> {{ $request->company_name }}</p>
                <p><strong>Contact Name:</strong> {{ $request->contact_name }}</p>
                <p><strong>Email:</strong> <a href="mailto:{{ $request->work_email }}">{{ $request->work_email }}</a></p>
                <p><strong>Phone:</strong> {{ $request->phone }}</p>
                <p><strong>Facility Address:</strong> {{ $request->facility_address }}, {{ $request->city }}, {{ $request->state }} {{ $request->zip_code }}</p>
                <p><strong>Training Needs:</strong><br>{{ $request->training_needs }}</p>
                @if($request->training_topic)
                    <p><strong>Training Topic:</strong><br>{{ $request->training_topic }}</p>
                @endif
                <p><strong>Number of Participants:</strong> {{ $request->number_of_participants }}</p>
                @if($request->delivery_preference)
                    <p><strong>Delivery Preference:</strong> {{ $request->delivery_preference }}</p>
                @endif
                <p><strong>Equipment Conditions:</strong><br>{{ $request->equipment_conditions }}</p>
                <p><strong>Preferred Dates:</strong><br>{{ $request->preferred_dates }}</p>
                <p><strong>Additional Details:</strong><br>{{ $request->additional_details ?: 'None provided' }}</p>
            </div>

            <p>
                Kind Regards,<br>
                <strong>{{ $branch['manager'] ?? $company['company_manager'] }}</strong><br>
                {{ $branch['name'] ?? $company['company_name'] }}<br>
                Tel:
                {{ $branch['phone'] ?? $company['company_phone'] }}
                @if(!empty($branch['admin_phone'])) | Admin: {{ $branch['admin_phone'] }} @endif
                <br>

                <a href="mailto:{{ $branch['email'] ?? $company['company_email'] }}">
                    {{ $branch['email'] ?? $company['company_email'] }}
                </a><br>
                <a href="{{ $branch['url'] ?? $company['company_url'] }}">
                    {{ $branch['url'] ?? $company['company_url'] }}
                </a><br>
            </p>
        </div>
    </div>
</body>
</html>