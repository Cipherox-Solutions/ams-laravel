<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsToMany;


class LocationTag extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'location_tags';

    protected $fillable = ['name'];

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'location_tag_location', 'location_tag_id', 'location_id');
    }
}
