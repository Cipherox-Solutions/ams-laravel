<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Relations\BelongsToMany;
use MongoDB\Laravel\Relations\BelongsTo;

class Department extends Model
{


    protected $connection = 'mongodb';
    protected $collection = 'department';

    protected $fillable = ['name'];

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }

    public function division(): BelongsTo {
        return $this->belongsTo(Division::class);
    }

}

