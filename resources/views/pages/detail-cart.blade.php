@extends('layout.master')

@section('content')
    <div class="container">
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                    <div class="col-lg-6">
                        <h1 class="h2 text-uppercase mb-0">Carro de compras</h1>
                    </div>
                    <div class="col-lg-6 text-lg-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                                <li class="breadcrumb-item"><a class="text-dark" href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Cart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>  
        <section class="py-5">
            <div class="container">
                <h2 class="h5 text-uppercase mb-4">Productos</h2>
                <div class="row" id="grid-cart">
                    @include('pages.grid-cart', ['cart' => $cart])
                </div>
            </div>
        </section>
    </div>
@endsection
