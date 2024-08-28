<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product\Manufacturer;
use Illuminate\Http\Request;

class ManufacturersController extends Controller
{
    public function showAllManufacturers()
    {
        $manufacturers = Manufacturer::query()->paginate(15);
        return view('admin.manufacturers.index', compact('manufacturers'));
    }
}
