<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // Keep it global. If you want per-tenant roles, we can enable Spatie "teams".
}
