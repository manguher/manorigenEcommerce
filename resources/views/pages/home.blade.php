@extends('layout.master')

@section('content')
    <section class="hero pb-3 bg-cover bg-center d-flex align-items-center" style="background: url({{asset('images/hero-banner-alt.jpg')}})">
        <div class="container py-5">
            <div class="row px-4 px-lg-5">
                <div class="col-lg-6">
                    <p class="text-muted small text-uppercase mb-2">Inspiración 2020</p>
                    <h1 class="h2 text-uppercase mb-3">20% descuento</h1><a class="btn btn-dark"
                        href="shop.html">Conoce nuestros productos</a>
                </div>
            </div>
        </div>
    </section>
    <section id="menu" class="menu" style="margin-top: 40px; margin-bottom: 120px;">
        <div class="container" data-aos="fade-up">
            <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">
                @foreach ($category as $key => $cat)
                    <li class="nav-item" data-idcat="{{ $cat['id'] }}">
                        {{-- TODO: Refactor --}}
                        <a class="nav-link {{ $key == '2' ? 'active' : '' }}  show tab-item" data-bs-toggle="tab"
                            data-bs-target="#cat-tab{{ $key }}">
                            <h4> {{ $cat['name'] }}</h4>    
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" data-aos="fade-up" data-aos-delay="300" id="tab-product-home"
                style="position: relative;top: 65px;">
            </div>
        </div>
    </section>
@endsection
