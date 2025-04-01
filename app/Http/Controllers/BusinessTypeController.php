<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessType;

class BusinessTypeController extends Controller
{
    public function index()
    {
        $businessTypes = BusinessType::all();
        return view('admin.business-types', compact('businessTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:business_types,name',
        ]);

        BusinessType::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Business type added successfully.');
    }

    public function destroy($id)
    {
        BusinessType::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Business type deleted successfully.');
    }
}
