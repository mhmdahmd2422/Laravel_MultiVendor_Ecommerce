<?php

namespace App\Helper;

use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;

class MailHelper
{
    public static function setMailConfig()
    {
        $emailConfig = EmailConfiguration::first();
        $generalSettings = GeneralSetting::first();

        $config = [
            'transport' => 'smtp',
            'url' => env('MAIL_URL'),
            'host' => $emailConfig->host,
            'port' => $emailConfig->port,
            'encryption' => $emailConfig->encryption,
            'username' => $emailConfig->username,
            'password' => $emailConfig->password,
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN'),
        ];

        $fromInfo = [
            'address' => $emailConfig->email,
            'name' => $generalSettings->site_name,
        ];

        config(['mail.mailers.smtp' => $config]);
        config(['mail.from' => $fromInfo]);
    }
}
