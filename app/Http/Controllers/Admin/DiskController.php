<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product\Disk;

class DiskController extends Controller
{
    public function index()
    {
        $disks = Disk::all();
        return view('admin.disks.index')->with('disks', $disks);
    }
}
