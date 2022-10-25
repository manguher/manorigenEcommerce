<a class="nav-link" href="{{ url('cart/detail') }}">
    <i class="fas fa-dolly-flatbed me-1 text-gray"></i>Cart

    <span class="badge badge-warning-light" style="position: relative; top: -2px;" id="cart-notify">{{count(\Cart::getContent())}}</span>

</a>
