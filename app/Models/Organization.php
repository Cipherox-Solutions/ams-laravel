<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;

class Organization extends Model {

    protected $connection = 'mongodb';
    protected $collection = 'organization';

    protected $fillable = ['name', 'logo', 'website', 'registration', 'custom_attributes', 'selected_custom_attributes'];

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }

    public function divisions(): HasMany {
        return $this->hasMany(Division::class);
    }

}
