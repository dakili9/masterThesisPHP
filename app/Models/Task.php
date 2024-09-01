<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'status', 'description', 'due_date','user_id', 'category_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'status' => TaskStatus::class,
        'due_date' => 'datetime'
    ];

    /**
     * Scope a query to filter tasks by user.
     *
     * @param Builder $query
     * @param string $userId
     * @return Builder
     */
    public function scopeByUser(Builder $query, string $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to filter tasks by category.
     *
     * @param Builder $query
     * @param string $categoryId
     * @return Builder
     */
    public function scopeByCategory(Builder $query, string $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to filter tasks by status.
     *
     * @param Builder $query
     * @param string $status
     * @return Builder
     */
    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->whereRaw('LOWER(status) = ?', [strtolower($status)]);
    }

    /**
     * Scope a query to filter tasks that are due before a specific date.
     *
     * @param Builder $query
     * @param string|Carbon $date
     * @return Builder
     */
    public function scopeByDueBefore(Builder $query,  string|Carbon $date): Builder
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $query->whereDate('due_date', '<=', $date);
    }

    /**
     * Connection to user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Connection to category
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
