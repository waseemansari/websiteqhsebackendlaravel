<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration Confirmed | QHSE International {{ $registration->branch_id }}</title>
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
        <div class="email-header">
            <h1>{{ $branch['name'] ?? $company['company_name'] }}</h1>
        </div>
        <div class="email-body">
            <p>Dear Admin,</p>
            <p>Thank you for registering with QHSE International USA. Your payment has been received, and your place in the course is confirmed.</p>

            <div class="details-box">
                <strong>Registration Details</strong>
                <p><strong>Participant:</strong> {{ $registration->name }}</p>
                <p><strong>Email:</strong> {{ $registration->email }}</p>
                <p><strong>Company:</strong> {{ $registration->company ?: 'N/A' }}</p>
                <p><strong>Course:</strong> {{ $course->name }}</p>
                <p><strong>Course Dates:</strong> To be confirmed</p>
                <p><strong>Location/Format:</strong> {{ $locationFormat ?: 'To be confirmed' }}</p>
                <p><strong>Payment Amount:</strong> {{ number_format((float) $payment->amount, 2) }} {{ strtoupper($payment->currency) }}</p>
                <p><strong>Payment Confirmation:</strong> {{ $transactionNumber }}</p>
                <p><strong>Branch:</strong> {{ $registration->branch_id }}</p>
            </div>
        </div>
    </div>
</body>
</html>