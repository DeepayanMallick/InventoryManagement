@if(!empty($customer))
<p><strong>Name:&nbsp;&nbsp;</strong>{{ $customer->name }}</p>
<p><strong>Phone:&nbsp;&nbsp;</strong>{{ $customer->phone }}</p>
<p><strong>Address:&nbsp;&nbsp;</strong>{{ $customer->address }}</p>
@endif
