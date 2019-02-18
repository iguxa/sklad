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
        <div class="first d-flex justify-content-between">
            <div class="  p-5 flex-grow-1">

                <div class="form-group ">
                    <input type="text" class="form-control counterparty" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Контрагент">
                </div>
                <div class="counterparty_append"></div>
                <div class="form-group pb-5">
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Поставщик">
                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Код</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Артикул">
                        <!--<small id="emailHelp" class="form-text text-muted">Заполнить по коду</small>-->
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Номенклатура</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Номенклатура">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Количество</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Цена</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                    </div>
                </div>


                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Код</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Артикул">
                        <!--<small id="emailHelp" class="form-text text-muted">Заполнить по коду</small>-->
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Номенклатура</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Номенклатура">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Количество</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Цена</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                    </div>
                </div>


                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Код</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Артикул">
                        <!--<small id="emailHelp" class="form-text text-muted">Заполнить по коду</small>-->
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Номенклатура</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Номенклатура">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Количество</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Цена</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                    </div>
                </div>
                <div class="total d-flex align-items-center flex-row-reverse  flex-wrap">

                    <div class="form-group">
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Итого">
                    </div>
                    <div class="total_span pr-2">
                        <span>Итого</span>
                    </div>
                </div>


            </div>
            <div class="cart p-5 d-flex flex-column align-items-center">
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
                <div class="message">
                    <div class="alert alert-success" role="alert">
                        Прайс обновлен
                    </div>
                    <div class="alert alert-danger" role="alert">
                        Какая то ошибка
                    </div>
                </div>
                <div class="next">
                    <a class="btn btn-primary" href="#" role="button">Далее</a>
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





    function get_by_param(data,action,to_append = null,method = 'POST'){
        //var form_data = data;
        //var post_url = action; //get form action url
        //var request_method = method; //get form GET/POST method
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
            }
        }).done(function(response){ //
            if(to_append){
                $('.' + to_append).html(response);


            }else{
                console.log(response);

            }

            // window.location.href = '#'+response;
        });
    }




    console.log('here');
    $('.save').on('click',function () {
        console.log('push button');

        event.preventDefault(); //prevent default action
        var post_url = $(this).parent().attr("action"); //get form action url

        var request_method = $(this).parent().attr("method"); //get form GET/POST method
        var form_data = $(this).parent().serialize(); //Encode form elements for submission
        console.log(post_url);
        $(".errors").empty();
        $.ajax({
            url : post_url,
            type: request_method,
            data : form_data,
            statusCode: {
                422: function(xhr) {
                    $.each(xhr.responseJSON.errors, function (index, value) {
                        $(".errors").append('<br>'+value);
                    });
                }
            }
        }).done(function(response){ //
            //$(".test").html(response);
            window.location.href = '#'+response;
        });
        //return  window.location.href = '#articles/articles';
    });

</script>

</body>
</html>