$(document).ready(function () {
    $(".spinner-grow").show();
    $.ajax({
        url: '/mofront/public/' + 3, // Todo Refactor id categoria estatica
        type: 'get',
        success: function (response) {
            var tabProduct = `<div class="tab-pane fade active show" id="cat${response[0].id_parent_cat}">`; // Todo refactor categoria
            tabProduct += '<div class="row gy-5">'
            response.forEach(element => {
                tabProduct += `<div class="col-lg-4 menu-item">
                                    <a href="{{url('/detalle-producto/${element.id}')}}" class="glightbox">
                                        <img src="${element.url_image_default}" class="menu-img img-fluid" alt="">
                                    </a>
                                        <h4>${element.name}</h4>
                                        <p class="ingredients">
                                            ${element.description_short}
                                        </p>
                                        <p class="price">
                                            ${element.price}
                                        </p>
                                </div>`
            });
            tabProduct += '</div></div>';
            $('#tab-product-home').append(tabProduct);
            $(".spinner-grow").hide();
        },
        statusCode: {
            404: function () {
                alert('web not found');
            }
        },
        error: function (x, xs, xt) {
            //nos dara el error si es que hay alguno
            window.open(JSON.stringify(x));
            //alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
        }
    });

    // submit form send email
    $(".nav-item").click(function (e) {

        var idCategoriaPadre = $(this).data("idcat");
        $.ajax({
            url: '/mofront/public/' + idCategoriaPadre, // Todo Refactor id categoria estatica
            type: 'get',
            success: function (response) {
                $('#tab-product-home').empty();
                var tabProduct = '<div class="tab-pane fade active show" id="cat6">'; // Todo refactor categoria
                tabProduct += '<div class="row gy-5">'
                response.forEach(element => {
                    tabProduct += `<div class="col-lg-4 menu-item">
                                            <a href="{{url('/detalle-producto/${element.id}')}}" class="glightbox">
                                                <img src="${element.url_image_default}" class="menu-img img-fluid" alt="">
                                            </a>
                                            <h4>${element.name}</h4>
                                            <p class="ingredients">
                                                ${element.description_short}
                                            </p>
                                            <p class="price">
                                                ${element.price}
                                            </p>
                                    </div>`
                });
                tabProduct += '</div></div>';
                $('#tab-product-home').append(tabProduct);
            },
            statusCode: {
                404: function () {
                    alert('web not found');
                }
            },
            error: function (x, xs, xt) {
                //nos dara el error si es que hay alguno
                window.open(JSON.stringify(x));
                //alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
            }
        });
    });


});