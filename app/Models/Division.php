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

    protected $fillable = ['name'];

    public function departments(): HasMany {

        return $this->hasMany(Department::class, 'division_id', 'department_id');

    }

    public function organizations(): BelongsToMany {

        return $this->belongsToMany(Organization::class, 'organization_division', 'division_id', 'organization_id');
    }


}
