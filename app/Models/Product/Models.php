<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Models extends Model
{
    use HasFactory;
    protected $fillable = ['brand_id', 'brand_name', 'name', 'type',
        'shirina', 'visota', 'diametr', 'shipi', 'sezonnost', 'index_n',
        'index_s', 'runflat', 'tip','shirina_diska', 'vilet', 'count_otverstiy','diametr_otverstiy','pcd','color', 'massa'
        ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
