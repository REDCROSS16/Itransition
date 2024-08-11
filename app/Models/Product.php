<?php declare(strict_types=1);

namespace App\Models;

use App\Support\Casts\PriceCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Product extends Model
{
    use HasFactory;

    protected $table = 'tblProductData';

    protected $fillable = [
        'strProductName',
        'strProductDesc',
        'strProductCode',
        'stock',
        'price',
        'dtmAdded',
        'dtmDiscontinued',
        'stmTimestamp'
    ];

    protected $casts = [
        'price'  => PriceCast::class,
    ];

    protected $primaryKey = 'intProductDataId';

    public $timestamps = false;

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $validator = validator($model->attributesToArray(), [
                'strProductName'  => 'required|string|max:50',
                'strProductDesc'  => 'required|string|max:255',
                'strProductCode'  => 'required|string|max:10',
                'dtmAdded'        => 'nullable|date',
                'dtmDiscontinued' => 'nullable|date',
                'stmTimestamp'    => 'date',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        });
    }

    /**
     * @param $value
     * @return $this
     */
    public function setUpdatedAt($value): self
    {
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setCreatedAt($value): self
    {
        return $this;
    }
}
