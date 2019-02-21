<?php
/**
 * Created by PhpStorm.
 * User: tsybykov
 * Date: 21.02.19
 * Time: 17:53
 */

require_once ('libs/simple_html_dom.php');

$debug = 1;
$api_url = 'https://anna.trade-in-shop.ru/api-transit/api-itpartners/';
//$api_url = 'https://anna.trade-in-shop.ru/api-transit/api-itpartners/display.php?codebase=all';
$method = ['connect'=>'api-connect.php',
    'code'=>'display.php?codebase=',

];

$code  = $_POST['code'] ?? null;
if($code){
    //$img_html = file_get_html($api_url.$method['connect']);
    $item = trim(file_get_contents($api_url.$method['code'].$code));
    if($item) {
        $details = explode('|', $item);
        ?>
        <div class="d-flex align-items-center justify-content-between flex-wrap" id="<?= $details[0] ?>">
            <div class="form-group">
                <label for="exampleInputEmail1">Код</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       placeholder="Артикул" value="<?= $details[0] ?>">
                <!--<small id="emailHelp" class="form-text text-muted">Заполнить по коду</small>-->
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Номенклатура</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       placeholder="Номенклатура" value="<?= $details[3] ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Количество</label>
                <!--<input type="email" class="form-control quantity" id="exampleInputEmail1" aria-describedby="emailHelp"
                       placeholder="Остаток <?/*= $details[2] */?>" data-quantity="<?/*= $details[2] */?>">-->
                <select class="custom-select custom-select-lg mb-3 quantity" id="exampleInputEmail1">
                    <?php for($i = 1;$i<=$details[2];$i++):?>
                    <option value="<?=$i?>"><?=$i?></option>
                    <?php endfor;?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Цена</label>
                <input type="email" class="form-control price" id="exampleInputEmail1" aria-describedby="emailHelp"
                       placeholder="" value="<?= $details[1] ?>" data-price="<?= $details[1] ?>">
            </div>
        </div>
        <?php


    }
}