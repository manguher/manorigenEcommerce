$(document).ready(function () {

    $(".add-cart").click(function (e) {
        var productId = $(this).data("productid");
        $.ajax({
            url: '/mofront/public/cart/add/' + productId,
            type: 'get',
            success: function (response) {
                $("#header-cart").empty();
                $("#header-cart").append(response)
                console.log(response);
            },
            statusCode: {
                404: function () {
                    alert('web not found');
                }
            },
            error: function (x, xs, xt) {
                console.log('error: ' + JSON.stringify(x) + "\n error string: " + xs + "\n error throwed: " + xt);
            }
        });
    });

    $(".reset-anchor").click(function (e) {
        var productId = $(this).data("productid");
        if (confirm('Desea eliminar el producto ?')) {
            $.ajax({
                url: '/mofront/public/cart/delete/' + productId,
                type: 'get',
                success: function (data) {
                    $("#grid-cart").empty();                
                    $("#grid-cart").append(data.htmlGrid); 
                    
                    $("#cart-notify").empty();
                    $("#cart-notify").append(data.cartCount)
                },
                statusCode: {
                    404: function () {
                        alert('web not found');
                    }
                },
                error: function (x, xs, xt) {
                    console.log('error: ' + JSON.stringify(x) + "\n error string: " + xs + "\n error throwed: " + xt);
                }
            });
        }
    });


});