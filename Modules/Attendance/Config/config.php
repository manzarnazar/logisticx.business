<?php

use Modules\Attendance\Enums\AttendanceType;

return [
    'name' => 'Attendance',

    'type' => [
        AttendanceType::ABSENT  => 'absent',
        AttendanceType::PRESENT => 'present',
        AttendanceType::LEAVE   => 'leave',
    ],

];
