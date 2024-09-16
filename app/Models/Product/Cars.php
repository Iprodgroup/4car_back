<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cars extends Model
{
    use HasFactory;
    protected $table = 'cars';
    public $timestamps = false;
    protected $fillable =
        [
            'Status', 'CarMarkCode', 'CarModelCode',
            'CarModel', 'CarYear', 'CarModificationCode', 'Processing',
            'DiskProcessed', 'TireProcessed', 'Kuzov', 'Dvigatel',
            'krepezh', 'krepezhraz', 'krepezhraz2', 'counthole',
            'pcd', 'dia', 'diamax'
        ];
}
