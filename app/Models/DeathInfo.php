<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeathInfo extends Model
{
    protected $fillable = [
        'id',
        'battle_id',
        'character_id',
        'name',
        'guild',
        'equipment',
        'killer_name',
        'killer_guild',
        'killer_equipment',
        'killer_guild',
        'death_fame',
        'regeared_by',
        'allowed_gears',
        'is_oc',
        'timestamp',
        'regear_cost',
        'role_id'
    ];



    protected $casts = [
        'timestamp' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'is_oc' => 'boolean'
    ];

    protected $appends = [
        'url'
    ];

    protected function getUrlAttribute() {
        return url('regear/'.$this->getKey());
    }

    public function regearingOfficer()
    {
        return $this->belongsTo(User::class, 'regeared_by');
    }

    public function memberInfo()
    {
        return $this->belongsTo(User::class, 'character_id', 'ao_character_id');
    }

}
