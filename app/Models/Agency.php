<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
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
        'street',
        'zip',
        'city',
        'state_id'
    ];

    /**
     * Get the state that owns the agency.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the users for the agency.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
