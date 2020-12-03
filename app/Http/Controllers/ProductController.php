<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $query = new Product();
        $searchFields = ['title', 'code', 'description'];
        $filter = $request->q;

        $data['filter'] = !empty($filter) ? $filter : null;

        if (!empty($filter)) {
            $query = $query->where(function ($q) use ($filter, $searchFields) {
                $searchWildcard = '%' . $filter . '%';
                foreach ($searchFields as $field) {
                    $q->orWhere($field, 'like', $searchWildcard);
                }
            });
        }

        $data['products'] = $query->orderBy('id', 'desc')->paginate(20);

        $suppliers = Supplier::pluck('name', 'id');

        $data['suppliers'] = $suppliers;

        return view('backend.product.index', $data);
    }

    public function store(ProductRequest $request)
    {
        Product::create(array_merge(
            $request->all(),
            [
                'available_stock' => $request->stock,
                'total_price' => floatval($request->retail_price) * floatval($request->stock)
            ]
        ));

        return redirect()->back()->with('success', 'Product Added Successfully!');
    }

    public function show($id)
    {
        //
    }


    public function edit(Product $product, Request $request)
    {
        $query = new Product();
        $searchFields = ['title', 'code', 'description'];
        $filter = $request->q;

        $data['filter'] = !empty($filter) ? $filter : null;

        if (!empty($filter)) {
            $query = $query->where(function ($q) use ($filter, $searchFields) {
                $searchWildcard = '%' . $filter . '%';
                foreach ($searchFields as $field) {
                    $q->orWhere($field, 'like', $searchWildcard);
                }
            });
        }

        $data['products'] = $query->orderBy('id', 'desc')->paginate(20);

        $data['product'] = $product;

        $suppliers = Supplier::pluck('name', 'id');

        $data['suppliers'] = $suppliers;

        return view('backend.product.edit', $data);
    }


    public function update(Product $product, ProductRequest $request)
    {
        $available_stock = $product->stock == $product->available_stock ? $request->stock : $product->available_stock;

        $product->update(array_merge(
            $request->except('stock'),
            [
                'stock' => $product->stock == $product->available_stock ? $request->stock : $product->stock,
                'available_stock' => $available_stock,
                'total_price' => floatval($request->retail_price) * floatval($available_stock)
            ]
        ));

        return redirect()->back()->with('success', 'Product Updated Successfully!');
    }


    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('products')->with('success', 'Product Deleted Successfully!');
    }

    public function search(Request $request)
    {
        $searchFields = ['title', 'code', 'description'];
        $filter = $request->q;

        if (!empty($filter)) {
            $query = Product::where(function ($q) use ($filter, $searchFields) {
                $searchWildcard = '%' . $filter . '%';
                foreach ($searchFields as $field) {
                    $q->orWhere($field, 'like', $searchWildcard);
                }
            })->get();
        } else {
            $query = [];
        }

        $data['products'] = $query;
        $data['count'] = $request->count;

        $searchResult = view('backend.product.template.search-result', $data)->render();

        return response()->json($searchResult);
    }

    public function price(Request $request)
    {
        $product = Product::find($request->pid);

        $sales_price = $product->sales_price;
        $available_stock = $product->available_stock;

        return response()->json(array(
            'available_stock'        => $available_stock,
            'sales_price'            => $sales_price,
        ));
    }
}
