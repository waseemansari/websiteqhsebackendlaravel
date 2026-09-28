<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course payment confirmed</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f5f6fa; font-family: Arial, sans-serif; color: #333333; }
        .email-container { max-width: 600px; margin: 32px auto; background: #ffffff; }
        .email-header { background-color: #ccb368; color: #ffffff; padding: 24px 30px; }
        .email-header h1 { margin: 0; font-size: 22px; }
        .email-body { padding: 24px 30px; }
        .email-body p { font-size: 15px; line-height: 1.6; }
        .details-box { background-color: #fff8e1; padding: 18px; margin: 20px 0; border: 1px solid #ccb368; }
        .details-box p { margin: 8px 0; }
    </style>
</head>
<body>
    <div class="email-container">
        
        <div class="email-body">
            <p>Dear {{ $firstName }},</p>

            <p>
                Thank you for registering with {{ $companyName }}. Your payment has been received, and your place in the course is confirmed.
            </p>

            <div class="details-box">
                <strong>Registration Details</strong>
                <p><strong>Participant:</strong> {{ $registration->name }}</p>
                <p><strong>Company:</strong> {{ $registration->company ?: 'N/A' }}</p>
                <p><strong>Course:</strong> {{ $course->name }}</p>
                <p><strong>Course Dates:</strong> {{ $courseDates }}</p>
                <p><strong>Location/Format:</strong> {{ $locationFormat ?: 'To be confirmed' }}</p>
                <p><strong>Payment confirmation:</strong> {{ $transactionNumber }}</p>
            </div>

            <p>
                We will email your course access details and any preparation instructions before the training date. Please check your inbox, including your spam folder.
            </p>

            <p>If any of the details above need correcting, please reply to this email.</p>
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