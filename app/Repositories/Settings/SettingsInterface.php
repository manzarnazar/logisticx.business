<?php

namespace App\Repositories\Settings;

interface SettingsInterface
{

    public function UpdateSettings($request);
    public function dbBackupDownload(); //database backup
    public function mailSendTest($request);
}
