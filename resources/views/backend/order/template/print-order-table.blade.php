<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Decor House | Order Print</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

</head>

<body class="white-bg">
    <div class="wrapper wrapper-content p-xl">
        <div class="ibox-content p-xl">
            <div class="row">
                <div class="col-sm-6">
                    <h4>From:</h4>
                    <address>
                        <strong>Decor House</strong><br>
                        152/1 Rustom Tower<br>
                        Songita Hall More<br>
                        Khulna-9100<br>
                        <span><strong>Phone:</strong> 01634 050506
                    </address>
                </div>

                <div class="col-sm-6 text-right">
                    <h4>Order ID: <span>{{ $order->order_id }}</span></h4>
                    <h4>To:</h4>
                    <address>
                        <strong>{{ $order->customer->name ?? '' }}</strong><br>
                        {{ $order->customer->address ?? '' }}<br>
                        <span><strong>Phone:</strong> {{ $order->customer->phone ?? '' }}
                    </address>
                    <p>
                        <span><strong>Date:</strong> {{ $order->created_at }}</span>
                    </p>
                </div>
            </div>

            <div class="table-responsive m-t">
                <table class="table invoice-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Unit</th>
                            <th>Unit Price (tk)</th>
                            <th>Amount (tk)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($order->order_products))
                        @foreach ($order->order_products as $order_product)
                        <tr>
                            <td>
                                <div>{{ $order_product->product->title  }}</div>
                            </td>
                            <td>{{ $order_product->unit }}</td>
                            <td>{{ number_format($order_product->unit_price) }}</td>
                            <td>{{ number_format($order_product->amount) }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div><!-- /table-responsive -->

            <table class="table invoice-total">
                <tbody>
                    <tr>
                        <td><strong>Sub Total (tk):</strong></td>
                        <td>{{ number_format($order->sub_total) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tax ({{$tax}}%):</strong></td>
                        <td>{{ number_format($order->tax) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Discount (tk):</strong></td>
                        <td>{{ $order->discount }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total (tk):</strong></td>
                        <td>{{ number_format($order->total) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Mainly scripts -->
    <script src="{{asset('js/app.js')}}"></script>

    <script type="text/javascript">
        window.print();

    </script>

</body>

</html>
