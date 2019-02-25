$( ".counterparty" ).on( "input", function() {
    var data ={'counterparty':$( this ).val()} ;
    get_by_param(data,'/get_counterparty.php','counterparty_append');
});

$(document).on('click','.store_counterparty', function() {
    var data ={'counterparty':$( '.counterparty').val()} ;
    get_by_param(data,'/store_counterparty.php','counterparty_append');
});

$(document).on('click','.remove_agent',function(){
    var id = $(this).parent().find('input').val();
    if(id){
        $('#' + id).remove();
    }
    $('.total_price').val('Пересчитайте');
});
$('.create_order').on('click',function () {
    $('.total').trigger('click');
    var products_param = $('.adder').find('.code').parent().parent(),product = [],reason;
    var counterparty = $('.counterparty_append').find('select').val();
    var supplier = $('.supplier').val();
    var total_price = $('.total_price').val();
    for(var i = 0;i <products_param.length;i++)
    {
        var product_code = {
            'code':$(products_param[i]).find('.code').val(),
            'description':$(products_param[i]).find('.description').val(),
            'quantity':$(products_param[i]).find('.quantity').val(),
            'price':$(products_param[i]).find('.price').val(),
            'price_supplier':$(products_param[i]).find('.price').attr('data-price_supplier'),
        };
        product.push(product_code);
    }
    var order = {
        'counterparty':counterparty,
        'supplier':supplier,
        'total_price':total_price,
        'product':product,
    };
    if(!order.counterparty || !order.supplier || $.isEmptyObject(product)){
        if(!order.counterparty){
            reason = 'контрагент';
        }
        else if(!order.supplier){
            reason = 'поставщик';
        }
        else if($.isEmptyObject(product)){
            reason = 'продукт';
        }
        alert('Не заполнено : '+reason);
        return false;
    }
    var data = {'order':order};
    get_by_param(data,'/create_order.php','download_link');
    return false;

});

$(document).on('click','.find_agent',function(){
    var data =  { 'code':$(this).parent().find('.filter_code').val()};
    if(data.code){
        var id = $(this).parent().find('input').val();
        var code_exist = $('.adder').find('#' + id);
        if(isEmpty(code_exist)){
            get_by_param(data,'/find_code.php','adder',true);
        }
    }
    $('.total_price').val('Пересчитайте');
    $('.filter_code').val('');
});
function isEmpty( el ){
    return !$.trim(el.html())
}
$(document).on('change','.quantity',function () {
    var quantity = $(this).val(),
        price = $(this).parent().parent().find('.price').attr('data-price');
    $(this).parent().parent().find('.price').val(price*quantity);
    $('.total_price').val('Пересчитайте');
});

$(document).on('change','.adder',function () {

    $('.total_price').val('Пересчитайте');
});

$('.total').on('click',function () {
    var price1 = $('.adder').find('.price');
    var total = 0;
    for(var i = 0;i <price1.length;i++)
    {
        total += Number(price1[i].value);
    }
    $('.total_price').val(total);

});
function get_by_param(data,action,to_append = null,pre_append = null,method = 'POST'){
    $.ajax({
        url : action,
        type: method,
        data : data,
        statusCode: {
            422: function(xhr) {
                $.each(xhr.responseJSON.errors, function (index, value) {
                    $(".errors").append('<br>'+value);
                });
            }
        },
        beforeSend: function() {
            $('.modal').show();
        },
    }).done(function(response){ //
        $('.modal').hide();
        if(to_append){
            if(pre_append){
                $('.' + to_append).prepend(response);

            }else{
                $('.' + to_append).html(response);
            }
        }else{
            console.log(response);
        }
    });
}