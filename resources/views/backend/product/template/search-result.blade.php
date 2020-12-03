@if(count($products))
<ul id="product-list">
    @foreach ($products as $product)
    <li onclick="selectProduct('{{$product->id}}', '{{$product->title}}', '{{$product->retail_price}}','{{$count}}' )">
        {{ $product->title }}</li>
    @endforeach
</ul>
@endif
