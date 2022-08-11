<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'land_code',
        'short_code',
        'zone_id'
    ];

    /**
     * Get the states for the country.
     */
    public function states()
    {
        return $this->hasMany(State::class);
    }

    /**
     * Get the zone that owns the country.
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
