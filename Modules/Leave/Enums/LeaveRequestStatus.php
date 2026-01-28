<?php

namespace Modules\Leave\Enums;

interface LeaveRequestStatus
{
    const PENDING                 = 1;
    const APPROVED                = 2;
    const REJECTED                = 3;
}
