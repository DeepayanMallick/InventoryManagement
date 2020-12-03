<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function index(Request $request)
    {
        $query = new Supplier();
        $searchFields = ['name', 'company', 'address', 'phone', 'email'];
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

        $data['suppliers'] = $query->orderBy('id', 'desc')->paginate(20);

        return view('backend.supplier.index', $data);
    }


    public function store(SupplierRequest $request)
    {
        Supplier::create($request->all());

        return redirect()->back()->with('success', 'Supplier Added Successfully!');
    }


    public function show($id)
    {
        //
    }


    public function edit(Supplier $supplier, Request $request)
    {
        $query = new Supplier();
        $searchFields = ['name', 'company', 'address', 'phone', 'email'];
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

        $data['suppliers'] = $query->orderBy('id', 'desc')->paginate(20);

        $data['supplier'] = $supplier;

        return view('backend.supplier.edit', $data);
    }


    public function update(SupplierUpdateRequest $request, Supplier $supplier)
    {
        $supplier->update($request->all());

        return redirect()->back()->with('success', 'Supplier Updated Successfully!');
    }


    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect('suppliers')->with('success', 'Supplier Deleted Successfully!');
    }
}
