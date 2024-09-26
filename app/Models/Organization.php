<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsToMany;

class Organization extends Model {

    protected $connection = 'mongodb';
    protected $collection = 'organization';

    protected $fillable = ['name', 'logo', 'website', 'registration', 'custom_attributes', 'selected_custom_attributes'];

    public function divisions(): BelongsToMany {

        return $this->belongsToMany(Division::class, 'organization_division', 'organization_id', 'division_id');
    }

}
