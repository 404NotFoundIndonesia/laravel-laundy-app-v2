<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionItemLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'service_id', 'unit', 'quantity',
        'price', 'discount', 'additional_fee', 'subtotal',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
