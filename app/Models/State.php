<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
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
        'code',
        'country_id'
    ];

    /**
     * Get the country that owns the state.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the agencies for the state.
     */
    public function agencies()
    {
        return $this->hasMany(Agency::class);
    }
}
