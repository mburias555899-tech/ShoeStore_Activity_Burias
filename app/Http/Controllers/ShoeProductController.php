<?php

namespace App\Http\Controllers;

use App\Models\ShoeProduct;
use Illuminate\Http\Request;

class ShoeProductController extends Controller
{
    public function index()
    {
        $shoeProducts = ShoeProduct::all();

        return view('shoe-products', compact('shoeProducts'));
    }

    public function create()
    {
        return view('shoe-products');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'size' => 'required',
            'color' => 'required',
            'stock_quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        ShoeProduct::create($request->all());

        return redirect()->route('shoe-products.index')
            ->with('success', 'Shoe product added successfully.');
    }

    public function show(string $id)
    {
        $shoeProduct = ShoeProduct::findOrFail($id);

        return view('shoe-products', compact('shoeProduct'));
    }

    public function edit(string $id)
    {
        $shoeProduct = ShoeProduct::findOrFail($id);

        return view('shoe-products', compact('shoeProduct'));
    }

    public function update(Request $request, string $id)
    {
        $shoeProduct = ShoeProduct::findOrFail($id);

        $request->validate([
            'product_name' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'size' => 'required',
            'color' => 'required',
            'stock_quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $shoeProduct->update($request->all());

        return redirect()->route('shoe-products.index')
            ->with('success', 'Shoe product updated successfully.');
    }

    public function destroy(string $id)
    {
        $shoeProduct = ShoeProduct::findOrFail($id);

        $shoeProduct->delete();

        return redirect()->route('shoe-products.index')
            ->with('success', 'Shoe product deleted successfully.');
    }
}