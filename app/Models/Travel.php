<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Travel extends Model
{
    use HasFactory;
    protected $table = 'travels';

    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'name',
        'description',
        'moods',
        'numberOfDays',
    ];

    protected $casts = [
        'moods' => 'array',
    ];

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class, 'travelId');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($travel) {
            $travel->slug = Str::slug($travel->name);
            $travel->uuid = Str::uuid();
            $travel->public = true;
        });
    }
}
