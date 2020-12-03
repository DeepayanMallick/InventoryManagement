<div id="product-input-wrap-{{$count}}">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group position-relative @error('product_id.*') has-error @enderror">
                <label for="supplier">Select Product</label>
                <input type="text" count={{$count}} id="Product{{$count}}" onkeyup="searchProduct(this)" value=""
                    placeholder="Search by Title, Code, Or Description" class="form-control">
                <input type="hidden" id="ProductId{{$count}}" name="product_id[]" value="">
                <div class="ajax_loading ProductSearch" id="ProductSearch{{$count}}">
                    <img src="{{asset('img/ajax-loader.svg')}}" alt="">
                </div>
                <div id="product-suggestion-box-{{$count}}"></div>
                @error('product_id.*')
                <div class="inline-errors">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group position-relative @error('unit.*') has-error @enderror">
                <label for="stock">Unit</label>
                <input type="text" count={{$count}} id="unit{{$count}}" name="unit[]" value=""
                    onkeyup="calculatePrice(this)" class="form-control" readonly>
                <div class="ajax_loading CalculatePrice" id="CalculatePrice{{$count}}">
                    <img src="{{asset('img/ajax-loader.svg')}}" alt="">
                </div>
                @error('unit.*')
                <div class="inline-errors">{{ $message }}</div>
                @enderror
                <div id="OutOfStockError{{$count}}" class="inline-errors d-none"></div>
                <input type="hidden" id="AvailableStock{{$count}}" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="name">Unit Price (tk)</label>
                <input type="text" count={{$count}} name="unit_price[]" id="unitPrice{{$count}}" value="" onkeyup="resetUnit(this)" class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group @error('amount.*') has-error @enderror">
                <label for="name">Amount (tk)</label>
                <input type="text" name="amount[]" id="amount{{$count}}" value="" class="form-control" readonly>
                @error('amount.*')
                <div class="inline-errors">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-1">
            <div class="RemoveButton">
                <a href="javascript:void(0)" onclick="removeProduct({{$count}})" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i></a>
            </div>
        </div>
    </div>
</div>
