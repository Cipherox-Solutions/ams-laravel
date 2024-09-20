<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsToMany;

class Attribute extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'attributes';

    protected $fillable = [
        'key',
        'label',
        'required',
        'default',
        'type',
        'options',
        'input_type',
        'placeholder',
    ];

    public function attributeGroups(): BelongsToMany
    {
        return $this->belongsToMany(AttributeGroup::class, 'attribute_group_attribute', 'attribute_id', 'attribute_group_id');
    }
}
