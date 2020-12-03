<div class="row">
    <div class="col-md-4">
        <div class="ibox-title">
            <h3>Add New Customer</h3>
        </div>
        <div class="ibox-content">
            @if(\Session::has('success'))
            <div class="alert alert-success">
                <ul class="list-style-none">
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
            @endif
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @error('name') has-error @enderror">
                            <label for="name">Name *</label>
                            <input type="text" name="name" value="{{old('name')}}" class="form-control">
                            @error('name')
                            <div class="inline-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @error('phone') has-error @enderror">
                            <label for="code">Phone *</label>
                            <input type="text" name="phone" value="{{old('phone')}}" class="form-control">
                            @error('phone')
                            <div class="inline-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @error('address') has-error @enderror">
                            <label for="description">Address</label>
                            <input type="text" name="address" value="{{old('address')}}" class="form-control">
                            @error('address')
                            <div class="inline-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group mt-4">
                            <input type="submit" class="btn btn-primary" onclick="formSubmit(this)" value="Add Customer">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="ibox-title">
            <h3>Manage Customers</h3>
        </div>
        <div class="ibox-content">
            <form action="{{ route('customers.index') }}" method="GET">
                <div class="row Filter">
                    <div class="col-md-8">
                        <div class="form-group Product">
                            <input type="text" class="form-control" name="q" value="{{ $filter}}"
                                placeholder="Search by Customer Name, Phone Or Address ....">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('customers.index') }}" class="btn btn-danger ml-4">Reset</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="ibox-content">
            @if(count($customers))
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($customers as $key => $customer)                   
                    <tr class="gradeX">
                        <td class="text-center">{!! ($key+1)+(20*($customers->currentPage()-1)) !!}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->address }}</td>
                        
                        <td class="action-column tooltip-suggestion">
                            <a class="btn btn-success btn-circle"
                                href="{{ route('orders.index', 'cid=' . $customer->id) }}" data-toggle="tooltip"
                                data-placement="top" title="New Order"><i class="fa fa-plus"></i></a>
                            @if(Auth::user()->role=='Admin')
                            <a class="btn btn-success btn-circle" href="{{ route('customers.edit', $customer->id) }}"
                                data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            @if(!count($customer->orders))                           
                            <form id="DeleteCustomerForm-{{$customer->id}}" method="POST"
                                action="{{ route('customers.destroy', $customer->id) }}" class="action-form">
                                @csrf
                                {{ method_field('DELETE') }}
                                <a href="javascript:void(0)" onclick="deleteCustomer({{$customer->id}})"
                                    class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="top"
                                    title="Delete"><i class="fa fa-trash"></i></a>
                            </form>
                            @endif
                            @endif
                        </td>                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="dataTables_paginate paging_simple_numbers">
                {{$customers->appends(request()->query())->links()}}
            </div>
            @else
            <div class="text-center">
                <h4>No customer available</h4>
            </div>
            @endif
        </div>
    </div>
</div>
