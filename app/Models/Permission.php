<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    // Keep it global. If you want per-tenant permissions, use Spatie "teams".
}
