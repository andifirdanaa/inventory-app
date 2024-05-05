<div class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('image/Handbag.png')}}" alt="" >
        <h1>SIMS Web App</h1>
        <label for="nav-toggle">
            <span class="fa fa-bars"></span>
        </label>
    </div>

    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="{{route('list.produk') }}" class="@if(Route::currentRouteName() == 'list.produk') active @endif">
                    <img src="{{ asset('image/Package.png')}}" alt="">
                    <span>Produk</span>
                </a>
            </li>
            <li>
                <a href="{{route('profil') }}" class="@if(Route::currentRouteName() == 'profil') active @endif">
                    <img src="{{ asset('image/User.png')}}" alt="">
                    <span>Profil</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <img src="{{ asset('image/SignOut.png')}}" alt="">
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>