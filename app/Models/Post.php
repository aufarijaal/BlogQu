<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tonysm\RichTextLaravel\Casts\AsRichTextContent;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [
        "id"
    ];

    protected $casts = [
        'body' => AsRichTextContent::class,
    ];
    /**
     * The tags that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    /**
     * The category that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The user that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // LOCAL SCOPES
    public function scopeForPostCard($query)
    {
        return $query->select(["id", "user_id", "category_id", "title", "slug", "thumbnail", "excerpt", "status", "parent_id", "updated_at"]);
    }
}