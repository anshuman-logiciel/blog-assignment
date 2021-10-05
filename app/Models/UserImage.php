<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;
    protected $table="user_image";
     
    protected $fillable=[
        'id',
        'users_id',
        'images',
        'created_at',
        'updated_at'                                                            
    ];
}
