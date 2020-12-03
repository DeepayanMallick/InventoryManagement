<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{

    public function index(Request $request)
    {
        $query = new Product();
        $searchFields = ['title', 'code'];
        $filter = $request->q;

        $data['filter'] = !empty($filter) ? $filter : null;

        $from_date = !empty($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date = !empty($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : null;


        if (!empty($filter) && !empty($to_date) && !empty($from_date)) {
            $query = $query->whereDate("created_at", '>=', $from_date)
                ->whereDate("created_at", '<=', $to_date)
                ->orWhere(function ($q) use ($filter, $searchFields) {
                    $searchWildcard = '%' . $filter . '%';
                    foreach ($searchFields as $field) {
                        $q->orWhere($field, 'like', $searchWildcard);
                    }
                });
        } else if (empty($filter) && !empty($to_date) && !empty($from_date)) {
            $query = $query = $query->whereDate("created_at", '>=', $from_date)
                ->whereDate("created_at", '<=', $to_date);
        } else {
            $query = $query->whereDate('created_at', today());
        }

        $data['products'] = $query->orderBy('id', 'desc')->paginate(20);

        $data['from_date'] = !empty($request->from_date) ? date("d-m-Y", strtotime($request->from_date)) : null;
        $data['to_date'] = !empty($request->to_date) ? date("d-m-Y", strtotime($request->to_date)) : null;

        return view('backend.stock.index', $data);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $data['product'] = $product;      

        return view('backend.product.template.add-stock', $data);
    }


    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $stock = $product->stock + $request->new_stock;
        $available_stock = $product->available_stock + $request->new_stock;

        $product->update([
            'stock' => $stock,
            'available_stock' => $available_stock,
            'total_price' => floatval($product->retail_price) * floatval($available_stock)
        ]);

        return redirect()->back()->with('success', 'New Stock Added Successfully!');
    }

 
    public function destroy($id)
    {
        //
    }
}
