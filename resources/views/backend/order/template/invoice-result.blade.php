@if(count($orders))
<ul id="order-list">
    @foreach ($orders as $order)
    <li onclick="selectOrder( {{$order->order_id}} )"><span><strong>Order ID: </strong>{{ $order->order_id }}</span> <span><strong>Customer Name: </strong>{{$order->customer_name}}</span> <span><strong>Customer Phone: </strong>{{$order->customer_phone}}</span></li>
    @endforeach
</ul>
@endif
