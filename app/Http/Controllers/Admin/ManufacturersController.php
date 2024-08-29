<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManufacturersController extends Controller
{
    public function showAllManufacturers()
    {
        $manufacturers = Manufacturer::query()->paginate(15);
        return view('admin.manufacturers.index', compact('manufacturers'));
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
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $manufacturer = Manufacturer::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($manufacturer->image) {
                Storage::delete($manufacturer->image);
            }

            $imagePath = $request->file('image')->store('manufacturers', 'public');
            $validated['image'] = $imagePath;
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
