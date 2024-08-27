<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        {{-- <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">Ecommerce Konco</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @role('admin')
                
                    <li class="nav-header">MASTER</li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('product.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>
                                Product
                            </p>
                        </a>
                    </li>
                @endrole
                @role('customer')
                <li class="nav-header">Transaction</li>
                <li class="nav-item">
                    <a href="{{ route('product-customer.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            Product
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cart.index') }}" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        <p>
                            Cart
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transaction.index') }}" class="nav-link">
                        <i class="fas fa-receipt"></i>
                        <p>
                            Transaction
                        </p>
                    </a>
                </li>
            @endrole

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
