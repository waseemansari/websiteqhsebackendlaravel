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



    'branches' => [

            'australia' => [
                'email' => 'nikki@qhseinternational.com',
                'manager' => 'NIKKI (Manager)',
                'phone' => '+9714 4431124',
                'admin_phone' => '+61 417 777 781',
                
                'name'=>'QHSE International Australia',
                'time'=>'9 AM - 6 PM, Monday to Saturday',
                'address'=>'7, Noosa Court Upper Caboolture QLD, 4510.',
                'url'=>'https://www.qhseinternational.com/australia'
            ],

            'usa' => [
                'name'=>'QHSE International USA',
                'email' => 'info.usa@qhseinternational.com',
                'manager' => 'Emilie (USA Manager)',
                'phone' => ' +1 701-833-8015 ',
                'admin_phone' => '+ 1 954-569-0677',
                'time'=>'9 AM - 6 PM, Monday to Saturday',
                'address'=>'25 SE 2nd Ave Ste 550 #720 Miami, FL 33131.',
                'url'=>'https://www.qhseinternational.com/usa'

            ],

            'uk' => [
                'email' => 'info.uk@qhseinternational.com',
                'manager' => 'Mommani (UK Manager)',
                'phone' => '+44 7350 194829',
                'admin_phone' => '+44 7350 194829',

                'name'=>'QHSE International UK',
                'time'=>'9 AM - 6 PM, Monday to Saturday',
                'address'=>'Bromley, BR1 1AC, London, United Kingdom.',
                'url'=>'https://www.qhseinternational.com/uk'
            ],

            'ph' => [
                'email' => 'patricia@qhseinternational.com',
                'manager' => 'Patricia',
                'phone' => '+63 969 644 3444',
                'admin_phone' => '+63 969 644 3444',
                 
                'name'=>'QHSE International Philippines',
                'time'=>'9 AM - 6 PM, Monday to Saturday',
                'address'=>'Unit 3006 One Corporate Center Bldg. Julia Vargas Ave. Ortigas Center, San Antonio 1605, Pasig City, Philippines.',
                'url'=>'https://www.qhseinternational.com/ph' 
                
            ],

            'uae' => [
                'email' => 'sarahg@qhseinternational.com',
                'manager' => 'Sarahg (Manager)',
                'phone' => '+9714 4431124',
                'admin_phone' => '+971501104559',

                'name'=>'QHSE International UAE',
                'time'=>'9 AM - 6 PM, Monday to Saturday',
                'address'=>'Office 2403 - Donna Towers, 46 Street, Dubai Silicon Oasis, Dubai, UAE',
                'url'=>'https://www.qhseinternational.com/uae'
            ],

            'guinea' => [
                'email' => 'info.gn@qhseinternational.com',
                'manager' => 'QHSE International',
                'phone' => '+224 610 00 41 36',
                'admin_phone' => '+224 610 00 41 36',
                'name'=>'QHSE International Guinea',
                'time'=>'9 AM - 6 PM, Monday to Saturday',
                'address'=>'Conakry (Guinee) Commune de Ratoma - BP:2668.',
                'url'=>'https://www.qhseinternational.com/guinea'
            ],

        ],
];
