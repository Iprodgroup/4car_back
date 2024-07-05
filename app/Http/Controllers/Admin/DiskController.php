<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disk;
use Illuminate\Http\Request;

class DiskController extends Controller
{
    public function index()
    {
        $disks = Disk::all();
        return view('admin.disks.index')->with('disks', $disks);
    }
}
