<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table="comments";

    protected $fillable=[
        'id',
        'description',
        'post_id',
        'created_at',
        'updated_at',
        'parent_id',
        ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function replies()
    {
        return $this->hasMany(Comment::class,'parent_id','id');
    }
    public function replylimit()
    {
        return $this->belongsTo(Comment::class,'parent_id');
    }
}
