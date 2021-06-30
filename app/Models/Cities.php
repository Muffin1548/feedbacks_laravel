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

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedbacks::class, 'city_id');
    }

    public function author(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
