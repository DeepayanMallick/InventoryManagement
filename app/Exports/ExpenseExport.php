<?php

namespace App\Exports;

use App\Models\Expense;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExpenseExport implements FromView
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = new Expense();

        $from_date = !empty($this->request->from_date) ? date("Y-m-d", strtotime($this->request->from_date)) : null;
        $to_date = !empty($this->request->to_date) ? date("Y-m-d", strtotime($this->request->to_date)) : null;

        if (!empty($to_date) && !empty($from_date)) {
            $query = $query->whereDate("created_at", '>=', $from_date)
                ->whereDate("created_at", '<=', $to_date);
        } else {
            $query = $query->whereDate('created_at', today());
        }

        $expenses = $query->orderBy('id', 'desc')->paginate(20);

        $data['expenses'] = $expenses;

        return view('backend.report.expense-report-table', $data);
    }
}
