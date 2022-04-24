<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;



class Post extends Model
{
    use Sluggable;
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'img_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments() {
       return $this->morphMany(Comment::class,'commentable');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
