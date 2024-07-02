<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

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
