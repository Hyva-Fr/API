<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
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
        'category_id',
        'form',
        'user_id'
    ];

    /**
     * Get the category that owns the form.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user associated with the form.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
