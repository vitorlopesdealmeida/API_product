<?php

namespace Modules\Product\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Database\Factories\ProductFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'products';


    const STATUS_ESTOQUE = 'em estoque';
    const STATUS_REPOSICAO = 'em reposição';
    const STATUS_FALTA = 'em falta';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
        'stock_quantity',

    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_ESTOQUE,
            self::STATUS_REPOSICAO,
            self::STATUS_FALTA
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if (!in_array($product->status, self::getStatuses())) {
                throw new \InvalidArgumentException("Invalid status for product.");
            }
        });
    }


    public function scopeName($query, $name)
    {
        return $query->where('name', 'like', "%$name%");
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when(! empty($filters['name']), fn ($query) => $query->name($filters['name']))
            ;
    }
}
