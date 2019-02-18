<?php
/**
 * Created by PhpStorm.
 * User: tsybykov
 * Date: 18.02.19
 * Time: 21:04
 */
$params = $_POST['counterparty'] ?? null;
require_once ('script.php');
if($params){
$agent = new MoySklad();
$counterpartys = $agent->getCounterparty($_POST['counterparty']);?>
    <?php if($counterpartys->rows):?>

        <div class="input-group mb-3">
        <select name="counterparty" class="custom-select" id="inputGroupSelect01">
                <?php foreach ($counterpartys->rows as $counterparty):?>
                    <option value="<?=$counterparty->id?>"><?=$counterparty->name?></option>
                <?php endforeach;?>
        </select>
     </div>
        <?php else: ?>
        <div class="alert alert-warning" role="alert">
            <span>не найдено <b><?=$_POST['counterparty']?></b></span>
        </div>
     <div class="input-group mb-3">
        <input type="text" class="form-control counterparty" id="exampleInputEmail1" value="<?=$_POST['counterparty']?>" aria-describedby="emailHelp" placeholder="">
         <a class="btn btn-primary store_counterparty" href="#" role="button">Создать</a>
    </div>
    <?php endif;?>
<?php }?>



