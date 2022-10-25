$(document).ready(function () {

    $(".add-cart").click(function (e) {
        $(".spinner-add-cart").show();
        var productId = $(this).data("productid");
        $.ajax({
            url: '/mofront/public/cart/add/' + productId,
            type: 'get',
            success: function (response) {
                console.log(response);
                $("#header-cart").empty();
                $("#header-cart").append(response)
                $(".spinner-add-cart").hide();
            },
            statusCode: {
                404: function () {
                    alert('web not found');
                }
            },
            error: function (x, xs, xt) {
                $(".spinner-add-cart").hide();
                console.log('error: ' + JSON.stringify(x) + "\n error string: " + xs + "\n error throwed: " + xt);
            }
        });
    });

    $(document).on('click', '.reset-anchor', function () {
        var productId = $(this).data("productid");
        if (confirm('Desea eliminar el producto ?')) {
            $(".spinner-delete-cart").show();
            $.ajax({
                url: '/mofront/public/cart/delete/' + productId,
                type: 'get',
                success: function (data) {
                    $("#grid-cart").empty();
                    $("#grid-cart").append(data.htmlGrid);

                    $("#cart-notify").empty();
                    $("#cart-notify").append(data.cartCount)
                    $(".spinner-delete-cart").hide();
                },
                statusCode: {
                    404: function () {
                        alert('web not found');
                    }
                },
                error: function (x, xs, xt) {
                    $(".spinner-delete-cart").hide();
                    console.log('error: ' + JSON.stringify(x) + "\n error string: " + xs + "\n error throwed: " + xt);
                }
            });
        }
        else
            $(".spinner-delete-cart").hide();
    });

    $(document).on('click', '.btn-plus-quantity', function () {
        var productId = $(this).prev(".txt-quantity").data("idprouct");
        $(".spinner-quantity-cart").show();
        $.ajax({
            url: '/mofront/public/cart/addquantity/' + productId,
            type: 'get',
            success: function (data) {
                console.log(data);
                $("#grid-cart").empty();
                $("#grid-cart").append(data.htmlGrid);
                $(".spinner-quantity-cart").hide();
            },
            statusCode: {
                404: function () {
                    alert('web not found');
                }
            },
            error: function (x, xs, xt) {
                $(".spinner-quantity-cart").hide();
                console.log('error: ' + JSON.stringify(x) + "\n error string: " + xs + "\n error throwed: " + xt);
            }
        });

    });

    $(document).on('click', '.btn-minus-quantity', function (e) {
        var productId = $(this).next(".txt-quantity").data("idprouct");
        var quantity = $(this).next(".txt-quantity").val();

        var data = {
            "productId": productId,
            "quantity": parseInt(quantity) - 1,
            "_token": $('meta[name=csrf_token]').attr('content')
        };

        $(".spinner-quantity-cart").show();
        $.ajax({
            url: '/mofront/public/cart/update',
            type: 'post',
            data: data,
            success: function (data) {
                $("#grid-cart").empty();
                $("#grid-cart").append(data.htmlGrid);
                $(".spinner-quantity-cart").hide();
            },
            statusCode: {
                404: function () {
                    alert('web not found');
                }
            },
            error: function (x, xs, xt) {
                $(".spinner-quantity-cart").hide();
                console.log('error: ' + JSON.stringify(x) + "\n error string: " + xs + "\n error throwed: " + xt);
            }
        });

    });
});