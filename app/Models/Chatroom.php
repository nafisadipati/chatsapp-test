<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'max_members'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
