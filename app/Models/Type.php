<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'Tipe Kamar';

    use HasFactory;
    protected $fillable = [
        'Name',
    ];
}