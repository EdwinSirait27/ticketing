<?php

namespace App\Helpers;

use App\Models\User;

class DriveHelper
{
    /**
     */
    public static function getFolderIdentity(?User $user): string
    {
        if (!$user) {
            return 'UNKNOWN_guest';
        }

        if ($user->employee && !empty($user->employee->employee_pengenal)) {
            return $user->employee->employee_pengenal;
        }

        if ($user->employee && !empty($user->employee->employee_name)) {
            return $user->employee->employee_name;
        }

        return 'UNKNOWN_' . $user->id;
    }

    /**
     */
    public static function getFilePrefix(?User $user): string
    {
        return self::getFolderIdentity($user);
    }
}