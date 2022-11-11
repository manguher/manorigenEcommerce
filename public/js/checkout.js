$(document).ready(function () {
    $(document).on('click', '#btn-gopayment', function (e) {
        e.preventDefault();
        var data = $("#form-checkout").serialize() + '&_token=' + $('meta[name=csrf_token]').attr('content');
        console.log(data);
        $(".spinner-quantity-cart").show();
        $.ajax({
            url: '/mofront/public/payment',
            type: 'post',
            data: data,
            success: function (data) {
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

    $(document).on('change', '#state', function (e) {
        var idState = $("#state").val();
        $('#cities').empty();
        $.ajax({
            url: '/mofront/public/checkout/getCities/' + idState,
            type: 'get',
            success: function (data) {
                console.log(data);
                $.each(data, function (i, item) {
                    $('#cities').append('<option value="'+item+'">'+item+'</option>');
                });
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