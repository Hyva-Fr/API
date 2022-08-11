<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validate extends Model
{
    use HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'form_id',
        'form',
        'mission_id',
        'mission',
        'uri',
        'content'
    ];

    /**
     * Get the mission that owns the validated form.
     */
    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    /**
     * Get the user associated with the validated form.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the user associated with the validated form.
     */
    public function form()
    {
        return $this->hasOne(Form::class);
    }
}
