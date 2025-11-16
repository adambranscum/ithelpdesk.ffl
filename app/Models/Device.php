<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Device extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'device_name',
        'purchased',
        'warranty_end',
        'warranty',
        'make',
        'model',
        'serial',
        'branch',
    ];

    /**
     * The attributes that should be cast
     *
     * @var array<string, string>
     */
    protected $casts = [
        'purchased' => 'date',
        'warranty_end' => 'date',
    ];

    /**
     * Check if the device warranty is expiring soon
     *
     * @return bool
     */
    public function isWarrantyExpiringSoon(): bool
    {
        if (!$this->warranty_end) {
            return false;
        }

        $daysUntilExpiry = Carbon::now()->diffInDays($this->warranty_end, false);
        
        return $daysUntilExpiry >= 0 && $daysUntilExpiry <= 60;
    }

    /**
     * Check if the device warranty is expired
     *
     * @return bool
     */
    public function isWarrantyExpired(): bool
    {
        if (!$this->warranty_end) {
            return false;
        }

        return $this->warranty_end->isPast();
    }

    /**
     * Get the number of days until warranty expires
     *
     * @return int|null
     */
    public function getDaysUntilWarrantyExpiryAttribute(): ?int
    {
        if (!$this->warranty_end) {
            return null;
        }

        return Carbon::now()->diffInDays($this->warranty_end, false);
    }

    /**
     * Get the age of the device in years
     *
     * @return float|null
     */
    public function getDeviceAgeAttribute(): ?float
    {
        if (!$this->purchased) {
            return null;
        }

        return round($this->purchased->diffInYears(Carbon::now(), true), 1);
    }

    /**
     * Scope a query to only include devices with warranty expiring soon
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWarrantyExpiringSoon($query)
    {
        $sixtyDaysFromNow = Carbon::now()->addDays(60);
        
        return $query->where('warranty_end', '>=', Carbon::now())
                     ->where('warranty_end', '<=', $sixtyDaysFromNow);
    }

    /**
     * Scope a query to only include devices with expired warranty
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWarrantyExpired($query)
    {
        return $query->where('warranty_end', '<', Carbon::now());
    }

    /**
     * Scope a query to filter by branch
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $branch
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAtBranch($query, $branch)
    {
        return $query->where('branch', $branch);
    }

    /**
     * Scope a query to filter by make
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $make
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByMake($query, $make)
    {
        return $query->where('make', $make);
    }
}