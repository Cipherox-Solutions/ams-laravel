<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\BelongsToMany;

class Request extends Model {

    protected $connection = 'mongodb';
    protected $collection = 'requests'; 
    
}
