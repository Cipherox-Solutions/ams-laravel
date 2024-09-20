<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsToMany;

class AssetTag extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'asset_tags';

    protected $fillable = ['name'];

    public function assets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class, 'asset_tag_asset', 'asset_tag_id', 'asset_id');
    }
}
