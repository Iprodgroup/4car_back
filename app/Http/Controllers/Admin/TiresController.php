<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tires;
use Illuminate\Http\Request;

class TiresController extends Controller
{
    public function index()
    {
        $tires = Tires::all();
        return view('admin.tires.index')->with($tires, 'tires');
    }
}
