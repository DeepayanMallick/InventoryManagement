<div class="row">
    <div class="col-md-4">
        <div class="ibox-title">
            <h3>Add New Supplier</h3>
        </div>
        <div class="ibox-content">
            @if(\Session::has('success'))
            <div class="alert alert-success">
                <ul class="list-style-none">
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
            @endif
            <form action="{{ route('suppliers.store') }}" method="POST">
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
                        <div class="form-group @error('company') has-error @enderror">
                            <label for="company">Company</label>
                            <input type="text" name="company" value="{{old('company')}}" class="form-control">
                            @error('company')
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
                        <div class="form-group @error('email') has-error @enderror">
                            <label for="code">Email *</label>
                            <input type="email" name="email" value="{{old('email')}}" class="form-control">
                            @error('email')
                            <div class="inline-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group mt-4">
                            <input type="submit" class="btn btn-primary" onclick="formSubmit(this)" value="Add Supplier">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="ibox-title">
            <h3>Manage Suppliers</h3>
        </div>
        <div class="ibox-content">
            <form action="{{ route('suppliers.index') }}" method="GET">
                <div class="row Filter">
                    <div class="col-md-8">
                        <div class="form-group Product">
                        <input type="text" class="form-control" name="q" value="{{ $filter}}" placeholder="Search by Supplier Name, Company, Address, Phone Or Email ....">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('suppliers.index') }}" class="btn btn-danger ml-4">Reset</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="ibox-content">
            @if(count($suppliers))
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Company</th>                       
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        @if(Auth::user()->role=='Admin')
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @foreach ($suppliers as $key => $supplier)
                    <tr class="gradeX">
                        <td class="text-center">{!! ($key+1)+(20*($suppliers->currentPage()-1)) !!}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->company }}</td>
                        <td>{{ $supplier->address }}</td>
                        <td>{{ $supplier->phone }}</td>
                        <td>{{ $supplier->email }}</td>
                        @if(Auth::user()->role=='Admin')
                        <td class="action-column tooltip-suggestion">                  
                            <a class="btn btn-success btn-circle" href="{{ route('suppliers.edit', $supplier->id) }}"
                                data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>

                            <form id="DeleteSupplierForm-{{$supplier->id}}" method="POST"
                                action="{{ route('suppliers.destroy', $supplier->id) }}" class="action-form">
                                @csrf
                                {{ method_field('DELETE') }}
                                <a href="javascript:void(0)" onclick="deleteSupplier({{$supplier->id}})"
                                    class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="top"
                                    title="Delete"><i class="fa fa-trash"></i></a>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="dataTables_paginate paging_simple_numbers">
                {{$suppliers->links()}}
            </div>
            @else
            <div class="text-center">
                <h4>No supplier available</h4>
            </div>
            @endif
        </div>
    </div>
</div>
