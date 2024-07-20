<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'start_date', 'target_date', 'end_date', 'payment_date',
        'customer_id', 'status', 'payment', 'note', 'user_id',
        'subtotal', 'discount', 'tax', 'additional_fee', 'grand_total',
        'discount_percentage', 'tax_percentage',
    ];

    public function itemLines(): HasMany
    {
        return $this->hasMany(TransactionItemLine::class, 'transaction_id', 'id');
    }

    public function scopeSearch(Builder $query, ?string $search)
    {
        return $query;
    }

    public function scopeRender(Builder $query, ?int $size): LengthAwarePaginator
    {
        return $query->paginate($size ?? 50)->withQueryString();
    }
}
