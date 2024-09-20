<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Relations\BelongsToMany;
use MongoDB\Laravel\Relations\BelongsTo;


class Division extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'division';

    protected $fillable = ['name', 'organization_id' ];

    public function departments() {

        return $this->hasMany(Department::class, 'division_id');
        
    }
    
    public function organization() {

        return $this->belongsTo(Organization::class, 'organization_id');
    }


}
