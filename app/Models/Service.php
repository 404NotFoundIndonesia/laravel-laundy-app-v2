<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    const UNIT_PCS = 'pcs';
    const UNIT_KG = 'kg';
    const UNIT_METER = 'm';

    public static function availableUnits(): array
    {
        return [
            self::UNIT_KG,
            self::UNIT_METER,
            self::UNIT_PCS,
        ];
    }

    protected $fillable = [
        'name', 'unit', 'original_price', 'sale_price',
    ];

    public function scopeFilter(Builder $query, ?array $filter)
    {
        return $query->when($filter, function (Builder $query) use ($filter) {
            return $query->whereIn('unit', $filter);
        });
    }

    public function scopeSearch(Builder $query, ?string $search)
    {
        return $query->when($search, function (Builder $query) use ($search) {
            return $query->where('name', 'LIKE', '%' . $search . '%');
        });
    }

    public function scopeRender(Builder $query, ?int $size): LengthAwarePaginator
    {
        return $query->paginate($size ?? 50)->withQueryString();
    }
}
