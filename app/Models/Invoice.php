<?php

namespace App\Models;

use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'check_in',
        'check_out',
        'room_id',
        'name_customer'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    // Metode untuk menghitung total harga
    public function getTotalPriceAttribute()
    {
        $checkIn = \Carbon\Carbon::parse($this->check_in);
        $checkOut = \Carbon\Carbon::parse($this->check_out);
        $days = $checkIn->diffInDays($checkOut);

        return $days * $this->room->Harga;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            $lastInvoice = self::latest()->first();
            $lastNumber = ($lastInvoice) ? intval(substr($lastInvoice->invoice_number, 4)) : 0;
            $newNumber = $lastNumber + 1;
            $invoice->invoice_number = 'INV-' . $newNumber;
        });
    }
}