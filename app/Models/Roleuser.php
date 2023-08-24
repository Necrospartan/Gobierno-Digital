<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roleuser extends Model
{
    use HasFactory;
    protected $table = 'role_user';

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'user_id', 
        'role_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
