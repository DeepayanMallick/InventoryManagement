@php
$route_name = Route::currentRouteName();
@endphp
<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <ul class="nav CustomMenu">            
            <li class="@if($route_name=='dashboard') active @endif">
                <a href="{{ route('dashboard') }}"><i class="fa fa-th-large"></i> <span
                        class="nav-label">Dashboards</span></a>
            </li>
            <li class="@if($route_name=='stocks.index') active @endif">
                <a href="{{ route('stocks.index') }}"><i class="fa fa-houzz"></i> <span
                        class="nav-label">Stock</span></a>
            </li>          
            <li class="@if($route_name=='expenses.index') active @endif">
                <a href="{{ route('expenses.index') }}"><i class="fa fa-money"></i> <span
                        class="nav-label">Expenses</span></a>
            </li>
            <li class="dropdown @if($route_name=='customers.index' || $route_name=='suppliers.index' || $route_name=='products.index' || $route_name=='cashes.index' || $route_name=='extra-profit.index') active @endif">
                <a href="#" class="dropbtn"><i class="fa fa-plus-circle"></i>
                    <span class="nav-label">Add</span>
                    <span class="fa fa-angle-down"></span>
                </a>
                <ul class="nav nav-second-level dropdown-content">
                    <li><a href="{{ route('customers.index') }}">Customers</a></li>
                    <li><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                    <li><a href="{{ route('extra-profit.index') }}">Extra Profit</a></li>
                    @if(Auth::user()->role=='Admin')
                    <li><a href="{{ route('cashes.index') }}">Cash</a></li>
                    @endif
                </ul>
            </li>             
            <li class="dropdown @if($route_name=='orders.index' || $route_name=='products.return') active @endif">
                <a href="#" class="dropbtn"><i class="fa fa-shopping-cart"></i>
                    <span class="nav-label">Orders</span>
                    <span class="fa fa-angle-down"></span>
                </a>
                <ul class="nav nav-second-level dropdown-content">
                    <li><a href="{{ route('orders.index') }}">Orders</a></li>                   
                    <li><a href="{{ route('orders.return') }}">Return Products</a></li>                   
                </ul>
            </li>           
            <li class="dropdown @if($route_name=='reports.sales' || $route_name=='reports.cash') active @endif">
                <a href="#" class="dropbtn"><i class="fa fa-flag"></i>
                    <span class="nav-label">Reports</span>
                    <span class="fa fa-angle-down"></span>
                </a>
                <ul class="nav nav-second-level dropdown-content">
                    <li><a href="{{ route('reports.sales') }}">Sales Report</a></li>
                    <li><a href="{{ route('reports.cash') }}">Cash Report</a></li>
                </ul>
            </li>         
            
            <li class="@if($route_name=='settings.index') active @endif">
                <a href="{{ route('settings.index') }}"><i class="fa fa-cogs"></i> <span
                        class="nav-label">Settings</span></a>
            </li>        
        </ul>

        <ul class="nav navbar-top-links navbar-right pr-2">

            <li style="padding: 20px">
                <span class="m-r-sm text-muted welcome-message">Welcome to Decor House
                    {{ Auth::user()->role }}</span>
            </li>            
            <li>
                <div class="dropdown profile-element text-center">

                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img alt="image" class="rounded-circle" src="{{ asset('img/profile_small.jpg') }}" />
                    </a>

                    <div class="dropdown-menu animated fadeInRight dropdownBoxCustom">
                        <div class="d-flex justify-content-center align-items-center flex-column card-body">
                            <img src="{{ asset('img/profile_small.jpg') }}" style="width: 80px; height: 80px;"
                                class="rounded-circle mb-2">
                            <div class="card-title block m-t-xs font-bold">{{ Auth::user()->name }}</div>
                            <div class="card-subtitle">{{ Auth::user()->role }}</div>
                        </div>
                        <ul class="m-t-xs pl-0">
                            <li><a class="dropdown-item" href="{{ route('profile.index', Auth::user()->id) }}">Change Password</a></li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Log out
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>

    </nav>
</div>
