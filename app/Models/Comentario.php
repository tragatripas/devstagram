<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'comentario',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username', 'imagen']);
    }
}
