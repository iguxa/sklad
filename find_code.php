<?php
/**
 * Created by PhpStorm.
 * User: tsybykov
 * Date: 21.02.19
 * Time: 17:53
 */

require_once ('libs/simple_html_dom.php');
require_once ('config_app.php');
$code  = $_POST['code'] ?? null;
if($code){
    $item = null;
    $product_check =  file_get_contents($api_url.$method['check'].$code);
    if($product_check){
    $item = trim(file_get_contents($api_url.$method['code'].$code));}
    if($item) {
        $details = explode('|', $item);
        ?>
        <div class="d-flex align-items-center justify-content-between flex-wrap custom-flex" id="<?= $details[0] ?>">
            <div class="form-group">
                <label for="exampleInputEmail1">Код</label>
                <input type="email" class="form-control white code" id="exampleInputEmail1" aria-describedby="emailHelp" readonly
                       placeholder="Артикул" value="<?= $details[0] ?>">
                <!--<small id="emailHelp" class="form-text text-muted">Заполнить по коду</small>-->
            </div>
            <div class="form-group ">
                <label for="exampleInputEmail1">Номенклатура</label>
                <input type="text" class="form-control description" value="<?= $details[3] ?>">
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
                <input type="email" class="form-control price " id="exampleInputEmail1"  aria-describedby="emailHelp"
                       placeholder="" value="<?= ceil($details[1]*$coefficient['percent']+$coefficient['always'] ) ?>"
                       data-price="<?= ceil($details[1]*$coefficient['percent']+$coefficient['always'] ) ?>"
                       data-price_supplier="<?= $details[1]?>"
                >
            </div>
        </div>
        <?php
    }else{
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><?=$code?></strong> Нет в наличии
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
<?php
    }
}