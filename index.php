<?php
require_once ('libs/simple_html_dom.php');
require_once ('config_app.php');
if($debug){
    $img_html = file_get_html($api_url.$method['connect']);
    foreach ($img_html->find('img') as $element){
        $element->src = $api_url.$element->src ;
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="asset/style/main.css">

    <title>Hello, world!</title>
</head>
<body>
<div class="content">
    <div class="header d-flex align-items-center mb-1 px-5">
        <div class="label w-50">ЦОС API</div>
        <div class="order w-50">НОВЫЙ ЗАКАЗ</div>
    </div>
    <div class="order_content ">
        <div class="modal"></div>
        <div class="first d-flex justify-content-between">
            <div class="agent  p-5 flex-grow-1">

                <div class="form-group ">
                    <input type="text" class="form-control counterparty" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Контрагент">
                </div>
                <div class="counterparty_append"></div>
                <div class="form-group pb-5">
                    <input type="text" class="form-control white supplier" name="supplier" id="exampleInputEmail1" aria-describedby="emailHelp" readonly placeholder="Поставщик" value="<?=$name?>">
                </div>


<div class="filter">
    <div class="input-group mb-3"><input type="number" class="form-control filter_code" id="exampleInputEmail1" name="bar" placeholder="Артикул">
        <button type="button" class="find_agent btn btn-warning">Добавить</button>
        <button type="button" class="remove_agent btn btn-secondary">Удалить из списка</button>
    </div>
</div>
                <div class="adder"></div>

                <div class="input-group mb-3 d-flex justify-content-end">

<div class="">
                        <input type="email" class=" form-control total_price" readonly id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Итого">
</div><div class="btn_total">
                    <button type="button" class="btn btn-info total">Итого</button></div>

                </div>
                <div class="d-flex justify-content-center download_link">
                </div>
            </div>

            <div class=" d-none">
                <!--cart p-5 d-flex flex-column align-items-center-->
                <div class="clear"><a class="btn btn-warning" href="#" role="button">Отчистить</a>
                </div>
                <div class="save py-2">            <a class="btn btn-success" href="#" role="button">Сохранить заказ</a>
                </div>
                <div class="load">            <a class="btn btn-secondary" href="#" role="button">Сохраненные заказы</a>
                </div>
            </div>
        </div>
        <div class="second">
            <div class="connection d-flex justify-content-around pt-5 align-items-center">
                <div class="refresh">
                    <button type="button" class="btn btn-success">Обновить</button>
                </div>
                <div class="message" >
                    <?= $img_html;?>
                    <!--<div class="alert alert-success" role="alert">
                        Прайс обновлен
                    </div>
                    <div class="alert alert-danger" role="alert">
                        Какая то ошибка
                    </div>-->
                </div>
                <div class="next">
                    <a class="btn btn-primary create_order" href="#" role="button">Далее</a>
                </div>
            </div>
        </div>
    </div>

</div>
<?php include ('script.php');


$agent = new MoySklad();
/*$counterpartys = $agent->storeAgent('Розничный');
var_dump($counterpartys);*/
?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script>
    $( ".counterparty" ).on( "input", function() {
        console.log( $( this ).val() );
        var data ={'counterparty':$( this ).val()} ;
        get_by_param(data,'/get_counterparty.php','counterparty_append');
    });

    $(document).on('click','.store_counterparty', function() {
        console.log( $( this ).val() );
        var data ={'counterparty':$( '.counterparty').val()} ;
        get_by_param(data,'/store_counterparty.php','counterparty_append');
    });

    $(document).on('click','.remove_agent',function(){
        console.log($(this).parent().find('input').val());
        var id = $(this).parent().find('input').val();
        if(id){
            $('#' + id).remove();
        }
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
      // console.log( $(this).parent().find('.filter_code').val());
       var data =  { 'code':$(this).parent().find('.filter_code').val()};
       if(data.code){
            var id = $(this).parent().find('input').val();
            var code_exist = $('.adder').find('#' + id);
            if(isEmpty(code_exist)){
                get_by_param(data,'/find_code.php','adder',true);

            }
       }
    });
    function isEmpty( el ){
        return !$.trim(el.html())
    }
    $(document).on('change','.quantity',function () {
        var quantity = $(this).val(),
        price = $(this).parent().parent().find('.price').attr('data-price');
        $(this).parent().parent().find('.price').val(price*quantity);
        console.log($(this).val());
        console.log(price);

    });
    $('.total').on('click',function () {
        var price1 = $('.adder').find('.price');
        console.log(1);
        var total = 0;
        for(var i = 0;i <price1.length;i++)
        {
             total += Number(price1[i].value);
        }
        $('.total_price').val(total);
        console.log (total);

    });

/*check/обновление - https://anna.trade-in-shop.ru/api-transit/api-itpartners/api-connect.php

наличие по всем ли кодам , кэш, - https://anna.trade-in-shop.ru/api-transit/api-itpartners/check.php?code=136020,136018,139047,43950,40371,40893,287582,1569075,1586798,1587889,160394,1587996,1587833,40594,284429,104095,157197,160402,1587908,1587837

из кэша, отображает что есть https://anna.trade-in-shop.ru/api-transit/api-itpartners/display.php?codebase=all*/



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
</script>

</body>
</html>