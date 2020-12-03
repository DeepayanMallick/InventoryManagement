<div class="row">
    <div class="col-md-12">
        <div class="ibox-title">
            <h3>Stocks</h3>
        </div>
        <div class="ibox-content">
            <form action="{{ route('stocks.index') }}" method="GET">
                <div class="row Filter">
                    <div class="col-md-3">
                        <div class="input-group form-inline mt-1">
                            <label for="name" class="mr-4">Date From</label>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control datepicker" name="from_date"
                                value="{{ !empty($from_date) ? $from_date : date('d-m-Y')}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group form-inline mt-1">
                            <label for="name" class="mr-4">Date To</label>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control datepicker" name="to_date"
                                value="{{ !empty($to_date) ? $to_date : date('d-m-Y')}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group Product">
                        <input type="text" class="form-control" name="q" value="{{ $filter}}" placeholder="Search by Product Title Or Code....">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('stocks.index') }}" class="btn btn-danger ml-4">Reset</a>
                    </div>
                </div>
            </form>            
        </div>
        <div class="ibox-content">
            @if(count($products))
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Product</th>
                        <th>Code</th>
                        <th>Retail Price (tk)</th>
                        <th>Sales Price (tk)</th>
                        <th>Initial Stock</th>
                        <th>Available Stock</th>
                        <th>Entry Date</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $key => $product)
                    <tr class="gradeX">
                        <td class="text-center">{!! ($key+1)+(20*($products->currentPage()-1)) !!}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->retail_price }}</td>
                        <td>{{ $product->sales_price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->available_stock }}</td>
                        <td>{{ $product->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="dataTables_paginate paging_simple_numbers">
                {{$products->links()}}
            </div>
            @else
            <div class="text-center">
                <h4>No product available</h4>
            </div>
            @endif
        </div>
    </div>
</div>
