<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_guild_content',
        'title',
        'article',
        'parent_id'
    ];
}
