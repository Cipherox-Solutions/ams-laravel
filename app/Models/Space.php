<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsToMany;

class Space extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'spaces';

    protected $fillable = [
        "name",
        'type',
        'floor',
        'sqft',
        'length',
        'width',
    ];

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'space_location', 'space_id', 'location_id');
    }
}
