<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Status;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('for')){
            return Status::where('for', $request['for'])->get();
        }
        return Status::all();
    }

}
