<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Relations\BelongsTo;


class Division extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'division';

    protected $fillable = ['name'];

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }

    public function departments(): HasMany {
        return $this->hasMany(Department::class);
    }

    public function organization(): BelongsTo {
        return $this->belongsTo(Organization::class);
    }
}
