<?php

namespace App\Http\Controllers;

use App\Models\ShoeProduct;
use Illuminate\Http\Request;

class ShoeProductController extends Controller
{
    /**
     * Display all products
     */
    public function index()
    {
        $shoeProducts = ShoeProduct::all();

        return view('shoe-products.index', compact('shoeProducts'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('shoe-products.create');
    }

    /**
     * Store new product
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'size' => 'required',
            'color' => 'required',
            'stock_quantity' => 'required|integer',
            'price' => 'required|numeric',
            'description' => 'nullable',
        ]);

        ShoeProduct::create($request->all());

        return redirect()->route('shoe-products.index')
            ->with('success', 'Shoe product added successfully.');
    }

    /**
     * Show single product
     */
    public function show(ShoeProduct $shoeProduct)
    {
        return view('shoe-products.show', compact('shoeProduct'));
    }

    /**
     * Show edit form
     */
    public function edit(ShoeProduct $shoeProduct)
    {
        return view('shoe-products.edit', compact('shoeProduct'));
    }

    /**
     * Update product
     */
    public function update(Request $request, ShoeProduct $shoeProduct)
    {
        $request->validate([
            'product_name' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'size' => 'required',
            'color' => 'required',
            'stock_quantity' => 'required|integer',
            'price' => 'required|numeric',
            'description' => 'nullable',
        ]);

        $shoeProduct->update($request->all());

        return redirect()->route('shoe-products.index')
            ->with('success', 'Shoe product updated successfully.');
    }

    /**
     * Delete product
     */
    public function destroy(ShoeProduct $shoeProduct)
    {
        $shoeProduct->delete();

        return redirect()->route('shoe-products.index')
            ->with('success', 'Shoe product deleted successfully.');
    }
}