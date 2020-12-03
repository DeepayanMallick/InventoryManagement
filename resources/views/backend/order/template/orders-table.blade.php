<div class="row">
    <div class="col-md-7">
        <form action="{{ route('orders.store') }}" method="POST" autocomplete="off">
            @csrf
            <div class="ibox-title">
                <h3>Customer</h3>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-6">
                        @if(\Session::has('success'))
                        <div class="alert alert-success">
                            <ul class="list-style-none">
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group position-relative @error('customer_id') has-error @enderror">
                            <label for="name">Customer</label>
                            <input type="text" id="Customer" onkeyup="searchCustomer()" @if(!empty($customer))
                                value="{{ $customer->name }}" @endif
                                placeholder="Search by Name, Address Or Phone number" class="form-control">
                            <input type="hidden" id="CustomerId" name="customer_id" @if(!empty($customer))
                                value="{{ $customer->id }}" @endif>
                            <input type="hidden" id="CustomerName" name="customer_name" @if(!empty($customer))
                                value="{{ $customer->name }}" @endif>
                            <input type="hidden" id="CustomerPhone" name="customer_phone" @if(!empty($customer))
                                value="{{ $customer->phone }}" @endif>
                            <div class="ajax_loading CustomerSearch">
                                <img src="{{asset('img/ajax-loader.svg')}}" alt="">
                            </div>
                            <div id="suggestion-box"></div>

                            @error('customer_id')
                            <div class="inline-errors">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <a href="{{ route('customers.index') }}" target="_blank"><strong>Add New
                                    Customer</strong></a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="customer-info">
                            @if(!empty($customer))
                            <p><strong>Name:&nbsp;&nbsp;</strong>{{ $customer->name }}</p>
                            <p><strong>Phone:&nbsp;&nbsp;</strong>{{ $customer->phone }}</p>
                            <p><strong>Address:&nbsp;&nbsp;</strong>{{ $customer->address }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-title">
                <h3>Product</h3>
            </div>
            <div class="ibox-content order">
                <div id="input_fields_wrap">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group position-relative @error('product_id.*') has-error @enderror">
                                <label for="supplier">Select Product</label>
                                <input type="text" count=1 id="Product1" onkeyup="searchProduct(this)" value=""
                                    placeholder="Search by Title, Code, Or Description" class="form-control">
                                <input type="hidden" id="ProductId1" name="product_id[]" value="">
                                <div class="ajax_loading ProductSearch" id="ProductSearch1">
                                    <img src="{{asset('img/ajax-loader.svg')}}" alt="">
                                </div>
                                <div id="product-suggestion-box-1"></div>
                                @error('product_id.*')
                                <div class="inline-errors">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group position-relative @error('unit.*') has-error @enderror">
                                <label for="stock">Unit</label>
                                <input type="text" count=1 id="unit1" id="unit" name="unit[]" value=""
                                    onkeyup="calculatePrice(this)" class="form-control" readonly>
                                <div class="ajax_loading CalculatePrice" id="CalculatePrice1">
                                    <img src="{{asset('img/ajax-loader.svg')}}" alt="">
                                </div>
                                @error('unit.*')
                                <div class="inline-errors">{{ $message }}</div>
                                @enderror
                                <div id="OutOfStockError1" class="inline-errors d-none"></div>
                                <input type="hidden" id="AvailableStock1" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Unit Price (tk)</label>
                                <input type="text" count=1 name="unit_price[]" id="unitPrice1" value="" onkeyup="resetUnit(this)" class="form-control"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group @error('amount.*') has-error @enderror">
                                <label for="name">Amount (tk)</label>
                                <input type="text" name="amount[]" id="amount1" value="" class="form-control" readonly>
                                @error('amount.*')
                                <div class="inline-errors">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <a href="javascript:void(0)" onclick="addMoreProduct()"
                                class="add_field_button btn btn-primary btn-sm">Add More</a>
                            <div class="ajax_loading AddMoreProduct" id="AddMoreProduct">
                                <img src="{{asset('img/ajax-loader.svg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="TotalRowCount" value="1">
                <input type="hidden" id="TaxAmount" value="{{$tax}}">
                <hr>

                <div class="form-group row">
                    <div class="col-md-7">
                    </div>
                    <label class="col-sm-2 col-form-label text-right">Sub Total (tk)</label>
                    <div class="col-sm-3">
                        <input type="text" name="subTotal" id="subTotal" value="0" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-7">
                    </div>
                    <label class="col-sm-2 col-form-label text-right">Tax ({{$tax}}%)</label>
                    <div class="col-sm-3">
                        <input type="text" name="tax" id="tax" value="0" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-7">
                    </div>
                    <label class="col-sm-2 col-form-label text-right">Discount (tk)</label>
                    <div class="col-sm-3">
                        <input type="text" onkeyup="calculateDiscount(this)" name="discount" id="discount" value="0"
                            class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-7">
                    </div>
                    <label class="col-sm-2 col-form-label text-right">Total (tk)</label>
                    <div class="col-sm-3">
                        <input type="text" name="total" id="total" value="0" class="form-control" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="mt-2 text-right">
                            <input type="checkbox" id="IsFullPay" onclick="isFullPay()" name="is_full_pay" value="0">
                            <label for="vehicle1">Full Pay</label><br>
                        </div>
                    </div>
                    <div class="col-md-5">

                        <div class="input-group form-inline @error('partial_amount') has-error @enderror">
                            <label for="name" class="mr-2">Pay Amount (tk):</label>
                            <input type="text" name="partial_amount" onkeyup="makePayment(this)" id="payment" value=""
                                class="form-control">
                            @error('partial_amount')
                            <div class="inline-errors">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="DueAmount" class="input-group mt-3 form-inline d-none">
                            <label for="name" class="mr-2">Due (tk):</label>
                            <input type="text" name="due" id="due" value="0" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary SaveOrder" onclick="formSubmit(this)">Add Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <div class="col-md-5">
        <div class="ibox-title">
            <h3>Manage Orders</h3>
        </div>
        <div class="ibox-content">
            <form action="{{ route('orders.index') }}" method="GET">
                <div class="row Filter">
                    <div class="col-md-12">
                        <div class="form-group Product">
                        <input type="text" class="form-control" name="q" value="{{ $filter}}" placeholder="Search by Order ID, Customer Name Or Customer Phone....">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group form-inline mt-1">
                            <label for="name" class="mr-4">From</label>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control datepicker" name="from_date"
                                value="{{ !empty($from_date) ? $from_date : date('d-m-Y')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group form-inline mt-1">
                            <label for="name" class="mr-4">To</label>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control datepicker" name="to_date"
                                value="{{ !empty($to_date) ? $to_date : date('d-m-Y')}}">
                        </div>
                    </div>                    
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('orders.index') }}" class="btn btn-danger ml-4">Reset</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="ibox-content">
            @if(count($orders))
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total (tk)</th>
                        <th>Due (tk)</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($orders as $key=>$order)
                    <tr class="gradeX">
                        <td class="text-center">{!! ($key+1)+(20*($orders->currentPage()-1)) !!}</td>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ number_format($order->total) }}</td>
                        <td>{{ number_format($order->due) }}</td>

                        <td class="action-column tooltip-suggestion">
                            <a class="btn btn-success btn-circle" href="{{ route('orders.show', $order->id) }}"
                                data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-link"></i></a>
                            @if(Auth::user()->role=='Admin')
                            <form id="DeleteOrderForm-{{$order->id}}" method="POST"
                                action="{{ route('orders.destroy', $order->id) }}" class="action-form">
                                @csrf
                                {{ method_field('DELETE') }}
                                <a href="javascript:void(0)" onclick="deleteOrder({{$order->id}})"
                                    class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="top"
                                    title="Delete"><i class="fa fa-trash"></i></a>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="dataTables_paginate paging_simple_numbers">
                {{$orders->appends(request()->query())->links()}}
            </div>
            @else
            <div class="text-center">
                <h4>No order available</h4>
            </div>
            @endif
        </div>
    </div>
</div>
