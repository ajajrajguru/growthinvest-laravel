<?php
 
return [
 
 
 
    'email_to' => 'prajay@ajency.in',
    'email_from' => env('MAIL_FROM_ADDRESS', 'echosign@echosign.com'),
    'email_from_name' => env('MAIL_FROM_NAME', 'GrowthInvest'),
 
    /* Dev Mode */
    'email_from_dev' => 'prajay@ajency.in',
    'email_to_dev' => ['prajay@ajency.in'], 
    'email_cc_dev' => ['cinthia@ajency.in'], 
    'email_bcc_dev' => [],

     'app_dev_envs' => ['local', 'development'],

 
    'send_email_dev' => env('SEND_EMAIL_DEV', true), // If true, Email will be sent, else will not send Email -> ONLY on DEV mode, else Email will be sent in Production mode
    'send_sms_dev' => env('SEND_SMS_DEV', true), // IF true, SMS will be sent, else will not send SMS -> ONLY on DEV mode, else SMS will be sent in Production mode

    'send_delay_dev' => 2, // In mins -> This delay will be used in Email / SMS sending
 	/* Dev Mode Ends */
];
 
