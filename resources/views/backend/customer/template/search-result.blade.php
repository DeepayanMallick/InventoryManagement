@if(count($customers))
<ul id="customer-list">
    @foreach ($customers as $customer)
    <li onclick="selectCustomer('{{$customer->id}}', '{{$customer->name}}', '{{$customer->phone}}' )">{{ $customer->name }}</li>
    @endforeach
</ul>
@endif
