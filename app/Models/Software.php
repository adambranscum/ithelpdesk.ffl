<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Software extends Model
{
    use HasFactory;

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'software';

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'software',
        'licence_quantity',
        'renewal_date',
        'unlimited',
        'forever',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'renewal_date' => 'date',
        'licence_quantity' => 'integer',
        'unlimited' => 'boolean',
        'forever' => 'boolean',
    ];

    /**
     * Check if the software license is expiring soon
     *
     * @return bool
     */
    public function isExpiringSoon(): bool
    {
        // Forever licenses and unlimited don't expire
        if ($this->forever || !$this->renewal_date) {
            return false;
        }

        $daysUntilRenewal = Carbon::now()->diffInDays($this->renewal_date, false);
        
        return $daysUntilRenewal >= 0 && $daysUntilRenewal <= 30;
    }

    /**
     * Check if the software license is expired
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        // Forever licenses don't expire
        if ($this->forever || !$this->renewal_date) {
            return false;
        }

        return $this->renewal_date->isPast();
    }

    /**
     * Get the number of days until renewal
     *
     * @return int|null
     */
    public function getDaysUntilRenewalAttribute(): ?int
    {
        if ($this->forever || !$this->renewal_date) {
            return null;
        }

        return Carbon::now()->diffInDays($this->renewal_date, false);
    }

    /**
     * Scope a query to only include software expiring soon
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpiringSoon($query)
    {
        $thirtyDaysFromNow = Carbon::now()->addDays(30);
        
        return $query->where('forever', '!=', 1)
                     ->whereNotNull('renewal_date')
                     ->where('renewal_date', '>=', Carbon::now())
                     ->where('renewal_date', '<=', $thirtyDaysFromNow);
    }

    /**
     * Scope a query to only include expired software
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpired($query)
    {
        return $query->where('forever', '!=', 1)
                     ->whereNotNull('renewal_date')
                     ->where('renewal_date', '<', Carbon::now());
    }
}