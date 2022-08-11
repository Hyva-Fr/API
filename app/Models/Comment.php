<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comment',
        'user_id',
        'mission_id'
    ];

    /**
     * Get the mission that owns the comment.
     */
    public function workflow()
    {
        return $this->belongsTo(Mission::class);
    }
}
