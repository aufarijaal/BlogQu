<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['post_id', 'user_id', 'parent_id', 'content'];

    public function replies()
    {
        return $this->hasMany(Comment::class, "parent_id");
    }

    public function commenter()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }
}
