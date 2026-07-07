<?php
use Illuminate\Support\Str;

return [
    'site_name' => 'QHSE',
    'site_code' => 'QHSE',
    'support_email' => 'support@qhse.com',
    'max_upload_size' => 50, // in MB
    'crm_folder' => 'crm',
    'days'=>'Friday',
    'vanue'=>1,
    'password'=>Str::random(8),
    'company_name' => 'QHSE International',
    'company_manager' => 'NIKKI (Manager)',
    'company_email' => 'info@qhseinternational.com',
    'company_phone' => '+9714 4431124',
    'company_admin_phone' => '+971501104559',
    'company_time'=>'9 AM - 6 PM, Monday to Saturday',
    'company_address'=>'Office 2403, Donna Towers, Dubai Silicon Oasis, Dubai, United Arab Emirates',
    'company_url' => 'https://www.qhseinternational.com/',
    'elearning_url' => 'https://elearnings.qhseinternational.com/login',
    'allowed_emails' => [
            'waseem0320@gmail.com',
        ],
     'branch_emails' => [
        'australia' => 'nikki@qhseinternational.com',
        'usa' => 'info.usa@qhseinternational.com',
        'uk' => 'info.uk@qhseinternational.com',
        'ph' => 'patricia@qhseinternational.com',
        'uae' => 'sarahg@qhseinternational.com',
        'guinea' => 'info@qhseinternational.com',
    ],
];
