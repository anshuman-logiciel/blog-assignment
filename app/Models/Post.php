<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    use HasFactory;
    protected $perPage = 10;
    protected $table="posts";
     
    protected $fillable=[
        'id',
        'title',
        'description',
        'created_at',
        'updated_at'
    ];

    public function comments()
    {
        return $this->hasmany(Comment::class);
    }

}
