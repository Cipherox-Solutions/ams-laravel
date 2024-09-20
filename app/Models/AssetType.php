<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;

use MongoDB\Laravel\Relations\BelongsToMany;

class AssetType extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'asset_types';

    protected $fillable = ['name', 'icon', 'color', 'traits'];


    public function assets() {
        return $this->hasMany(Asset::class, 'asset_type_id');
    }


    public function attributeGroups(): BelongsToMany
    {
        return $this->belongsToMany(AttributeGroup::class, 'asset_type_attribute_group', 'asset_type_id', 'attribute_group_id');
    }
}
