<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\BelongsToMany;


class Asset extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'assets';

    protected $fillable = ['name', 'asset_type_id', 'attributes', 'traits'];

    public function assetType(): BelongsTo
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id');
    }

    public function assetTags(): BelongsToMany
    {
        return $this->belongsToMany(AssetTag::class, 'asset_tag_asset', 'asset_id', 'asset_tag_id');
    }

}
