<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Cities
 * @package App\Models
 *
 * @mixin Builder
 */
class Cities extends Model
{
    protected $guarded =[];

    public function feedbacks(): BelongsTo
    {
        return $this->belongsTo(Feedbacks::class);
    }

    public function author(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
