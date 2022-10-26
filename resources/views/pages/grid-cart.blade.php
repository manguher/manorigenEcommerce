<div class="col-lg-8 mb-4 mb-lg-0">
    <!-- CART TABLE-->
    <div class="table-responsive mb-4">
        <table class="table text-nowrap">
            <thead class="bg-light">
                <tr>
                    <th class="border-0 p-3" scope="col"> <strong class="text-sm text-uppercase">Producto</strong></th>
                    <th class="border-0 p-3" scope="col"> <strong class="text-sm text-uppercase">Precio</strong></th>
                    <th class="border-0 p-3" scope="col"> <strong class="text-sm text-uppercase">Cantidad</strong>
                    </th>
                    <th class="border-0 p-3" scope="col"> <strong class="text-sm text-uppercase">Total</strong></th>
                    <th class="border-0 p-3" scope="col"> <strong class="text-sm text-uppercase"></strong>
                    </th>
                </tr>
            </thead>
            <tbody class="border-0">
                @foreach ($cart as $item)
                    <tr>
                        <th class="ps-0 py-3 border-light" scope="row">
                            <div class="d-flex align-items-center"><a class="reset-anchor d-block animsition-link"
                                    href="detail.html"><img src="img/product-detail-3.jpg" alt="..."
                                        width="70" /></a>
                                <div class="ms-3"><strong class="h6"><a class="reset-anchor animsition-link"
                                            href="detail.html">{{ $item['name'] }}</a></strong></div>
                            </div>
                        </th>
                        <td class="p-3 align-middle border-light">
                            <p class="mb-0 small">{{ $item['price'] }}</p>
                        </td>
                        <td class="p-3 align-middle border-light">
                            <div class="border d-flex align-items-center justify-content-between px-3">
                                <span class="small text-uppercase text-gray headings-font-family">Cantidad</span>
                                <div class="quantity">
                                    <span class="spinner-border spinner-border-sm spinner-quantity-cart" role="status"
                                        aria-hidden="true" style="margin-right: 5px; display: none;"></span>
                                    <button class="p-0 btn-minus-quantity"><i
                                            class="fas fa-caret-left"></i></button>
                                    <input class="form-control form-control-sm border-0 shadow-0 p-0 txt-quantity"
                                        data-idprouct="{{ $item['id'] }}" type="text"
                                        value="{{ $item['quantity'] }}" />
                                    <button class="p-0 btn-plus-quantity"><i
                                            class="fas fa-caret-right"></i></button>
                                </div>
                            </div>
                        </td>
                        <td class="p-3 align-middle border-light">
                            <p class="mb-0 small">{{ $item['quantity'] * $item['price'] }}</p>
                        </td>
                        <td class="p-3 align-middle border-light">
                            <a class="reset-anchor" data-productid="{{ $item['id'] }}">
                                <span class="spinner-border spinner-border-sm spinner-delete-cart" role="status"
                                    aria-hidden="true" style="margin-right: 5px; display: none;"></span>
                                <i class="fas fa-trash-alt small text-muted" id="spinner-delete-cart"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- CART NAV-->
    <div class="bg-light px-4 py-3">
        <div class="row align-items-center text-center">
            <div class="col-md-6 mb-3 mb-md-0 text-md-start"><a class="btn btn-link p-0 text-dark btn-sm"
                    href="{{ url()->previous() }}"><i class="fas fa-long-arrow-alt-left me-2"> </i>Continue shopping</a>
            </div>
            <div class="col-md-6 text-md-end"><a class="btn btn-outline-dark btn-sm" href="{{ url("checkout") }}">Procesar Pago<i class="fas fa-long-arrow-alt-right ms-2"></i></a></div>
        </div>
    </div>
</div>
<!-- ORDER TOTAL-->
<div class="col-lg-4">
    <div class="card border-0 rounded-0 p-lg-4 bg-light">
        <div class="card-body">
            <h5 class="text-uppercase mb-4">Carro total</h5>
            <ul class="list-unstyled mb-0">
                <li class="d-flex align-items-center justify-content-between"><strong
                        class="text-uppercase small font-weight-bold">Subtotal</strong><span
                        class="text-muted small">{{\Cart::getSubTotal();}}</span></li>
                <li class="border-bottom my-2"></li>
                <li class="d-flex align-items-center justify-content-between mb-4"><strong
                        class="text-uppercase small font-weight-bold">Total</strong><span>{{\Cart::getTotal();}}</span>
                </li>
                <li>
                    <form action="#">
                        <div class="input-group mb-0">
                            <input class="form-control" type="text" placeholder="Enter your coupon">
                            <button class="btn btn-dark btn-sm w-100" type="submit"> <i
                                    class="fas fa-gift me-2"></i>Apply coupon</button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
