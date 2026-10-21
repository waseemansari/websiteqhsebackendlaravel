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
            padding: 6px 12px;
            margin-top: 8px;
            background-color: #ccb368;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        .blog-card {
            border: 1px solid #e6eaf0;
            border-radius: 8px;
            overflow: hidden;
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
            @if($messageBody === strip_tags($messageBody))
                {!! nl2br(e($messageBody)) !!}
            @else
                {!! $messageBody !!}
            @endif

            @if($latestBlogs->isNotEmpty())
                <h2 style="margin: 28px 0 14px; color: #253244; font-size: 20px;">Latest blogs</h2>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                    @foreach($latestBlogs->chunk(2) as $blogRow)
                        <tr>
                            @foreach($blogRow as $blog)
                                <td width="50%" valign="top" style="padding: 0 6px 12px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" class="blog-card" style="border: 1px solid #e6eaf0; border-radius: 8px;">
                                        <tr>
                                            <td>
                                                <a href="{{ rtrim(config('custom.company_url'), '/') }}/blog-details/{{ $blog->id }}">
                                                    @if($blog->image_url)
                                                        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" width="100%" style="display: block; width: 100%; height: 140px; object-fit: cover; border: 0;">
                                                    @else
                                                        <div style="height: 100px; background-color: #fff8e1;"></div>
                                                    @endif
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px;">
                                                <a href="{{ rtrim(config('custom.company_url'), '/') }}/blog-details/{{ $blog->id }}" style="color: #253244; font-size: 14px; font-weight: 600; line-height: 1.4;">
                                                    {{ $blog->title }}
                                                </a>
                                                @if($blog->excerpt)
                                                    <p style="margin: 8px 0 0; color: #647184; font-size: 12px; line-height: 1.5;">
                                                        {{ \Illuminate\Support\Str::limit(strip_tags($blog->excerpt), 100) }}
                                                    </p>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            @endforeach
                            @if($blogRow->count() === 1)
                                <td width="50%" style="padding: 0 6px 12px;"></td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            @endif

            <p>
                <a href="{{ rtrim(config('custom.company_url'), '/') }}/blog/main" class="btn">Read our latest blogs</a>
            </p>
        </div>
            <p>If you do not wish to receive future emails, you can unsubscribe below.

            @if(!empty($unsubscribeUrl))
                <a href="{{ $unsubscribeUrl }}" >Unsubscribe</a>
            @endif
            </p>
          <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ $company['company_name'] }}. All rights reserved.</p>
            <div class="social-icons">
                @if(!empty($company['facebook_url']))
                    <a href="{{ $company['facebook_url'] }}"><img src="{{ asset('images/facebook-icon.png') }}" alt="Facebook" width="24" height="24"></a>
                @endif
                @if(!empty($company['twitter_url']))
                    <a href="{{ $company['twitter_url'] }}"><img src="{{ asset('images/twitter-icon.png') }}" alt="Twitter" width="24" height="24"></a>
                @endif
                @if(!empty($company['linkedin_url']))
                    <a href="{{ $company['linkedin_url'] }}"><img src="{{ asset('images/linkedin-icon.png') }}" alt="LinkedIn" width="24" height="24"></a>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
