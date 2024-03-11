<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Tour extends Model
{
    use HasFactory;
    protected $table = 'tours';
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    protected $with = ['travels'];
    protected $fillable = [
        'travelId',
        'name',
        'startingDate',
        'endingDate',
        'price',
    ];

    protected $casts = [
        'startingDate' => 'date',
        'endingDate' => 'date',
    ];
    public function travels(): BelongsTo
    {
        return $this->belongsTo(Travel::class, 'travelId');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tour) {
            $tour->uuid = Str::uuid();
        });
    }
}
