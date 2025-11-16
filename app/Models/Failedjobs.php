<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Failedjobs extends Model
{
    use HasFactory;

      protected $fillable = [
        'sender',
        'department',
        'branch',
        'problem',
        'description',
        'ticket',
        'assigned',
    ];

    protected $table = 'failedjobs';
}
