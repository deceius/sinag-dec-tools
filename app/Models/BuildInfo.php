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

    protected $appends = [
        'consumable_list',
        'equipment_list'
    ];

    function parseEquipmentArray ($items) {
        $result = [];
        foreach ($items as $item) {
            array_push($result, explode('|', $item));
        }
        return $result;
    }

    public function getConsumableListAttribute() {
        $attribute = $this->parseEquipmentArray(explode(',', $this->consumables));
        return $attribute;
    }


    public function getEquipmentListAttribute() {
        $attribute = $this->parseEquipmentArray(explode(',', $this->equipment));
        return $attribute;
    }
}
