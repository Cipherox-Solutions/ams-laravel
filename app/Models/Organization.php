<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;

class Organization extends Model {

    protected $connection = 'mongodb';
    protected $collection = 'organization';

    protected $fillable = ['name', 'divisions', 'logo', 'website', 'registration', 'attributes'];

    public function divisions() {

        return $this->hasMany(Division::class, 'organization_id');

    }

}
