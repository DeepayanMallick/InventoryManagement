<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Pay;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index(Request $request)
    {

        $query = new Customer();
        $searchFields = ['name', 'phone', 'address'];
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

        $data['customers'] = $query->orderBy('id', 'desc')->paginate(20);

        return view('backend.customer.index', $data);
    }


    public function store(CustomerRequest $request)
    {
        Customer::create($request->all());

        return redirect()->back()->with('success', 'Customer Added Successfully!');
    }


    public function show($id)
    {
        //
    }


    public function edit(Customer $customer, Request $request)
    {
        $query = new Customer();
        $searchFields = ['name', 'phone', 'address'];
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

        $data['customers'] = $query->orderBy('id', 'desc')->paginate(20);

        $data['customer'] = $customer;

        return view('backend.customer.edit', $data);
    }


    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        $customer->update($request->all());

        return redirect()->back()->with('success', 'Customer Updated Successfully!');
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect('customers')->with('success', 'Customer Deleted Successfully!');
    }


    public function search(Request $request)
    {
        $searchFields = ['name', 'phone', 'address'];
        $filter = $request->q;

        if (!empty($filter)) {
            $query = Customer::where(function ($q) use ($filter, $searchFields) {
                $searchWildcard = '%' . $filter . '%';
                foreach ($searchFields as $field) {
                    $q->orWhere($field, 'like', $searchWildcard);
                }
            })->orderBy('id', 'desc')->get();
        } else {
            $query = [];
        }

        $data['customers'] = $query;

        $searchResult = view('backend.customer.template.search-result', $data)->render();

        return response()->json($searchResult);
    }

    public function customerDetails(Request $request)
    {
        $customer = Customer::find($request->cid);

        $data['customer'] = $customer;

        $customerInfo = view('backend.customer.template.customer-info', $data)->render();

        return response()->json($customerInfo);
    }


    public function customerDue(Request $request)
    {
        $customers = Customer::where('due', '!=', '0')->with('orders')->orderBy('id', 'desc')->paginate(20);  

        $data['customers'] = $customers;

        $data['totalDue'] = number_format($customers->sum('due'));

        return view('backend.customer.template.customers-due', $data);
    }


    public function customerInvoice($id)
    {
        $customer = Customer::find($id);

        $data['customer'] = $customer;

        $orders = Order::where('customer_id', $id)->where('due', '!=', '0')->orderBy('id', 'desc')->paginate(20);

        $data['totalDue'] = number_format($orders->sum('due'));

        $data['orders'] = $orders;

        return view('backend.customer.template.customer-invoice', $data);
    }
}
