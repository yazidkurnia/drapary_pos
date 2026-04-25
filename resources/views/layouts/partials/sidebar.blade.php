<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main Menu</li>
            <li>
                <a class="nav-link" href="{{ url('dashboard') }}"><i class="fas fa-fire"></i> <span>Overview</span></a>
            </li>
            <li class="dropdown {{ request()->is('pos*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-clipboard-list"></i> <span>Order</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ url('pos') }}"><i class="fas fa-plus-circle"></i> New Order</a></li>
                    <li><a class="nav-link" href="#"><i class="fas fa-clipboard-list"></i> Order List</a></li>
                    <li><a class="nav-link" href="#"><i class="fas fa-history"></i> Transaction</a></li>
                </ul>
            </li>

            <li class="menu-header">Master Data</li>
            <li class="dropdown {{ request()->is('colors*', 'units*', 'sizes*', 'brands*', 'materials*', 'fits*', 'sleeves*', 'collars*', 'patterns*', 'genders*', 'products*', 'product-variants*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-box-open"></i><span>Products</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('products.index') }}"><i class="fas fa-list"></i> Product List</a></li>
                    <li><a class="nav-link" href="{{ route('colors.index') }}"><i class="fas fa-palette"></i> Color</a></li>
                    <li><a class="nav-link" href="{{ route('units.index') }}"><i class="fas fa-ruler"></i> Unit</a></li>
                    <li><a class="nav-link" href="{{ route('sizes.index') }}"><i class="fas fa-expand-alt"></i> Size</a></li>
                    <li><a class="nav-link" href="{{ route('brands.index') }}"><i class="fas fa-tag"></i> Brand</a></li>
                    <li><a class="nav-link" href="{{ route('materials.index') }}"><i class="fas fa-scroll"></i> Material</a></li>
                    <li><a class="nav-link" href="{{ route('fits.index') }}"><i class="fas fa-tshirt"></i> Tipe Potongan</a></li>
                    <li><a class="nav-link" href="{{ route('sleeves.index') }}"><i class="fas fa-tshirt"></i> Tipe Lengan</a></li>
                    <li><a class="nav-link" href="{{ route('collars.index') }}"><i class="fas fa-tshirt"></i> Tipe Leher</a></li>
                    <li><a class="nav-link" href="{{ route('patterns.index') }}"><i class="fas fa-border-all"></i> Motif/Pola</a></li>
                    <li><a class="nav-link" href="{{ route('genders.index') }}"><i class="fas fa-venus-mars"></i> Jenis Kelamin</a></li>
                    <li><a class="nav-link" href="{{ route('product-variants.index') }}"><i class="fas fa-tags"></i> Product Varian</a></li>
                </ul>
            </li>

            @auth
                @if(auth()->user()->hasAnyRole(['Owner', 'Admin Ecommerce']))
                    <li class="menu-header">Administrasi</li>
                    <li class="{{ request()->is('users*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="fas fa-users"></i> <span>Manajemen User</span>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasRole('Owner'))
                    <li class="{{ request()->is('roles*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('roles.index') }}">
                            <i class="fas fa-shield-alt"></i> <span>Manajemen Role</span>
                        </a>
                    </li>
                @endif
            @endauth
        </ul>

          <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
              <i class="fas fa-rocket"></i> Documentation
            </a>
          </div>        
        </aside>
      </div>