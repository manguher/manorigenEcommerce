@extends('layout.master')

@section('content')
    <section id="menu" class="menu" style="margin-top: 40px">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>Nuestros productos</h2>
                <p>Estilo <span>Manorigen</span></p>
            </div>
            <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">
                @foreach ($category as $key => $cat)
                    <li class="nav-item" data-idcat="{{$cat[id]}}>
                        <a class="nav-link {{ $key == '2' ? 'active' : '' }}  show tab-item" data-bs-toggle="tab"
                            data-bs-target="#cat-tab{{ $key }}">
                            <h4> {{ $cat['name'] }}</h4>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="row"></div>
            <div class="tab-content" data-aos="fade-up" data-aos-delay="300" id="tab-product-home"
                style="position: relative;top: 65px;">
            </div>
        </div>
    </section>
@endsection
