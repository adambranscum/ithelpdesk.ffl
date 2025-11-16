<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject',
        'body',
        'from_email',
        'from_name',
        'received_time',
        'office_location',
        'department',
        'status',
        'problem_type',
        'device_name',
        'software_name',
        'network_name',
        'website_name',
        'security_name',
        'end_time',
        'comment',
        'assigned_to',
        'email_id',
    ];

    /**
     * The attributes that should be cast
     *
     * @var array<string, string>
     */
    protected $casts = [
        'received_time' => 'datetime',
    ];

    /**
     * Get the formatted ticket number
     *
     * @return string
     */
    public function getTicketNumberAttribute(): string
    {
        return 'TICKET-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Scope a query to only include tickets from a specific email
     *
     * @param Builder $query
     * @param string $email
     * @return Builder
     */
    public function scopeFromEmail(Builder $query, string $email): Builder
    {
        return $query->where('from_email', $email);
    }

    /**
     * Scope a query to only include tickets from a specific domain
     *
     * @param Builder $query
     * @param string $domain
     * @return Builder
     */
    public function scopeFromDomain(Builder $query, string $domain): Builder
    {
        return $query->where('from_email', 'LIKE', "%@{$domain}");
    }

    /**
     * Scope a query to only include tickets from a specific department
     *
     * @param Builder $query
     * @param string $department
     * @return Builder
     */
    public function scopeInDepartment(Builder $query, string $department): Builder
    {
        return $query->where('department', $department);
    }

    /**
     * Scope a query to order by most recent received time
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('received_time', 'desc');
    }

    /**
     * Get the short body preview
     *
     * @return string
     */
    public function getBodyPreviewAttribute(): string
    {
        return strlen($this->body) > 100 
            ? substr(strip_tags($this->body), 0, 100) . '...' 
            : strip_tags($this->body);
    }
}