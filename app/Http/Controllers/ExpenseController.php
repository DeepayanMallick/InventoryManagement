<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

    public function index(Request $request)
    {
        $query = new Expense();
        $searchFields = ['note', 'amount'];
        $filter = $request->q;
        $type = $request->type;        

        $from_date = !empty($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date = !empty($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : null;

        if (!empty($filter) && !empty($type) && !empty($to_date) && !empty($from_date)) {
            $query = $query = $query->whereDate("date", '>=', $from_date)
                ->whereDate("date", '<=', $to_date)
                ->orWhere(function ($q) use ($filter, $searchFields) {
                    $searchWildcard = '%' . $filter . '%';
                    foreach ($searchFields as $field) {
                        $q->orWhere($field, 'like', $searchWildcard);
                    }
                })
                ->orWhere(function ($q) use ($type) {
                    $searchWildcard = '%' . $type . '%';
                    $q->orWhere('type', 'like', $searchWildcard);
                });
        } else if (!empty($type) && empty($filter) && !empty($to_date) && !empty($from_date)) {
            $query = $query->whereDate("date", '>=', $from_date)
                ->whereDate("date", '<=', $to_date)
                ->orWhere(function ($q) use ($type) {
                    $searchWildcard = '%' . $type . '%';
                    $q->orWhere('type', 'like', $searchWildcard);
                });
        } else if (empty($type) && !empty($filter) && !empty($to_date) && !empty($from_date)) {
            $query = $query->whereDate("date", '>=', $from_date)
                ->whereDate("date", '<=', $to_date)
                ->orWhere(function ($q) use ($filter, $searchFields) {
                    $searchWildcard = '%' . $filter . '%';
                    foreach ($searchFields as $field) {
                        $q->orWhere($field, 'like', $searchWildcard);
                    }
                });
        } else if (empty($type) && empty($filter) && !empty($to_date) && !empty($from_date)) {
            $query = $query = $query->whereDate("date", '>=', $from_date)
                ->whereDate("date", '<=', $to_date);
        } else {
            $query = $query->whereDate('date', today());
        }

        $data['expenses'] = $query->orderBy('id', 'desc')->paginate(20);

        $data['filter'] = !empty($filter) ? $filter : null;
        $data['type'] = !empty($type) ? $type : null;

        $data['from_date'] = !empty($request->from_date) ? date("d-m-Y", strtotime($request->from_date)) : null;
        $data['to_date'] = !empty($request->to_date) ? date("d-m-Y", strtotime($request->to_date)) : null;

        $data['types'] = config('constants.types');

        return view('backend.expense.index', $data);
    }


    public function store(ExpenseRequest $request)
    {
        Expense::create($request->all());

        return redirect()->back()->with('success', 'Expense Added Successfully!');
    }


    public function show($id)
    {
        //
    }


    public function edit(Expense $expense, Request $request)
    {
        $query = new Expense();
        $searchFields = ['note', 'amount'];
        $filter = $request->q;
        $type = $request->type;        

        $from_date = !empty($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date = !empty($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : null;

        if (!empty($filter) && !empty($type) && !empty($to_date) && !empty($from_date)) {
            $query = $query = $query->whereDate("date", '>=', $from_date)
                ->whereDate("date", '<=', $to_date)
                ->orWhere(function ($q) use ($filter, $searchFields) {
                    $searchWildcard = '%' . $filter . '%';
                    foreach ($searchFields as $field) {
                        $q->orWhere($field, 'like', $searchWildcard);
                    }
                })
                ->orWhere(function ($q) use ($type) {
                    $searchWildcard = '%' . $type . '%';
                    $q->orWhere('type', 'like', $searchWildcard);
                });
        } else if (!empty($type) && empty($filter) && !empty($to_date) && !empty($from_date)) {
            $query = $query->whereDate("date", '>=', $from_date)
                ->whereDate("date", '<=', $to_date)
                ->orWhere(function ($q) use ($type) {
                    $searchWildcard = '%' . $type . '%';
                    $q->orWhere('type', 'like', $searchWildcard);
                });
        } else if (empty($type) && !empty($filter) && !empty($to_date) && !empty($from_date)) {
            $query = $query->whereDate("date", '>=', $from_date)
                ->whereDate("date", '<=', $to_date)
                ->orWhere(function ($q) use ($filter, $searchFields) {
                    $searchWildcard = '%' . $filter . '%';
                    foreach ($searchFields as $field) {
                        $q->orWhere($field, 'like', $searchWildcard);
                    }
                });
        } else if (empty($type) && empty($filter) && !empty($to_date) && !empty($from_date)) {
            $query = $query = $query->whereDate("date", '>=', $from_date)
                ->whereDate("date", '<=', $to_date);
        } else {
            $query = $query->whereDate('date', today());
        }

        $data['expenses'] = $query->orderBy('id', 'desc')->paginate(20);

        $data['filter'] = !empty($filter) ? $filter : null;
        $data['type'] = !empty($type) ? $type : null;

        $data['from_date'] = !empty($request->from_date) ? date("d-m-Y", strtotime($request->from_date)) : null;
        $data['to_date'] = !empty($request->to_date) ? date("d-m-Y", strtotime($request->to_date)) : null;

        $data['expense'] = $expense;

        $data['types'] = config('constants.types');

        return view('backend.expense.edit', $data);
    }


    public function update(ExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->all());

        return redirect()->back()->with('success', 'Expense Updated Successfully!');
    }


    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect('expenses')->with('success', 'Expense Deleted Successfully!');
    }
}
