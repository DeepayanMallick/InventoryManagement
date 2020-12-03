<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Cash;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Pay;
use App\Models\Product;
use App\Models\Setting;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $customer = null;
        if (!empty($request->cid)) {
            $customer = Customer::findOrFail($request->cid);
        }

        $data['customer'] = $customer;

        $query = new Order();

        $searchFields = ['order_id', 'customer_name', 'customer_phone'];
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


        $orders = $query->orderBy('id', 'desc')->paginate(20);

        $data['orders'] = $orders;

        $data['from_date'] = !empty($request->from_date) ? date("d-m-Y", strtotime($request->from_date)) : null;
        $data['to_date'] = !empty($request->to_date) ? date("d-m-Y", strtotime($request->to_date)) : null;

        $setting = new Setting();
        $tax = $setting->getSetting('tax');
        $data['tax'] = !empty($tax) ? $tax : 0;

        return view('backend.order.index', $data);
    }


    public function create()
    {
        //
    }


    public function store(OrderRequest $request)
    {
        $order = Order::create([
            'customer_id'    => $request->customer_id,
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'order_id'       => $this->orderService->generateOrderId(),
            'sub_total'      => $request->subTotal,
            'tax'            => $request->tax,
            'discount'       => $request->discount,
            'total'          => $request->total,
            'partial_amount' => floatval($request->partial_amount),
            'due'            => floatval($request->total) - floatval($request->partial_amount),
        ]);

        Pay::create([
            'order_id'       => $order->id,
            'date'           => now(),
            'customer_id'    => $request->customer_id,
            'total'          => $request->total,
            'partial_amount' => $request->partial_amount,
            'due' => floatval($request->total) - floatval($request->partial_amount),
        ]);


        foreach ($request->product_id as $key => $product_id) {
            if (!empty($product_id)) {
                $item['product_id']   = $product_id;
                $item['order_id']     = $order->id;

                $item['unit']         = $request->unit[$key];
                $item['unit_price']   = $request->unit_price[$key];
                $item['amount']       = $request->amount[$key];

                OrderProduct::create($item);

                $product = Product::find($product_id);

                $available_stock = $product->available_stock - $request->unit[$key];

                $total_price = $product->retail_price * $available_stock;

                $product->update([
                    'available_stock' => $available_stock,
                    'total_price' => $total_price
                ]);
            }
        }

        return redirect()->route('orders.show', $order->id);
    }


    public function show(Order $order, Request $request)
    {
        $payments = Pay::where('order_id', $order->id)->orderBy('date', 'desc')->paginate(20);

        $data['totalPaid'] = $payments->sum('partial_amount');

        $data['totalReturned'] = $payments->sum('refund_amount');

        $data['payments'] = $payments;

        $data['order'] = $order;

        $setting = new Setting();
        $tax = $setting->getSetting('tax');
        $data['tax'] = !empty($tax) ? $tax : 0;

        return view('backend.order.template.order-table', $data);
    }


    public function pay(Request $request, Order $order)
    {
        $request->validate(
            [
                'partial_amount' => 'required'
            ],
            [
                'partial_amount.required' => 'Amount must not be empty'
            ]
        );

        $order->update([
            'due'            => floatval($order->due) - floatval($request->partial_amount),
        ]);

        $customer = Customer::find($order->customer_id);

        $customer_due = floatval($customer->due) - floatval($request->partial_amount);

        $customer->update(['due' => $customer_due]);

        Pay::create([
            'order_id'        => $order->id,
            'customer_id'     => $order->customer_id,
            'date'            => $request->date,
            'total'           => $order->total,
            'partial_amount'  => $request->partial_amount,
            'due'             => floatval($order->due),
        ]);

        $cash = Cash::get()->first();

        if (!empty($cash)) {
            $cash->update([
                'income' => $cash->income + $request->partial_amount
            ]);
        } else {
            Cash::create([
                'income' => $request->partial_amount
            ]);
        }

        return redirect()->back()->with('success', 'Payment Accepted Successfully!');
    }

    public function payToCustomer(Request $request, Order $order)
    {
        $request->validate(
            [
                'refund_amount' => 'required'
            ],
            [
                'refund_amount.required' => 'Refund Amount must not be empty'
            ]
        );

        $order->update([
            'due'            => floatval($order->due) + floatval($request->refund_amount),
        ]);

        $customer = Customer::find($order->customer_id);

        $customer_due = floatval($customer->due) + floatval($request->refund_amount);

        $customer->update(['due' => $customer_due]);

        Pay::create([
            'order_id'        => $order->id,
            'customer_id'     => $order->customer_id,
            'date'            => $request->pay_date,
            'total'           => $order->total,
            'partial_amount'  => null,
            'refund_amount'   => $request->refund_amount,
            'due'             => floatval($order->due),
        ]);

        $cash = Cash::get()->first();

        if (!empty($cash)) {
            $cash->update([
                'income' => $cash->income - $request->refund_amount
            ]);
        } 

        if ($order->total == 0 && $order->due == 0) {
            $order->delete();
            return redirect()->route('orders.index');
        }

        return redirect()->back()->with('success', 'Amount Refunded To Customer Successfully!');
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy(Order $order)
    {
        foreach ($order->order_products as $order_product) {
            $product = Product::find($order_product->product_id);
            if (!empty($product)) {
                $available_stock = $product->available_stock + $order_product->unit;

                $total_price = $product->retail_price * $available_stock;

                $product->update([
                    'available_stock' => $available_stock,
                    'total_price' => $total_price
                ]);
            }
        }

        $customer = Customer::find($order->customer_id);

        $customer->update([
            "due"   => $customer->due - $order->due,
        ]);

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order Deleted Successfully!');
    }


    public function print(Order $order)
    {
        $data['order'] = $order;

        $setting = new Setting();
        $tax = $setting->getSetting('tax');
        $data['tax'] = !empty($tax) ? $tax : 0;

        return view('backend.order.template.print-order-table', $data);
    }

    public function addMore(Request $request)
    {
        $data['count'] = $request->count;

        $inputFieldsView = view('backend.order.template.input-fields', $data)->render();

        return response()->json($inputFieldsView);
    }

    public function calculatePrice(Request $request)
    {

        $product = Product::find($request->pid);

        $productPrice = $product->sales_price * $request->unit;

        $setting = new Setting();
        $tax = $setting->getSetting('tax');
        $data['tax'] = !empty($tax) ? $tax : 0;

        return response()->json(array(
            'productPrice' => $productPrice,
            'tax'          => $tax,
        ));
    }

    public function return(Request $request)
    {
        $order = Order::where('order_id', $request->order_id)->first();

        $data['order'] = $order;

        $setting = new Setting();
        $tax = $setting->getSetting('tax');
        $data['tax'] = !empty($tax) ? $tax : 0;

        return view('backend.order.template.return', $data);
    }


    public function returnProduct(Order $order, Request $request)
    {
        $due = $order->due - floatval($request->return_amount);

        $customer = Customer::find($order->customer_id);

        $customer->update([
            "due"   => $due,
        ]);

        $order->update([
            "sub_total" => $request->sub_total,
            "tax" => $request->tax,
            "total" => $request->total,
            "due"   => $due,
        ]);

        if (!empty($order->order_products)) {

            foreach ($order->order_products as $key => $order_product) {

                $item['product_id']   = $order_product->product_id;
                $item['order_id']     = $order->id;

                $item['unit']         = $request->unit[$key];
                $item['unit_price']   = $request->unit_price[$key];
                $item['amount']       = $request->amount[$key];

                $product = Product::find($order_product->product_id);

                if ($request->unit[$key] == "0") {
                    $available_stock = $product->available_stock + $order_product->unit;
                    $total_price = $product->retail_price * $available_stock;
                    $product->update([
                        'available_stock' => $available_stock,
                        'total_price' => $total_price
                    ]);
                    $order_product->delete();
                } else {
                    $available_stock = $product->available_stock + ($order_product->unit - $request->unit[$key]);
                    $total_price = $product->retail_price * $available_stock;
                    $product->update([
                        'available_stock' => $available_stock,
                        'total_price' => $total_price
                    ]);
                    $order_product->delete();
                    OrderProduct::create($item);
                }
            }
        }

        if ($order->total == 0 && $order->due == 0) {
            $order->delete();
        }

        return redirect()->back()->with('success', 'Product Returned Successfully!');
    }

    public function searchInvoice(Request $request)
    {
        $searchFields = ['order_id', 'customer_name', 'customer_phone'];
        $filter = $request->q;

        if (!empty($filter)) {
            $query = Order::where(function ($q) use ($filter, $searchFields) {
                $searchWildcard = '%' . $filter . '%';
                foreach ($searchFields as $field) {
                    $q->orWhere($field, 'like', $searchWildcard);
                }
            })->get();
        } else {
            $query = [];
        }

        $data['orders'] = $query;

        $searchResult = view('backend.order.template.invoice-result', $data)->render();

        return response()->json($searchResult);
    }
}
