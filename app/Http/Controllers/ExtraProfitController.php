<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExtraProfitRequest;
use App\Models\ExtraProfit;
use Illuminate\Http\Request;

class ExtraProfitController extends Controller
{

    public function index(Request $request)
    {
        $query = new ExtraProfit();
        $searchFields = ['note', 'amount'];
        $filter = $request->q;

        $from_date = !empty($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date = !empty($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : null;

        if (!empty($filter) && !empty($to_date) && !empty($from_date)) {
            $query = $query->whereDate("date", '>=', $from_date)
                ->whereDate("date", '<=', $to_date)
                ->orWhere(function ($q) use ($filter, $searchFields) {
                    $searchWildcard = '%' . $filter . '%';
                    foreach ($searchFields as $field) {
                        $q->orWhere($field, 'like', $searchWildcard);
                    }
                });
        } else if (empty($filter) && !empty($to_date) && !empty($from_date)) {
            $query = $query = $query->whereDate("date", '>=', $from_date)
                ->whereDate("date", '<=', $to_date);
        } else {
            $query = $query->whereDate('date', today());
        }

        $data['extraProfits'] = $query->orderBy('id', 'desc')->paginate(20);

        $data['filter'] = !empty($filter) ? $filter : null;    

        $data['from_date'] = !empty($request->from_date) ? date("d-m-Y", strtotime($request->from_date)) : null;
        $data['to_date'] = !empty($request->to_date) ? date("d-m-Y", strtotime($request->to_date)) : null;


        return view('backend.extra-profit.index', $data);
    }


    public function create()
    {
        //
    }


    public function store(ExtraProfitRequest $request)
    {
        ExtraProfit::create($request->all());

        return redirect()->back()->with('success', 'Extra Profit Added Successfully!');
    }


    public function show($id)
    {
        //
    }


    public function edit(ExtraProfit $extraProfit, Request $request)
    {
        $query = new ExtraProfit();
        $searchFields = ['note', 'amount'];
        $filter = $request->q;

        $from_date = !empty($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date = !empty($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : null;

        if (!empty($filter) && !empty($to_date) && !empty($from_date)) {
            $query = $query->whereDate("date", '>=', $from_date)
                ->whereDate("date", '<=', $to_date)
                ->orWhere(function ($q) use ($filter, $searchFields) {
                    $searchWildcard = '%' . $filter . '%';
                    foreach ($searchFields as $field) {
                        $q->orWhere($field, 'like', $searchWildcard);
                    }
                });
        } else if (empty($filter) && !empty($to_date) && !empty($from_date)) {
            $query = $query = $query->whereDate("date", '>=', $from_date)
                ->whereDate("date", '<=', $to_date);
        } else {
            $query = $query->whereDate('date', today());
        }

        $data['extraProfits'] = $query->orderBy('id', 'desc')->paginate(20);

        $data['extraProfit'] = $extraProfit;

        $data['filter'] = !empty($filter) ? $filter : null;    

        $data['from_date'] = !empty($request->from_date) ? date("d-m-Y", strtotime($request->from_date)) : null;
        $data['to_date'] = !empty($request->to_date) ? date("d-m-Y", strtotime($request->to_date)) : null;


        return view('backend.extra-profit.edit', $data);
    }


    public function update(ExtraProfit $extraProfit, ExtraProfitRequest $request)
    {
        $extraProfit->update($request->all());

        return redirect()->back()->with('success', 'Extra Profit Updated Successfully!');
    }


    public function destroy(ExtraProfit $extraProfit)
    {
        $extraProfit->delete();

        return redirect()->route('extra-profit.index')->with('success', 'Extra Profit Deleted Successfully!');
    }
}
