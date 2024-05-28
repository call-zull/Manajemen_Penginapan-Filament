<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'No_Kamar',
        'type_id',
        'Harga',
        'Is_People',
        'Is_Clean',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
}