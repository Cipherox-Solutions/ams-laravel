<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsToMany;

class AttributeGroup extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'attribute_groups';

    protected $fillable = ['group_name'];

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'attribute_group_attribute', 'attribute_group_id', 'attribute_id');
    }

    public function assetTypes(): BelongsToMany
    {
        return $this->belongsToMany(AssetType::class, 'asset_type_attribute_group', 'attribute_group_id', 'asset_type_id');
    }
}
