<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::select(['id', 'name', 'sku', 'stock'])
                ->orderBy('stock', 'asc');

            return DataTables::of($products)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    return $row->stock > 0
                        ? '<span class="badge bg-success">In Stock</span>'
                        : '<span class="badge bg-danger">Out of Stock</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.inventory.edit', $row->id);
                    return '<a href="'.$editUrl.'" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i> Update Stock
                            </a>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.inventory.index');
    }

    public function edit($id)
    {
        $product = Product::select('id','name','sku','stock')->findOrFail($id);
        return view('admin.inventory.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->stock = $request->stock;
        $product->save();

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Stock updated successfully.');
    }
}
