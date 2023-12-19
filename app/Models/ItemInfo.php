<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemInfo extends Model
{
    protected $fillable = [
        'id',
        'item_id',
        'item_name'
    ];
}
