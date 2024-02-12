<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MarketPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'city',
        'quality',
        'sell_price_min',
        'sell_price_min_date',
        'sell_price_max',
        'sell_price_max_date',
        'buy_price_min',
        'buy_price_min_date',
        'buy_price_max',
        'buy_price_max_date'
    ];

    protected $appends = ['has_prices', 'item_name'];

    public function getEnchant(){
        if (!Str::contains($this->item_id, '@')){
            return 0;
        }
        $enchantLevel = explode("@", $this->item_id)[1];
        return $enchantLevel;
    }

    public function getItemNameAttribute()
    {
        return ItemInfo::where('item_id', $this->item_id)->first()->item_name;
    }

    protected function hasPrices(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['sell_price_min'] > 0 || $attributes['buy_price_min'] > 0,
        );
    }


}
