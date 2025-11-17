<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $fillable = [
        'name',
        'domain',
        'database',
        'status',
        'admin_email',
        'admin_name',
        'notes',
        'approved_at',
        'data',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'domain',
            'database',
            'status',
            'admin_email',
            'admin_name',
            'notes',
            'approved_at',
            'data',
        ];
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function approve()
    {
        $this->update([
            'status' => 'active',
            'approved_at' => now(),
        ]);
    }

    public function suspend()
    {
        $this->update([
            'status' => 'suspended',
        ]);
    }
}