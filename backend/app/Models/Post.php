<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

     /* 
     RELATIONSHIPS
     1 user has 1 phone number
     One to one

     A post belongs to a user
     One to One (Inverse)

     1 User has many Posts
     One to many


     
     */

     public function user() {
        //A post belongs to a user
        //belongsTo - one to one (inverse)
        return $this->belongsTo(User::class);
     }

     public function comments() {
        return $this->hasMany(Comment::class);
     }
     
}
