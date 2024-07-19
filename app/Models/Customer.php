<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'address'
    ];

    public function scopeSearch(Builder $query, ?string $search)
    {
        return $query->when($search, function (Builder $query) use ($search) {
            return $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', $search);
        });
    }

    public function scopeRender(Builder $query, ?int $size): LengthAwarePaginator
    {
        return $query->paginate($size ?? 50)->withQueryString();
    }
}
