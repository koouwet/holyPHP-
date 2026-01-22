<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThingArchive extends Model
{
    protected $fillable = [
        'name',
        'description',
        'owner_name',
        'last_user_name',
        'place_name',
        'restored',
    ];
}
