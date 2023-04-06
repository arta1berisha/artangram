<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'slug', 'title', 'post_image', 'description'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->belongsTo(Post::class)->orderBy('created_at', 'DESC');
    }
    
    public function comments() 
    {
        return $this->hasManyThrough(Comment::class, Post::class);
    }

    public function likes()
    {
        return $this->hasManyThrough(Like::class, Post::class);
    }

    public function commentLikes()
    {
        return $this->hasManyThrough(Like::class, Comment::class);
    }
}
