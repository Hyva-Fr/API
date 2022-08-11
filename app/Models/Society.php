<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society extends Model
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
        'description',
        'street',
        'zip',
        'city',
        'country'
    ];

    /**
     * Get the missions for the society.
     */
    public function missions()
    {
        return $this->hasMany(Mission::class);
    }
}
