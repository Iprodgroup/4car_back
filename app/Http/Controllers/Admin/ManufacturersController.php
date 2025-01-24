<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product\Manufacturer;
use Illuminate\Support\Facades\Storage;

class ManufacturersController extends Controller
{
    public function showAllManufacturers()
    {
        $manufacturers = Manufacturer::query()->paginate(15);
        return view('admin.manufacturers.index', compact('manufacturers'));
    }

    public function create()
    {
        return view('admin.manufacturers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'picture_id' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('picture_id')) {
            $imagePath = $request->file('picture_id')->store('manufacturers', 'public');
            $validated['picture_id'] = $imagePath;
        }
        Manufacturer::create($validated);

        return redirect()->route('admin.manufacturers.index')->with('success', 'Производитель успешно создан!');
    }


    public function edit($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        return view('admin.manufacturers.edit', compact('manufacturer'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'picture_id' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $manufacturer = Manufacturer::findOrFail($id);

        if ($request->hasFile('picture_id')) {
            if ($manufacturer->picture_id) {
                Storage::delete('public/' . $manufacturer->picture_id);
            }

            $imagePath = $request->file('picture_id')->store('manufacturers', 'public');
            $validated['picture_id'] = $imagePath;
        }

        $manufacturer->update($validated);

        return redirect()->route('admin.manufacturers.index')->with('success', 'Производитель успешно обновлен!');
    }

    public function destroy($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->delete();
        return redirect()->route('admin.manufacturers.index');
    }
}
