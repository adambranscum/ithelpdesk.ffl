<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Library extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'name',
        'subdomain',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'is_approved',
        'logo_path',
        'brand_color',
        'primary_color',
        'ticket_page_title',
        'ticket_page_description',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    // Relationships
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'library_uid', 'uid');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'library_uid', 'uid');
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'library_uid', 'uid');
    }

    public function software(): HasMany
    {
        return $this->hasMany(Software::class, 'library_uid', 'uid');
    }

    public function sops(): HasMany
    {
        return $this->hasMany(Sop::class, 'library_uid', 'uid');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeBySubdomain($query, $subdomain)
    {
        return $query->where('subdomain', $subdomain);
    }

    // Helper methods
    public static function generateUid(): string
    {
        return 'LIB-' . strtoupper(Str::random(12));
    }

    public function admin()
    {
        return $this->users()->where('role', 'admin')->first();
    }

    public function staff()
    {
        return $this->users()->where('role', 'staff')->get();
    }

    public function getUrl(): string
    {
        $domain = config('app.domain', 'localhost');
        return "{$this->subdomain}.{$domain}";
    }
}
