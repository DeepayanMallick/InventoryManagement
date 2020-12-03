<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExport implements FromView
{

    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = new Order();

        $from_date = !empty($this->request->from_date) ? date("Y-m-d", strtotime($this->request->from_date)) : null;
        $to_date = !empty($this->request->to_date) ? date("Y-m-d", strtotime($this->request->to_date)) : null;

        if (!empty($to_date) && !empty($from_date)) {
            $query = $query->whereDate("created_at", '>=', $from_date)
                ->whereDate("created_at", '<=', $to_date);
        } else {
            $query = $query->whereDate('created_at', today());
        }

        $orders = $query->orderBy('id', 'desc')->get();

        $data['orders'] = $orders;

        return view('backend.report.sales-report-table', $data);
    }
}
