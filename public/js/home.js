$(document).ready(function () {
    $(".spinner-grow").show();
    $.ajax({
        url: '/mofront/public/' + 3, // Todo Refactor id categoria estatica
        type: 'get',
        success: function (response) {
            var tablaDatos = $("#tab-product-home");
            tablaDatos.append(response);
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
    
    $(".nav-item").click(function (e) {
        var idCategoriaPadre = $(this).data("idcat");
        $.ajax({
            url: '/mofront/public/' + idCategoriaPadre, // Todo Refactor id categoria estatica
            type: 'get',
            success: function (response) {
                $("#tab-product-home").empty();
                var tablaDatos = $("#tab-product-home");
                tablaDatos.append(response);
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