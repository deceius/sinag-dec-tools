<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildInfo extends Model
{
    protected $fillable = [
        'id',
        'role_id',
        'equipment',
        'consumables',
        'notes',
    ];
}
