<?php

namespace App\Http\Controllers;

use App\Exports\ExpenseExport;
use App\Exports\SalesExport;
use App\Models\Expense;
use App\Models\Order;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $query = new Order();

        $from_date = !empty($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date = !empty($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : null;

        if (!empty($to_date) && !empty($from_date)) {
            $query =  $query->whereDate("created_at", '>=', $from_date)
                ->whereDate("created_at", '<=', $to_date);
        } else {
            $query = $query->whereDate('created_at', today());
        }

        $orders = $query->orderBy('id', 'desc')->paginate(20);

        $data['orders'] = $orders;

        $data['from_date'] = !empty($request->from_date) ? date("d-m-Y", strtotime($request->from_date)) : null;
        $data['to_date'] = !empty($request->to_date) ? date("d-m-Y", strtotime($request->to_date)) : null;

        $data['totalSales'] = number_format($orders->sum('total'));

        return view('backend.report.sales', $data);
    }

    public function salesPdf(Request $request)
    {
        $query = new Order();

        $from_date = !empty($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date = !empty($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : null;

        if (!empty($to_date) && !empty($from_date)) {
            $query = $query->whereDate("created_at", '>=', $from_date)
                ->whereDate("created_at", '<=', $to_date);
        } else {
            $query = $query->whereDate('created_at', today());
        }

        $orders = $query->orderBy('id', 'desc')->paginate(20);

        $data['orders'] = $orders;

        $data['from_date'] = !empty($request->from_date) ? date("d-m-Y", strtotime($request->from_date)) : null;
        $data['to_date'] = !empty($request->to_date) ? date("d-m-Y", strtotime($request->to_date)) : null;

        $pdf = PDF::loadView('backend.report.sales-report-table', $data)->setPaper('Legal', 'landscape')->setWarnings(false);

        return $pdf->stream('Sales-Report.pdf');
    }

    public function salesCsv(Request $request)
    {
        return Excel::download(new SalesExport($request), 'Sales-Report.csv');
    }

    public function cash(Request $request)
    {

        $from_date = !empty($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date = !empty($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : null;

        $data['from_date'] = !empty($request->from_date) ? date("d-m-Y", strtotime($request->from_date)) : null;
        $data['to_date'] = !empty($request->to_date) ? date("d-m-Y", strtotime($request->to_date)) : null;

        $order = new Order();

        if (!empty($to_date) && !empty($from_date)) {
            $order = $order->whereDate("created_at", '>=', $from_date)
                ->whereDate("created_at", '<=', $to_date);
        } else {
            $order = $order->whereDate('created_at', today());
        }

        $orders = $order->orderBy('id', 'desc')->get();

        $data['orders'] = $orders;

        $data['totalSales'] = number_format($orders->sum('total'));

        $expense = new Expense();

        if (!empty($to_date) && !empty($from_date)) {
            $expense = $expense->whereDate("created_at", '>=', $from_date)
                ->whereDate("created_at", '<=', $to_date);
        } else {
            $expense = $expense->whereDate('created_at', today());
        }

        $expenses = $expense->orderBy('id', 'desc')->get();;

        $data['expenses'] = $expenses;

        $data['totalExpenses'] = number_format($expenses->sum('amount'));       

        return view('backend.report.cash', $data);
    }

    public function expensesPdf(Request $request)
    {
        $query = new Expense();

        $from_date = !empty($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date = !empty($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : null;

        if (!empty($to_date) && !empty($from_date)) {
            $query = $query->whereDate("created_at", '>=', $from_date)
                ->whereDate("created_at", '<=', $to_date);
        } else {
            $query = $query->whereDate('created_at', today());
        }

        $expenses = $query->orderBy('id', 'desc')->paginate(20);

        $data['expenses'] = $expenses;

        $data['from_date'] = !empty($request->from_date) ? date("d-m-Y", strtotime($request->from_date)) : null;
        $data['to_date'] = !empty($request->to_date) ? date("d-m-Y", strtotime($request->to_date)) : null;

        $pdf = PDF::loadView('backend.report.expense-report-table', $data)->setPaper('Legal', 'landscape')->setWarnings(false);

        return $pdf->stream('Expenses-Report.pdf');
    }

    public function expensesCsv(Request $request)
    {
        return Excel::download(new ExpenseExport($request), 'Expenses-Report.csv');
    }
}
