<div class="tab-pane fade active show" id="menu-starters">
    <div class="tab-header text-center">
        <p>Catehoria</p>
    </div>
    <div class="row gy-5">
        @foreach ($productsHome as $item)
            <div class="col-lg-4 menu-item">
                <a href="{{ url('detalle/' . $item['id']) }}" class="glightbox"><img src="{{ $item['url_image_default'] }}"
                        class="menu-img img-fluid" alt=""></a>
                <h4>{{ $item['name'] }}</h4>
                <p class="ingredients">
                    {{ strip_tags($item['description_short']) }}
                </p>
                <p class="price">
                    ${{$item['price'] }}
                </p>
            </div><!-- Menu Item -->
        @endforeach
    </div>
</div><!-- End Starter Menu Content -->
