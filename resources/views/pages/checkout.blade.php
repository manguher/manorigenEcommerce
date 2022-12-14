@extends('layout.master')
@section('content')
    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">Checkout</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                            <li class="breadcrumb-item"><a class="text-dark" href="index.html">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-dark" href="cart.html">Cart</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <!-- BILLING ADDRESS-->
            <h2 class="h5 text-uppercase mb-4">Detalle Facturación</h2>
            <div class="row">
                <div class="col-lg-8">
                    <form id="form-checkout">
                        <div class="row gy-3">
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase" for="firstName">Nombres</label>
                                <input class="form-control form-control-lg" type="text" id="firstName" name="firstName"
                                    placeholder="Ingrese nombre">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase" for="firstName">Apellido</label>
                                <input class="form-control form-control-lg" type="text" id="lastname" name="lastname"
                                    placeholder="Ingrese apellido">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase" for="email">Email</label>
                                <input class="form-control form-control-lg" type="email" id="email" name="email"
                                    placeholder="e.g. 123@ejemplo.com">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase" for="phone">Telefono</label>
                                <input class="form-control form-control-lg" type="tel" id="phone" name="phone"
                                    placeholder="e.g. +569 123465798">
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase" for="company">Empresa (optional)
                                </label>
                                <input class="form-control form-control-lg" type="text" id="company" name="company"
                                    placeholder="Empresa">
                            </div>

                            {{-- <div class="col-lg-6 form-group">
                                <label class="form-label text-sm text-uppercase" for="country">Pais</label>
                                <select class="country" id="country" name="country"
                                    data-customclass="form-control form-control-lg rounded-0">
                                    <option value>Selecciona pais</option>
                                </select>
                            </div> --}}

                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase" for="state">Seleccione Región </label>
                                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                    id="state" name="state">
                                    <option value='0' selected>Seleccione Región</option>
                                    @foreach ($cities['states'] as $item)
                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label text-sm text-uppercase" for="city">Ciudad </label>
                                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                    id="cities" name="cities">
                                    <option value='0' selected>Seleccione Ciudad</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label text-sm text-uppercase" for="address">Dirección 1</label>
                                <input class="form-control form-control-lg" type="text" id="address1" name="address1"
                                    placeholder="Num Casa y nombre calle">
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label text-sm text-uppercase" for="addressalt">Dirección 2 </label>
                                <input class="form-control form-control-lg" type="text" id="address2" name="address2"
                                    placeholder="Departamento, villa, etc (optional)">
                            </div>

                            <div class="col-lg-6">
                                <button class="btn btn-link text-dark p-0 shadow-0" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#alternateAddress">
                                    <div class="form-check">
                                        <input class="form-check-input" id="alternateAddressCheckbox" type="checkbox">
                                        <label class="form-check-label" for="alternateAddressCheckbox">Dirección de
                                            facturación alternativa</label>
                                    </div>
                                </button>
                            </div>
                            {{-- <div class="collapse" id="alternateAddress">
                                <div class="row gy-3">
                                    <div class="col-12 mt-4">
                                        <h2 class="h4 text-uppercase mb-4">Detalles de facturación alternativos</h2>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label text-sm text-uppercase" for="firstName2">First name
                                        </label>
                                        <input class="form-control form-control-lg" type="text" id="firstName2"
                                            placeholder="Ingrese nombres">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label text-sm text-uppercase" for="lastName2">Last name
                                        </label>
                                        <input class="form-control form-control-lg" type="text" id="lastName2"
                                            placeholder="Enter your last name">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label text-sm text-uppercase" for="email2">Email address
                                        </label>
                                        <input class="form-control form-control-lg" type="email" id="email2"
                                            placeholder="e.g. Jason@example.com">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label text-sm text-uppercase" for="phone2">Phone number
                                        </label>
                                        <input class="form-control form-control-lg" type="tel" id="phone2"
                                            placeholder="e.g. +02 245354745">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label text-sm text-uppercase" for="company2">Company name
                                            (optional) </label>
                                        <input class="form-control form-control-lg" type="text" id="company2"
                                            placeholder="Your company name">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="form-label text-sm text-uppercase" for="countryAlt">Country</label>
                                        <select class="country" id="countryAlt"
                                            data-customclass="form-control form-control-lg rounded-0">
                                            <option value>Choose your country</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label text-sm text-uppercase" for="address2">Address line 1
                                        </label>
                                        <input class="form-control form-control-lg" type="text" id="address2"
                                            placeholder="House number and street name">
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label text-sm text-uppercase" for="addressalt2">Address line 2
                                        </label>
                                        <input class="form-control form-control-lg" type="text" id="addressalt2"
                                            placeholder="Apartment, Suite, Unit, etc (optional)">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label text-sm text-uppercase" for="city2">Town/City </label>
                                        <input class="form-control form-control-lg" type="text" id="city2">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label text-sm text-uppercase" for="state2">State/County
                                        </label>
                                        <input class="form-control form-control-lg" type="text" id="state2">
                                    </div>
                                </div>
                            </div> --}}
                            <input type="hidden" name="total" value="${{ \Cart::getTotal() }}">
                            <div class="col-lg-12 form-group">
                                <button class="btn btn-dark" type="button" id="btn-gopayment">Pagar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- ORDER SUMMARY-->
                <div class="col-lg-4">
                    <div class="card border-0 rounded-0 p-lg-4 bg-light">
                        <div class="card-body">
                            <h5 class="text-uppercase mb-4">Resumen Orden</h5>
                            <ul class="list-unstyled mb-0">
                                @foreach ($cart as $item)
                                    <li class="d-flex align-items-center justify-content-between"><strong
                                            class="small fw-bold">{{ $item['name'] }}</strong><span
                                            class="text-muted small">{{ $item['price'] }}</span>
                                    </li>
                                @endforeach

                                <li class="d-flex align-items-center justify-content-between" style="margin-top: 15px;">
                                    <strong
                                        class="text-uppercase small fw-bold">Total</strong><span>${{ \Cart::getTotal() }}</span>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
