<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class File extends Model
{
    use HasFactory;


    /**
     * the fillable model fields
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'data'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public $timestamps = false;

         /**
     * the files post
     *
     * @return HasOne
     */
    public function post() : HasOne
    {
        return $this->hasOne(Post::class, 'main_image', 'id');
    }

    /**
     * the user
     *
     * @return HasOneThrough
     */
    public function user() : HasOneThrough
    {
        return $this->hasOneThrough(User::class, Post::class, 'owner', 'id');
    }
}
