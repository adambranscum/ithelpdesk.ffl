<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Sop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'category',
        'description',
        'steps',
        'tags',
        'difficulty',
        'estimated_time',
        'is_active',
        'view_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'view_count' => 'integer',
        'estimated_time' => 'integer',
    ];

    /**
     * Get the tickets associated with this SOP
     */
    public function tickets()
    {
        return $this->belongsToMany(Ticket::class)->withTimestamps();
    }

    /**
     * Get tags as an array
     */
    public function getTagsArrayAttribute()
    {
        if (!$this->tags) {
            return [];
        }
        return array_filter(array_map('trim', explode(',', $this->tags)));
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('view_count');
    }

    /**
     * Scope to only include active SOPs
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by category
     */
    public function scopeCategory(Builder $query, $category): Builder
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to filter by difficulty
     */
    public function scopeDifficulty(Builder $query, $difficulty): Builder
    {
        return $query->where('difficulty', $difficulty);
    }

    /**
     * Scope to search SOPs
     */
    public function scopeSearch(Builder $query, $search): Builder
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('steps', 'LIKE', "%{$search}%")
              ->orWhere('tags', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope to get popular SOPs
     */
    public function scopePopular(Builder $query): Builder
    {
        return $query->orderBy('view_count', 'desc');
    }

    /**
     * Scope to get recent SOPs
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }
}