<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'wrnt',
        'master_id',
    ];

    // хозяин вещи
    public function master()
    {
        return $this->belongsTo(User::class, 'master_id');
    }

    // все использования этой вещи
    public function usage()
    {
        return $this->hasOne(Usage::class);
    }
}
