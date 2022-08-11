<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'serial',
        'review',
        'distribution_plan',
        'clamping_plan',
        'electrical_diagram',
        'workshops_help',
        'receipt',
        'delivery_note',
        'society_id',
        'agency_id',
        'description',
        'images',
        'done'
    ];

    /**
     * Get the society that owns the mission.
     */
    public function society()
    {
        return $this->belongsTo(Society::class);
    }

    /**
     * Get the agency that owns the mission.
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
