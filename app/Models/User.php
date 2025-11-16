<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_tenant_admin',
        'status',
        'admin', // Keep for backwards compatibility
        'usertype', // Keep for backwards compatibility
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_tenant_admin' => 'boolean',
    ];

    // Role checking methods
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isTenantAdmin(): bool
    {
        return $this->is_tenant_admin === true || $this->role === 'admin';
    }

    public function isTech(): bool
    {
        return $this->role === 'tech';
    }

    public function canManageTenant(): bool
    {
        return $this->isTenantAdmin();
    }

    public function canAccessAdminPanel(): bool
    {
        return $this->admin === 'yes' || $this->isTenantAdmin();
    }

    // Backwards compatibility
    public function getIsAdminAttribute(): bool
    {
        return $this->admin === 'yes' || $this->isTenantAdmin();
    }

    // Status checking
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }
}