<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsToMany;
use MongoDB\Laravel\Relations\HasMany;


class Location extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'locations';

    protected $fillable = [
        'name',
        'type',
        'address',
        'phone',
        'city',
        'state',
        'country',
        'zipcode',
        'geolocation',
    ];

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }

    public function locationTags(): BelongsToMany {
        return $this->belongsToMany(LocationTag::class, 'location_tag_location', 'location_id', 'location_tag_id');
    }
    public function spaces(): BelongsToMany {
        return $this->belongsToMany(Space::class, 'space_location', 'location_id', 'space_id');
    }
}
