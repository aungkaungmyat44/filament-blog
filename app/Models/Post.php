<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $casts = [
        'tags' => 'json',
    ];

    protected $fillable = [
        'thumbnail',
        'title',
        'color',
        'slug',
        'category_id',
        'content',
        'tags',
        'published'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function authors()
    {
        return $this->belongsToMany(User::class, 'post_users')
                    ->withPivot(['order'])
                    ->withTimestamps();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
