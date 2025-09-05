<?php

if (! function_exists('centralTenantId')) {
    function centralTenantId(): string {
        return config('app.central_tenant_id');
    }
}
